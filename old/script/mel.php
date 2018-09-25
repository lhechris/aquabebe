<?php

  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMail()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMail($id,$subject="Aqua-Bébé: message automatique", $message="Notre serveur cherche à vos contacter. Merci de faire répondre à ce message.")
	{
		
		trace ("->sendMail()");
		trace ("  id : $id");
    
		$query= "SELECT p1.prenom as prenom, p1.nom as nom, pn.mel as mel
			FROM personne p1, personne pn, enfant e 
			WHERE	e.ID_personne = pn.ID 
			AND 	pn.mel IS NOT NULL  
			AND 	e.ID_enfant=p1.ID 
			AND 	e.ID_enfant IN (SELECT ID_enfant 
									FROM inscription 
									WHERE ID=$id) 
			GROUP BY pn.mel;";
	
		$result	= executeQuery($query,"pushIn",array());
		
		$prenom = $result[0]['prenom'];
		$nom = $result[0]['nom'];
		$to=null;
		foreach($result as $val)
		{
			if(is_null($to))
			{
				$to = $val['mel'];
			} 
			else 
			{
				$to .= ", ".$val['mel'];
			}
		}
	
		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: contact@aquabebe.fr\r\n";
		$headers .= "Bcc: www-data@aquabebe.fr\r\n";
		
	trace("  to = $to");
	trace("  subject = $subject");
	trace("  prenom = $prenom");
	trace("  message = $message");
	trace("  headers = $headers");

		
		if( mail($to,sprintf($subject,$prenom,$nom), sprintf($message,$prenom,$prenom,$prenom),$headers)) 
		{
			trace("  envoi e-mail OK");
			return htmlentities("Un E-mail vous a été envoyé. Si vous ne l'avez pas reçu dans 24h, merci de contacter 
                          Sandrine (postmaster@aquabebe.fr) afin de vérifier votre adresse et de ne pas bloquer 
                          votre inscription.",null,"utf-8",false);
		} 
		else 
		{
			trace("  envoi e-mail KO");
			return "<span class=\"complet\">".htmlentities("L'E-mail n'a pu vous être envoyé. Merci de contacter Sandrine 
                                                    (postmaster@aquabebe.fr) afin de vérifier votre adresse et de ne 
                                                    pas bloquer votre inscription.",null,"utf-8",false)
                                        ."</span>";
		}
	}
	
	
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailDoc()
  // E-m ail envoyé aux parents après inscription via le site (appelé par les méthodes CB et cheque)
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMailDoc($id,$fichier , $typemime ,$nomFichier,
                        $sujet="Aqua-Bébé: message automatique", 
                        $message="Notre serveur cherche à vous contacter. Merci de répondre à ce message.")
  {
		trace("-> sendMailDoc()");
		$from="contact@aquabebe.fr";
		$bcc="www-data@aquabebe.fr";
		$prenom = "";
		$nom = "";
		
		$query= "SELECT p1.prenom as prenom, p1.nom as nom, pn.mel as mel
			FROM personne p1, personne pn, enfant e 
			WHERE	e.ID_personne = pn.ID 
			AND 	pn.mel IS NOT NULL  
			AND 	e.ID_enfant=p1.ID 
			AND 	e.ID_enfant IN (SELECT ID_enfant 
									FROM inscription 
									WHERE ID=$id) 
			GROUP BY pn.mel;";
	
		$result	= executeQuery($query,"pushIn",array());
		
		if (isset($result[0]['prenom']))
		{
			$prenom = $result[0]['prenom'];
		}
    
		if (isset($result[0]['nom']))
		{
			$nom = $result[0]['nom'];
		}
    
		$sujet = sprintf($sujet,$prenom,$nom);
		$message = sprintf($message,$prenom,$nom);
    
    //echo "SVG : prenom=$prenom  ;  nom=$nom  ;  sujet=$sujet  ;  message=$message";
		
		$to=null;
		foreach($result as $val)
		{
			if ( (!is_null($val['mel'])) && (0 !=strlen($val['mel']))) 
			{
				if(is_null($to))
				{
					$to = $val['mel'];
				} 
				else 
				{
						$to .= ", ".$val['mel'];
				}
			}
		}
		
	$limite = "_parties_".md5(uniqid (rand()));
	
	$mail_mime = "Date: ".date("D, d F Y H:i:s O (T)")."\n";
	$mail_mime .= "MIME-Version: 1.0\n";
	$mail_mime .= "Content-Type: multipart/mixed;\n";
	$mail_mime .= " boundary=\"----=$limite\"\n\n";

	//Le message en texte simple pour les navigateurs qui n'acceptent pas le HTML
	$texte  = "This is a multi-part message in MIME format.\n";
	$texte .= "Ceci est un message est au format MIME.\n";
	$texte .= "------=$limite\n"; 
	$texte .= "Content-Type: text/html; charset=\"utf-8\"\n";
	$texte .= "Content-Transfer-Encoding: 7bit\n\n";
	$texte .= $message;
	$texte .= "\n\n";
  

	//le fichier
	$attachement = "------=$limite\n";
	$attachement .= "Content-Type: $typemime; name=\"$nomFichier\"\n";
	$attachement .= "Content-Transfer-Encoding: base64\n";
	$attachement .= "Content-Disposition: attachment; filename=\"$nomFichier\"\n\n";

	$fd = fopen( $fichier, "r" );
	$contenu = fread( $fd, filesize( $fichier ) );
	fclose( $fd );
	$attachement .= chunk_split(base64_encode($contenu));

	$attachement .= "\n\n\n------=$limite\n"; 

	trace("  to = $to");
	trace("  sujet = $sujet");
	trace("  texte = $texte");
	trace("  Bcc = $bcc");
	trace("  from = $from");
	trace("  mail_mime = $mail_mime");
	
		if( mail($to, $sujet, $texte.$attachement, "Bcc:$bcc\nFrom:$from\n".$mail_mime)) 
		{
			trace("  envoi e-mail OK");
			return _ENVOI_MESSAGE_OK;
		} 
		else 
		{
			trace("  envoi e-mail KO");
			return _ENVOI_MESSAGE_KO;
		}
	}
	
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetPaiement()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMailSetPaiement ($id,$result=null) 
  {
		return sendMail($id,_SUJET_PAIEMENT,_MESSAGE_PAIEMENT);
	}

  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetCreneau(): envoi un e-mail aux parents indiquant le créneau validé pour leur enfant
  //     méthode appelée dans validation/index.php
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMailSetCreneau($id,$result=null)
  {
	    $query= "SELECT creneau.jour, creneau.heure, creneau.lieu
			FROM 	inscription, creneau 
			WHERE 	inscription.ID = $id
			AND 	inscription.ID_creneau = creneau.ID;";
	
		$result	= executeQuery($query,"pushIn",array());
		
		$jour = $result[0]['jour'];
		$heure = $result[0]['heure'];
		$lieu  = $result[0]['lieu'];
		
		return sendMail($id,_SUJET_CRENEAU,sprintf(_MESSAGE_CRENEAU,"%s",$jour,$heure,$lieu,"%s","%s","%s"));
	}
	
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetInscriptionCB()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMailSetInscriptionCB($id,$result=null)
  {
		return sendMailDoc($id,
                        DOCUMENT_ROOT."/doc-pub/AQUABEBE-Documents-inscription.pdf",
                        "application/pdf",
                        "AQUABEBE-Documents-inscription.pdf",
                        _SUJET_INSCRIPTION,
                        _MESSAGE_INSCRIPTION_2);
	}
  
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetInscriptionCheque()
  // E-mail envoyé aux parents après inscription sur le site
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	 
	function sendMailSetInscriptionCheque($id,$result=null)
  {
    return sendMailDoc($id,
                        DOCUMENT_ROOT."/doc-pub/AQUABEBE-Documents-inscription.pdf",
                        "application/pdf",
                        "AQUABEBE-Documents-inscription.pdf",
                        _SUJET_INSCRIPTION,
                        _MESSAGE_INSCRIPTION_1);
	}
  
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetCertificatMedical()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function sendMailSetCertificatMedical($id,$result=null)
  {
	    return sendMail($id,_SUJET_CERTIFICAT,_MESSAGE_CERTIFICAT);
	}
  
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailSetVaccins()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function sendMailSetVaccins($id,$result=null)
  {
	    return sendMail($id,_SUJET_VACCINS,_MESSAGE_VACCINS);
	}
  
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
  // sendMailByCreneaux()
  // -------------------------------------------------------------------------------------------------------------------------------------------------------------
	function sendMailByCreneaux($creneaux,
                              $subject="message automatique", 
                              $msgtext="Notre serveur cherche à vous contacter. Merci de répondre à ce message.",
							  $fichier)
  {
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
		
    // on cherche la liste des adhérents correspondant aux créneaux demandés
    // ---------------------------------------------------------------------------------------------
		$query= "SELECT p1.prenom as prenom, p1.nom as nom, pn.mel as mel
			FROM personne p1, personne pn, enfant e 
			WHERE	e.ID_personne = pn.ID 
			AND 	pn.mel IS NOT NULL  
			AND 	e.ID_enfant=p1.ID 
			AND 	e.ID_enfant IN (SELECT ID_enfant 
									FROM inscription 
									WHERE ID_creneau IN $ids) 
			AND		pn.mel IS NOT NULL
			GROUP BY pn.mel;";
	
		$result	= executeQuery($query,"pushIn",array());
		
		$prenom = $result[0]['prenom'];
		$nom = $result[0]['nom'];
		$to = NULL;
		foreach($result as $val)
    {
			if(is_null($to))
      {
				$to = $val['mel'];
			} 
      else 
      {
				$to .= ", ".$val['mel'];
			}
		}
    
    // on cherche l'e-mail du maitre-nageur associé aux créneaux demandés
    // ---------------------------------------------------------------------------------------------
    // avec base de test : SELECT DISTINCT jour FROM `creneau` WHERE ID IN (10,11,12,13)
    
    
    //trace("ID creneau : $ids");
    $query2  = "SELECT DISTINCT jour,lieu FROM `creneau` WHERE creneau.ID IN $ids;";
		trace($query2 );
    
    $result	= executeQuery($query2,"pushIn",array());
    //$taille = count($result);
    //echo ("<br/>taille tableau $taille<br/>");
    foreach($result as $val)
    {
      //echo ("val : $val[0]<br/>");
	  if (strcasecmp($val[1],"saint-lys")==0) {
	      $lieu=".st-lys";
	  } else if (strcasecmp($val[1],"Villeneuve-Tolosane")==0) {
	      $lieu=".villeneuve";
	  } else {
		  $lieu="";
	  }
      $to .= ", "."mns.".$val[0].$lieu."@aquabebe.fr";
    }
    trace("to : $to");
 
	
    // Envoi du message aux adhérents du créneau sélectionné
    // ------------------------------------------------------------------------
		//=====Création de la boundary. Pour separer les differentes zones
		$boundary = "-----=".md5(rand());
		//==========		
		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = "MIME-Version: 1.0\r\n";
		if ($fichier=="") {
		    $headers .= "Content-type: text/html; charset=utf-8\r\n";
		} else  {
			$headers  .= "Content-Type: multipart/mixed;\n boundary=\"$boundary\"\n";
		}
		$headers .= "From: contact@aquabebe.fr\r\n";
		$headers .= "Bcc: www-data@aquabebe.fr,".$to."\r\n";
		
		$subject = "Aqua-Bébé : ".$subject;
		
		//=====Création du message.
	    if ($fichier!="") {$messagehdr = "\n--".$boundary."\n";}
		
		//=====Ajout du message au format texte.
		$msgtext = str_replace( "\r\n", "<br/>",htmlentities( $msgtext,null,"utf-8",false));
		if ($fichier!="") {
			$messagehdr.= "Content-Type: text/html; charset=\"utf-8\"\n";
			$messagehdr.= "Content-Transfer-Encoding: 8bit\n";
		}

		//==========		

		//=====Ajout de la pièce jointe.
		$messageattach="";
		if ($fichier!="")
		{
			//Lecture et mise en forme de la pièce jointe.{
			$pathfichier=pathinfo($fichier);
			$fichdl   = fopen($fichier, "r");
			$attachement = fread($fichdl, filesize($fichier));
			$attachement = chunk_split(base64_encode($attachement));
			fclose($fichdl);
	
			$messageattach.= "\n--".$boundary."\n";
			$messageattach.= "Content-Type: application/".$pathfichier['extension']."; name=\"".$pathfichier['basename']."\"\n";
			$messageattach.= "Content-Transfer-Encoding: base64\n";
			$messageattach.= "Content-Disposition: attachment; filename=\"".$pathfichier['basename']."\"\n";
			$messageattach.= "\n".$attachement."\n\n";
		}
		//========== 
		$message=$messagehdr;
		$message.= "\n".$msgtext."\n";
		$message.=$messageattach;
		if ($fichier!="") {$message.= "\n--".$boundary."--\n"; }
		
		if( mail(null,$subject,$message ,$headers)) 
    {
			echo htmlentities("E-mail envoyé à : ",null,"utf-8",false).$to."<br/><strong>".htmlentities($subject,null,"utf-8",false)."</strong> <br/><quote>".$message."</quote>";
		} 
    else 
    {
			return "<span class=\"complet\">".htmlentities("L'E-mail n'a pas pu être envoyé. Merci de contacter le postmaster (postmaster@aquabebe.fr).",null,"utf-8",false)."</span>";
		}
    // Envoi du même message à contact@ en rajoutant la liste des adresses e-mails utilisées
    // -------------------------------------------------------------------------------------------------------------
		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = "MIME-Version: 1.0\r\n";
		if ($fichier=="") {
		    $headers .= "Content-type: text/html; charset=utf-8\r\n";
		} else  {
			$headers  .= "Content-Type: multipart/mixed;\n boundary=\"$boundary\"\n";
		}
		$headers .= "From: contact@aquabebe.fr\r\n";
		$headers .= "To: contact@aquabebe.fr\r\n";
		$headers .= "Bcc: www-data@aquabebe.fr\r\n";
		
		$subject = $subject; // aucun changement p/r au sujet d'origine
		
		$message=$messagehdr;
        $message.= "\r\nListe des e-mails contactés : ".$to."\r\n";
		$message.= "\n".$msgtext."\n";
		$message.=$messageattach;
		if ($fichier!="") {$message.= "\n--".$boundary."--\n"; 	}	
		
		if( mail(null,$subject,$message ,$headers)) 
    {
			return htmlentities("E-mail envoyé à contact@aquabebe.fr ",null,"utf-8",false)."<br/><strong>".htmlentities($subject,null,"utf-8",false)."</strong> <br/><quote>".$message."</quote>";
		} 
    else 
    {
			return "<span class=\"complet\">".htmlentities("L'E-mail n'a pas pu être envoyé. Merci de contacter le postmaster (postmaster@aquabebe.fr).",null,"utf-8",false)."</span>";
		}
	}
		
?>
