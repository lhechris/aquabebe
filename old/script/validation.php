<?php
	
	function callbackSend()
  {		
		
		$con = mysql_connect(HOST,USER,PASSWORD);
		if (!$con) 
    {
			die('Could not connect: ' . mysql_error());
		}
		
		
		$_SESSION["CONNECTED"] = 1;
		mysql_select_db(DATABASE, $con);
		
		
		//debut de la transaction
		mysql_query("START TRANSACTION");
		
		do 
    {
			// verifie si l'enfant est déjà enregistré => inscription déjà enregistrée pour 2016-2017!
      // ---------------------------------------------------------------------------------------------------------------
			$query = "SELECT count(*) > 0 as exist
				FROM	personne 
        INNER JOIN inscription
        ON inscription.ID_enfant = personne.ID
				WHERE	prenom = '".$_POST['prenom']."' 
				AND		nom =  '".$_POST['nom']."'
				AND		naissance = '".formatDate($_POST['naissance'])."'
        AND   ID_creneau > '136';";                 // i.e. saison 2018-2019
			$result = mysql_query($query);  
    
			if((null != $result) && is_resource($result)) 
      {
				$row = mysql_fetch_array($result);
				if($row['exist'])
        {
					mysql_query("ROLLBACK");
					$result=_INSCRIPTION_DEJA_ENREGISTREE;
					sendMailSetInscriptionCheque($ID_inscription);
					break;
				}
			}
			
			// requete enfant qui va se créer au fur et à mesure de l'insertion des personnes
      // ---------------------------------------------------------------------------------------------------
			$query_enfant="INSERT INTO enfant (ID_enfant, ID_personne) VALUES ";
			
			// insertion de la personne : enfant
      // -------------------------------------------
			$query="INSERT INTO personne (prenom,nom,sexe,naissance,handicap,type,adresse,cp,commune,mel,tel,tel2) 
						VALUES ('".utf8_decode($_POST['prenom'])."',
                    '".utf8_decode($_POST['nom'])."',
                    '".$_POST['sexe']."',
                    '".formatDate($_POST['naissance'])."',
                    '".$_POST['handicap']."',
                    'enfant',
                    '".utf8_decode($_POST['adresse'])."',
                    '".$_POST['cp']."',
                    '".utf8_decode($_POST['commune'])."',
                    '".$_POST['mail']."',
                    '".$_POST['tel1']."',
                    '".$_POST['tel2']."');";
			//$execution = mysql_query( $query );
		  trace("query = $query");
      $execution = mysql_query($query) or die('Erreur SQL !<br/>'.$query.'<br/>'.mysql_error());
      trace("retour erreur de sql : ".mysql_error());
			
			if(!$execution)
      {
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
			}
			
			$ID_enfant= mysql_insert_id();
			$query_enfant.="($ID_enfant,$ID_enfant), ";
			
			// insertion de la personne : parent 1
      // ---------------------------------------------
			$query="INSERT INTO personne (prenom,nom,sexe,profession,type,adresse,cp,commune,mel,tel)  
						VALUES ('".utf8_decode(str_replace("'","''",$_POST['prenom_p1']))."',
                    '".utf8_decode($_POST['nom_p1'])."',
                    '".$_POST['sexe_p1']."',
                    '".utf8_decode($_POST['profession_p1'])."',
                    'parent',
                    '".utf8_decode($_POST['adresse_p1'])."',
                    '".$_POST['cp_p1']."',
                    '".utf8_decode($_POST['commune_p1'])."',
                    '".$_POST['mail_p1']."',
                    '".$_POST['tel_p1']."');";
			$execution = mysql_query( $query );
		  trace("query = $query");
      trace("retour erreur de sql : ".mysql_error());
			
			if(!$execution){
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
			}
			
			$ID_parent1= mysql_insert_id();
			$query_enfant.="($ID_enfant,$ID_parent1) ";
			
			// insertion de la personne : parent 2
      // ---------------------------------------------
			if(! is_null($_POST['prenom_p2']) && (0 != strlen($_POST['prenom_p2']))) {
				$query="INSERT INTO personne (prenom,nom,sexe,profession,type,adresse,cp,commune,mel,tel)  
							VALUES ('".utf8_decode(str_replace("'","''",$_POST['prenom_p2']))."',
                      '".utf8_decode($_POST['nom_p2'])."',
                      '".$_POST['sexe_p2']."',
                      '".utf8_decode($_POST['profession_p2'])."',
                      'parent',
                      '".utf8_decode($_POST['adresse_p2'])."',
                      '".$_POST['cp_p2']."',
                      '".utf8_decode($_POST['commune_p2'])."',
                      '".$_POST['mail_p2']."',
                      '".$_POST['tel_p2']."');";
				$execution = mysql_query( $query );
        trace("query = $query");
        trace("retour erreur de sql : ".mysql_error());
				
				if(!$execution){
					mysql_query("ROLLBACK");
					$result=_INSCRIPTION_NON_ENREGISTREE;
					break;
				}
			
				$ID_parent2= mysql_insert_id();
				$query_enfant.=", ($ID_enfant,$ID_parent2)";
			}
			
			// insertion de la personne : accompagnateur
      // --------------------------------------------------------
			if(! is_null($_POST['prenom_a']) && (0 != strlen($_POST['prenom_a']))) {
				$query="INSERT INTO personne (prenom,nom,sexe,profession,type,adresse,cp,commune,mel,tel)  
							VALUES ('".$_POST['prenom_a']."',
                      '".utf8_decode($_POST['nom_a'])."',
                      '".$_POST['sexe_a']."',
                      '".utf8_decode($_POST['profession_a'])."',
                      '".$_POST['lien_a']."',
                      '".utf8_decode($_POST['adresse_a'])."',
                      '".$_POST['cp_a']."',
                      '".utf8_decode($_POST['commune_a'])."',
                      '".$_POST['mail_a']."',
                      '".$_POST['tel_a']."');";
				$execution = mysql_query( $query );
        trace("query = $query");
        trace("retour erreur de sql : ".mysql_error());

				if(!$execution){
					mysql_query("ROLLBACK");
					$result=_INSCRIPTION_NON_ENREGISTREE;
					break;
				}

				$ID_accompagnateur= mysql_insert_id();			
				$query_enfant.=", ($ID_enfant,$ID_accompagnateur)";
			}
			
			// insertion de l'enfant : liens entre les personnes
      // ------------------------------------------------------------
			$execution = mysql_query( $query_enfant );
			if(!$execution){
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
			}
			
			// insertion de l'incription
      // ---------------------------------------------
			if(isset($_SESSION["ADMIN"])) 
      {
				$fields="diffusion_image, diffusion_image_date, diffusion_image_lieu, diffusion_image_signature, reglement_interieur_date, 
                  reglement_interieur_lieu, reglement_interieur_signature, paiement, paiement_date ";
				$values=$_POST['image_diffusion'].",'"
                .formatDate($_POST['image_date'])."','"
                .$_POST['image_lieu']."','"
                .$_POST['reglement_signature']."','"
                .formatDate($_POST['reglement_date'])."','"
                .$_POST['reglement_lieu']."','"
                .$_POST['image_signature']."', 1, NOW()";
			} 
      else 
      {
				$fields="diffusion_image, diffusion_image_date, diffusion_image_lieu, diffusion_image_signature, reglement_interieur_date, 
                  reglement_interieur_lieu, reglement_interieur_signature ";
				$values=$_POST['image_diffusion'].",NOW(),'web','"
                .$_POST['image_signature']."',NOW(),'web','"
                .$_POST['reglement_signature']."'";
			}
      
			$query_inscription = "INSERT INTO inscription (ID_enfant,date_max, ".$fields.")
                            VALUES ($ID_enfant,DATE_ADD(NOW(),INTERVAL 10 DAY),".$values.");";
			$execution = mysql_query( $query_inscription);
      trace("query = $query");
      trace("retour erreur de sql : ".mysql_error());
			
			if(!$execution){
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
			}
			
			$ID_inscription= mysql_insert_id();
			
			// faire les préinscription s et la réservation......
      // ------------------------------------------------------------
			$choixMax=0;
			$tab=array();
			foreach(array_keys($_POST) as $key) 
      {
				$prefix="creneaux_";
				if( (strlen($key)>strlen($prefix)) && (0==substr_compare($key,$prefix,0,strlen($prefix))) )
        {
					$ID_creneau = intval(substr($key,strlen($prefix)));
					$choix = $_POST[$key];
					$tab[$choix]=$ID_creneau;
					$choixMax = max($choixMax, $choix);
				}
			}
			$reservations = getReservations(ALL,putIn,array());
			$notYet=true;
			for ($choix=1;($choix <= $choixMax) && $execution;$choix++)
      {
				$ID_creneau=$tab[$choix];
				$reservation=$notYet && $reservations[$ID_creneau];
				
				$query_preinscription = "INSERT INTO preinscription ( ID_inscription,ID_creneau,choix,reservation)
						VALUES($ID_inscription,$ID_creneau,$choix,".intval($reservation).");";
				$execution = mysql_query( $query_preinscription);
        trace("query = $query");
        trace("retour erreur de sql : ".mysql_error());
				
				if($notYet && $reservation){
					$notYet=false;
				}
			}
			
			if(!$execution){
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
			}
			
			mysql_query("COMMIT");
			
			if ($_POST['paiement_moyen']==_CB){
				$result = sendMailSetInscriptionCB($ID_inscription);
			} else {
				$result = sendMailSetInscriptionCheque($ID_inscription);
				if($_SESSION["ADMIN"]) {
					sendMailSetPaiement($ID_inscription);
				}
			}

		} while (false);
 		
		mysql_close($con);
		$_SESSION["CONNECTED"] = 0;
		
		
		return $result;
	}
	
	

?>
