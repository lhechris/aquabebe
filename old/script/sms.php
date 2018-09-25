<?php

// -----------------------------------------------------------------------------------------------------------
// sendOneSMS()
// -----------------------------------------------------------------------------------------------------------
	function sendOneSMS($var_to,
                      $var_message)
  {
    trace("==> sendOneSMS()");
    
    $nbSMSrestants = -1;
    
		/* Info sur l'API d'OVH Manager pour envoyer des SMS
                Attention : le fichier doit être en php5. Le mieux est de l'appeler xx.php5
                
                int telephonySmsSend(string session, string smsAccount, string numberFrom, string numberTo, string message, int smsValidity, int smsClass, int smsDeferred, int smsPriority)
                Description
                    Send a SMS
                Paramètres
                     * stringsession : the session id
                     * stringsmsAccount : the SMS account
                     * stringnumberFrom : the number from
                     * stringnumberTo : the number to
                     * stringmessage : the message
                     * intsmsValidity : the maximum time -in minute(s)- before the message is dropped, defaut is 48 hours
                     * intsmsClass : the sms class: flash(0),phone display(1),SIM(2),toolkit(3), default is 1
                     * intsmsDeferred : the time -in minute(s)- to wait before sending the message, default is 0
                     * intsmsPriority : the priority of the message (0 to 3), default is 3
                Retour
                    the SMS id 
                
                $result = $soap->telephonySmsSend(connexion_au_manager, "compte_sms", "numero_de_l_expediteur", "numero_du_destinataire", "message_du_sms", "temps_pour_l_envoi", "type_de_sms", "temps_avant_envoi", "priorite_du_sms");
                
                avec les paramètres par défaut :
                  $result = $soap->telephonySmsSend($session, "sms-xx123456-1", "+33600110011", "numero_du_destinataire", "$message", "", "1", "", "");
        
    */
    
    // nic-handle d'OVH
    $nic="ab8241-ovh";
        
    // mot de passe du nic-handle
    $pass="campa31";
    
    // nom du compte SMS
    $sms_compte="sms-ab8241-1";
    
    // numéro émetteur du SMS (il doit être identifié dans OVH manager)
    $from="+33972116639";
    
    // destinataire
    $to = $var_to;
    
    // message
    $message = $var_message;
    
    /*trace("nic : $nic");
    trace("pwd : $pass");
    trace("sms_compte = $sms_compte");
    trace("from = $from");
    trace("to = $to");
    trace("message = $message");*/
    
    
    // ouverture de la fonction soapi
    try
    {
      $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl");
    
      /* connexion a votre manager avec vos identifiants, ici on utilise
                le compte xx123456-ovh ($nic) avec le mot de passe ovh123456 ($pass), le nic-handle est francais */
      $session = $soap->login("$nic", "$pass","fr", false);

      // affichage de la reponse pour la connexion
      trace("login successfull");

      /* on utilise ici le compte sms sms-xx123456-1 ($sms_compte) pris sur notre nic-handle xx123456-ovh,
                le numero 06600110011 ($from) a ete identifie dans notre manager on l utilise donc en tant
                qu emetteur, le desinataire se place ensuite ($to), la variable $message contient le texte du sms, le vide permet de laisser
                les parametres par defaut, le "1" force l envoi du sms au format classique,
                le sms est sauvegarde sur le portable client */
    //  $result = $soap->telephonySmsSend($session, $sms_compte, "$from", "$to", "$message", "", "1", "", "");

      // affichage de l etat
      trace("telephonySmsSend successfull");

      // affichage du resultat
      print_r($result);
      trace("result : $result");
      
       //telephonySmsCreditLeft
      $nbSMSrestants = $soap->telephonySmsCreditLeft($session, $sms_compte);
      trace("telephonySmsCreditLeft successfull");
      trace("nb de SMS restants : $nbSMSrestants");

      // on ferme la connexion au manager
      $soap->logout($session);
      // affichage de la reponse de fermeture de connexion
      trace("logout successfull");
    }

    catch(SoapFault $fault)
    {
      // affichage des erreurs
      trace($fault);
    }
    return $nbSMSrestants;
	}
	
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendSMSByCreneaux()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendSMSByCreneaux( $var_creneaux, 
                              $var_message="Aqua-BB cherche à vous contacter. Merci de nous re-contacter par e-mail.")
  {
    trace("==> sendSMSByCreneaux()");
    
		$creneaux = $var_creneaux;
    $message  = $var_message;
    
    $ids="(";
		foreach ($creneaux as $id)
    {
			if($ids!="(")
      {
				$ids .= ", ";	
			}
			$ids .= $id;	
		}
		$ids .= ")";	
		
    // on cherche les numéros de téléphone des adhérents correspondant aux créneaux demandés
    // --------------------------------------------------------------------------------------------------------------------
    trace("ids : $ids <br/>");
    /* REQUETE OK
		SELECT p1.prenom as prenom, p1.nom as nom, pn.tel as tel
			FROM personne p1, personne pn, enfant e 
			WHERE	e.ID_personne = pn.ID 
			AND 	pn.tel IS NOT NULL  
			AND 	e.ID_enfant=p1.ID 
			AND 	e.ID_enfant IN (SELECT ID_enfant 
									FROM inscription 
									WHERE ID_creneau IN (10,11,12,13,14,15)) 
			AND		pn.tel IS NOT NULL
			GROUP BY pn.tel;
    */
		$query= 
    "
      SELECT p1.prenom as prenom, p1.nom as nom, pn.tel as tel
			FROM personne p1, personne pn, enfant e 
			WHERE	e.ID_personne = pn.ID 
			AND 	pn.tel IS NOT NULL  
			AND 	e.ID_enfant=p1.ID 
			AND 	e.ID_enfant IN (SELECT ID_enfant 
                            FROM inscription 
                            WHERE ID_creneau IN $ids) 
			AND		pn.tel IS NOT NULL
			GROUP BY pn.tel;
    ";
	
		$result	= executeQuery($query,"pushIn",array());
		
		$prenom = $result[0]['prenom'];
		$nom = $result[0]['nom'];
		$to = NULL; // va contenir l'ensemble des tels contactés (pour l'e-mail de récap à contact@)
    
		foreach($result as $val)
    {
      // on retire les "." et les " "
      $val_i = $val['tel'];
      //trace("val_i (before) : $val_i");
      $val_i = preg_replace("#[.| ]#","",$val_i);
      //trace("val_i (after) : $val_i");
      
      // on ne garde que les numéros de portable
      if (preg_match("#^06#",$val_i))
      {
        if(is_null($to))
        {
          $to = $val_i;        
        } 
        else 
        {
          $to .= ", ".$val_i;
        }
        // ENVOI DU SMS
        $nbSMSRestants = sendOneSMS($val_i, $message);
			}
		}
    trace("to : $to");
  
	
    // Envoi du même message à contact@ en rajoutant la liste des téléphones contactés : TBC - ATTENTION : envoi de num de tel par Internet n'est pas hyper secure
    // POSSIBLE : Si message d'erreur lors envoi SMS, envoyer un e-mail à contact@ en indiquant de qui il s'agit (si possible à connaître)
    // -------------------------------------------------------------------------------------------------------
		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: contact@aquabebe.fr\r\n";
		$headers .= "To: contact@aquabebe.fr\r\n";
		$headers .= "Bcc: www-data@aquabebe.fr\r\n";
		
		$subject = "SMS envoyé via Site Web";
		
    $message .= "\r\nListe des tels contactés : ".$to;
    $message .= "\r\nNombre de SMS restants : ".$nbSMSRestants."\r\n";
		$message = str_replace( "\r\n", "<br/>",htmlentities( $message,null,"utf-8",false));
    
    trace("e-mail : \n   sujet = $subject\n   message = $message");
		
		if( mail(null,$subject,$message ,$headers)) 
    {
			return htmlentities("E-mail envoyé à contact@aquabebe.fr ",null,"utf-8",false)."<br/><strong>".htmlentities($subject,null,"utf-8",false)."</strong> <br/><quote>".$message."</quote>";
		} 
    else 
    {
			return "<span class=\"complet\">".htmlentities("L'E-mail n'a pas pu être envoyé. Merci de contacter Florent (postmaster@aquabebe.fr).",null,"utf-8",false)."</span>";
    }
  }
		
?>
