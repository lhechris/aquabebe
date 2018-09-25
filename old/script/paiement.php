<?php
	define("_CHEQUE",1);
	define("_CB",2);
	
	function getMontant($nbEnfants=1)
  {
		$annee_max=12;
		$mois_max=7;
		$annee = date("y");
		$mois = date("m");
		$adhesion=20;
		if ((18==$annee) && ($mois<=9))
    {
			$cotisation=200;
		} 
    else 
    {
			$cotisation=20*(($annee_max-$annee)*12+$mois_max-$mois);
		}
		$reduction = 1- ( ($nbEnfants-1)*0.1 );
		$total = ($cotisation*$reduction + $adhesion) * $nbEnfants; 
		return $total;
	}
	
	function writePaiement(&$values,$row,$errors)
  {
		$name=$row['name'];
		
		$class="";
		if(isset($errors[$name]))
    {
			$class="class=\"error\"";
		}
		
		$oldValue = "";
    if (isset($_POST[$name]))
    {
      $oldValue = $_POST[$name];
    }
		
		if (isCBEnable($_POST["naissance"])) 
    {
			if (time()>=mktime( 0, 0, 0, 06, 30, 2019)) 
      {
			//CB
				if($oldValue==_CB)
        {
					$select=" checked=\"checked\"";
				} 
        else 
        {
					$select="";
				}
				$values[$name] .= "<br/><input ".$class.$select." type=\"radio\" name=\"".$name."\" value=\""._CB."\">\n"
                        ._PAIEMENT_PAR_CB
                        ."\n"
                        ."</input>\n";
			} 
      else 
      {
				/*
                        $values[$name] .= "<br/><strong>"
                        .htmlentities("Prochainement vous pourrez payer par carte ou par votre compte paypal.",null,"utf-8",false)
                        ."</strong>\n";
                        */
			}
		} 
    else 
    {
			$values[$name] .= "<br/><strong>"
                      // Message d'origine 
                      //.htmlentities("Les créneaux accessibles en fonction de l'âge n'ont plus de place de disponible en dehors 
                      //               de la liste d'attente. Le paiement par CB est donc impossible.",null,"utf-8",false)
                        
                      // bug d'affichage non résolu mais contourné en encodant les caractères é et à 
                      //.htmlentities("Les cr&eacute;neaux accessibles en fonction de l'&acirc;ge n'ont plus de place de disponible en dehors 
                      //               de la liste d'attente. Le paiement par CB est donc impossible.",null,"ISO8859-15",false)
                      ."</strong>\n";
		}
		
		
		//CHEQUE
		if($oldValue==_CHEQUE)
    {
			$select=" checked=\"checked\"";
		} 
    else 
    {
			$select="";
		}				
		$values[$name] .= "<br/><input ".$class.$select." type=\"radio\" name=\"".$name."\" value=\""._CHEQUE."\">\n"
                  .sprintf(_PAIEMENT_PAR_CHEQUE,getMontant())
                  ."\n"
                  ."</input>\n";
						
		//VIREMENT
		/*if($oldValue==_VIREMENT){
			$select=" checked=\"checked\"";
		} else {
			$select="";
		}				
		$values[$name] .= "<br/><input ".$class.$select." type=\"radio\" name=\"".$name."\" value=\""._CHEQUE."\">\n"
						."<strong>".htmlentities("Je choisis de payer par virement.",null,"utf-8",false)."</strong>"
						."<br/>"
						.htmlentities("Finalement le virement risque d'être difficile à gérer pour la trésorerie non ?",null,"utf-8",false)
						."</input>\n";*/
	}
	
	function verify_writePaiement($row)
  {
		$value = $_POST[$row['name']];
		if (($value!=_CHEQUE) && ($value!=_CB)) 
    {
				return _MSG_ERREUR_PAIEMENT;
		}
		return null;
	}
	
	function writeInscriptionPayee($row)
  {
		echo "Je soussign&eacute;e Sylvie CHATAGNER, Pr&eacute;sidente de l'Association Aqua B&eacute;b&eacute;,<br/>"
			."<br/>"
			."Certifie que ".$inscription['genre']." ".$inscription['nom']." ".$inscription['prenom']
			." nous a bien r&eacute;gl&eacute; le montant de la cotisation pour la saison ".SAISON." ".$inscription['moyen'].".<br/>"
    		."La somme pay&eacute;e est de ".$inscription['montant']."&euro; dont 20&euro; d'adh&eacute;sion &agrave; l'association.<br/>"
    		."<br/>"
    		."Cette cotisation concerne l'enfant ".$enfant['prenom']." ".$enfant['nom'].", n&eacute;";
    	if($enfant['sexe']){echo 'e';}
    	echo " le ".$enfant['naissance'].", qui pratique l'activit&eacute; des b&eacute;b&eacute;s nageurs le "
    		.$inscription['jour']." de ".$inscription['heure']."<br/>"
    		."<br/>"
    		."Fait &agrave; Plaisance du Touch, le "/*.getTime()*/."<br/>";

//Signature de la Pr&eacute;sidente et cachet du club ou de l’association.
		return $row;
	
	}

?>
