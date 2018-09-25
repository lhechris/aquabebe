<?php
	
function callbackSend()
{		
    trace("-> callbackSend()");
    
    // Récupération des valeurs rentrées dans le formulaire
    $the_mail     = $_POST['mail'];
    $the_decision = $_POST['continuation'];
		
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
			// verifie si l'enfant est déjà enregistré => inscription déjà enregistrée pour 2010-2011 !
      // ---------------------------------------------------------------------------------------------------------------
			$query = "SELECT count(*)>0 as exist
				FROM	personne 
        INNER JOIN inscription
        ON inscription.ID_enfant = personne.ID
				WHERE	personne.mel = '".$the_mail."' 
        AND   ID_creneau > '9';";                 // i.e. saison 2010-2011
			$result = mysql_query($query); 
			
      trace("query mail : $query");
      trace("result : $result"); 
    
			if((null != $result) && is_resource($result)) 
			{
				$row = mysql_fetch_array($result);
     
				if(!$row['exist'])
				{
					mysql_query("ROLLBACK");
					$result=_MSG_ERREUR_MAIL_3; // l'e-mail ne correspond pas à un e-mail connu pour la saison
					trace("check existence e-mail : $result");
					break;
				}
				if (is_set_demenagement($the_mail))
				{
					mysql_query("ROLLBACK");
					$result=_MSG_ERREUR_MAIL_2; // l'e-mail est déjà enregistré
					trace("check existence e-mail : $result");
					break;
				}
			}
      
      // Récupèration de l'ID de l'enfant (ou d'un des enfants si fratrie)
      // ---------------------------------------------------------------------------------------------------------------
			$query = "SELECT inscription.ID
				FROM	personne 
        INNER JOIN inscription
        ON inscription.ID_enfant = personne.ID
				WHERE	personne.mel = '".$the_mail."' 
        AND   ID_creneau > '9';";                 // i.e. saison 2010-2011
			$result = mysql_query($query);  
      
      // on mémorise l'ID de l'enfant (ou du dernier enfant enregistré dans le cas des fratries
      while($row = mysql_fetch_row($result))
      {
        trace("ID_inscription : $row[0]");
        $ID_inscription = $row[0];
      }
            
			// insertion de la décision pour le déménagement
      // ------------------------------------------------------------
			$query="INSERT INTO demenagement (inscription_id, mel, reponse) 
						VALUES ('$ID_inscription',
                    '".$the_mail."',
                    '".$the_decision."');";
		  $execution = mysql_query($query) or die('Erreur SQL !<br/>'.$query.'<br/>'.mysql_error());
			
		if(!$execution)
		{
				mysql_query("ROLLBACK");
				$result=_INSCRIPTION_NON_ENREGISTREE;
				break;
		}
		else
		{// Alice : j'ai mis en h4 plutôt qu'en h2 pour faire ressortir le message qui les interesse le plus
			$message = "<h4>Votre réponse a bien été enregistrée avec le numéro $ID_inscription et l'e-mail $the_mail.</h4><h2>";
			if ($the_decision)
			{
				$sujet = "Vous avez choisi de continuer l'activité Aqua-Bébé à St Lys";
				$message .= " $sujet.";
        $message .= " </h2><h2>Si cette réponse est incorrecte, merci de contacter demenagement@aquabebe.fr<h2>";
			}
			else
			{
				$sujet = "Vous avez décidé d'arrêter l'activité Aqua-Bébé à St Lys";
				$message .= " $sujet.";
        $message .= " </h2><h2>Si cette réponse est incorrecte, merci de contacter demenagement@aquabebe.fr<h2>";
        $message .= "Le chèque de remboursement sera rendu en mains propres le vendredi 22 avril de 19 h à 20 h au Centre 
                      Rosine Bet à Saint-Lys. Il n'y aura pas denvoi par la poste.";
			}
			
			trace("$message");
        
         $result = sendMail($ID_inscription,$sujet,$message); 
                
        //echo "$message"; //Alice2011 : j'ai mis en result plutôt qu'en écho pour le faire apparaitre dans le tableau cf remarque d'Angélique.

			$result=$message."<h4>$result</h4>";
		}
			
	} while (false);
 		
	mysql_close($con);
	$_SESSION["CONNECTED"] = 0;
		
		
	return $result;
}
	
	

?>
