<?php

  // ----------------------------------------------------------------------
  // writeCreneau () : affichage horizontal des créneaux
  // ----------------------------------------------------------------------
  
	function writeCreneau($creneau,$result)
  {
		echo "<th>\n"
      ."<div class=\"identification\">"
			."  ".$creneau["jour"]."<br/>\n"
			."  ".utf8_encode($creneau["heure"])."<br/>\n"
			."</div>"
			."<a href=\"".REPOSITORY."/creneaux/calcul_age.php?id=".$creneau["ID"]."\" 
           title=\"Enfant né entre le ".formatDate($creneau["naissance_min"])." et le ".formatDate($creneau["naissance_max"])."\">".utf8_encode($creneau["age"])."</a><br/>\n";
		
    if (0<($creneau["disponible"]+$creneau["attente"])) 
    {
			echo "<cite>il y a actuellement<br/>"
			."<span class=\"number\">".$creneau["disponible"]."</span> place(s) disponible(s) et <br/>"
			."<span class=\"number\">".$creneau["attente"]."</span> en attente de validation.</cite>";
		} 
    else 
    {
			echo "<span class=\"complet\">Complet !</span>";
		}
		
    echo "<div class=\"identification border\">"
			."  ".$creneau["jour"]."<br/>\n"
			."  ".utf8_encode($creneau["heure"])."<br/>\n"
			."</div>";
		echo "</th>";
	
		array_push($result,getInscrits($creneau["ID"],"pushIn",array()));
		
		for ($i=sizeof($result[sizeof($result)-1]);$i<$creneau["capacite"];$i++)
    {
			array_push($result[sizeof($result)-1],array());
		}
		return $result;
	}
	
  // ----------------------------------------------------------------------------------
  // writeCreneauNewFormat_Vide() : affichage vertical des créneaux SANS le nom des enfants
  // Cette fonction ne sert que pendant la phase de test et d'inscription des
  // membres du CA
  // ----------------------------------------------------------------------------------
  
	function writeCreneauNewFormat_Vide($creneau,$result)
	{  
		// ********** ATTENTION *******
		// Les modifs dans cette méthode (nov 2013) n'ont pas été testées. 
		// Mais elles ont été testées via la méthode writeCreneauNewFormat()
		// ********** ATTENTION *******
		
		// la valeur du tableau creneau se récupère dans la méthode getCreneaux(action, result, saison)
		// via un sql_query qui récupère les données de la base.
		// Cette méthode getCreneaux() est la seule méthode appelant la méthode writeCreneauNewFormat().
		// --------------------------------------------------------------------------------------------
		$mon_creneau_id       = $creneau["ID"];
		$mon_creneau_dispo    = $creneau["disponible"];
		$mon_creneau_attente  = $creneau["attente"];
		$mon_creneau_naissance_max = $creneau["naissance_max"];
		$mon_creneau_nb_mois_mini = $creneau["nb_mois_mini"];
        
    // Affichage du créneau courant + place dispo
    // ---------------------------------------------------------
    
    trace("creneaux = $creneau");
    trace ("creneau id = $mon_creneau_id");
    
    echo  "<table class=\"creneaux\">";
		echo "<tr align=center>";
    
    echo "<th>";
    echo "<div class=\"identification \">"
        ."  ".$creneau["jour"]."<br/>"
        ."  ".utf8_encode($creneau["heure"])."<br/>";
    echo "</div>";
	echo "</th>";
    
	
	echo "<td>"."à ".$creneau["lieu"]."<br/>"."</td>";
		
    echo "<td>";
		
		// Si l'âge mini pour un créneau est 3 ou 6 mois, l'affichage est modifié pour remplacer date_naissance 
		// par un texte "à partir de 3 ou 6 mois"
		if ($mon_creneau_nb_mois_mini == "3")
		{
		  echo "Enfants nés après le ".formatDate($creneau["naissance_min"])." et de plus de 3 mois";
		}
		else if ($mon_creneau_nb_mois_mini == "6")
		{
		  echo "Enfants nés après le ".formatDate($creneau["naissance_min"])." et de plus de 6 mois";
		}
		else
		{
		  echo "Enfants nés entre le ".formatDate($creneau["naissance_min"])." et le ".formatDate($mon_creneau_naissance_max);
		}
		
		// si créneau fratrie, l'info est affichée
    if ($creneau["pour_fratrie"] == 1)
    {
      echo " <strong><cite> (réservé pour les fratries) </strong></cite> <br/>";
    }
    
	echo "</td>";
	
	// Affichage des cases vides
    //------------------------------------------------------------------
	
    // remplissage du créneau avec des valeurs nulles afin de faire apparaître toutes les cases
	
    echo "<tr align=center>";
	for ($i=0;$i<$creneau["capacite"];$i++)
    {
        echo "<td class=\"border\">";
        echo "<br/></td>";
	} 
    echo "</tr>";
    
    echo "</table>";
	     
    return $result;
    
}
	
  // ----------------------------------------------------------------------------------
  // writeCreneauNewFormat() : affichage vertical des créneaux + nom des enfants
  // ----------------------------------------------------------------------------------
  
	function writeCreneauNewFormat($creneau,$result)
	{  
		trace ("->writeCreneauNewFormat()");
	
		// la valeur du tableau creneau se récupère dans la méthode getCreneaux(action, result, saison)
		// via un sql_query qui récupère les données de la base.
		// Cette méthode getCreneaux() est la seule méthode appelant la méthode writeCreneauNewFormat().
		// --------------------------------------------------------------------------------------------
		$mon_creneau_id       = $creneau["ID"];
		$mon_creneau_dispo    = $creneau["disponible"];
		$mon_creneau_attente  = $creneau["attente"];
		$mon_creneau_naissance_max = $creneau["naissance_max"];
		$mon_creneau_nb_mois_mini = $creneau["nb_mois_mini"];
           
		// Affichage du créneau courant + place dispo
		// ---------------------------------------------------------
		
		trace("creneau = $creneau");
		trace ("creneau id = $mon_creneau_id");
		
		if (strpos($creneau["age"],"Initiation")!==FALSE) {
			echo  "<table class=\"creneaux\ creneauinitiation\">";
			echo '<tr class="nouveaute"><td colspan="6" align="center">Creneau Initiation à la nage</td></tr>';
		} else {
		    echo  "<table class=\"creneaux \">";
		}
		echo "<tr align=center>";
		
		echo "<th>";
		echo "<div class=\"identification \">"
			."  ".$creneau["jour"]."<br/>"
			."  ".utf8_encode($creneau["heure"])."<br/>";
		echo "</div>";
		echo "</th>";
		
		
		echo "<td>"."à ".$creneau["lieu"]."<br/>"."</td>";
			
		echo "<td>";
		
		// Si l'âge mini pour un créneau est 3 ou 6 mois, l'affichage est modifié pour remplacer date_naissance 
		// par un texte "à partir de 3 ou 6 mois"
		if ($mon_creneau_nb_mois_mini == "3")
		{
		  echo "Enfants nés après le ".formatDate($creneau["naissance_min"])." et de plus de 3 mois";
		}
		else if ($mon_creneau_nb_mois_mini == "6")
		{
		  echo "Enfants nés après le ".formatDate($creneau["naissance_min"])." et de plus de 6 mois";
		}
		else
		{
		  echo "Enfants nés entre le ".formatDate($creneau["naissance_min"])." et le ".formatDate($mon_creneau_naissance_max);
		}
		
		// si créneau fratrie, l'info est affichée
		if ($creneau["pour_fratrie"] == 1)
		{
		  echo " <strong><cite> (réservé pour les fratries) </strong></cite> <br/>";
		}
		
		echo "</td>";
			
		if (0<($mon_creneau_dispo+$mon_creneau_attente)) 
		{
			echo "<td>Il y a actuellement : <br/></td>";
		  
			echo "<th><cite> <span class=\"number\"> $mon_creneau_dispo </span> place(s) disponible(s) <br/></th>";
			echo "<th><cite> <span class=\"number\"> $mon_creneau_attente </span> en attente de validation.</cite></th>";
		} 
		else 
		{
			echo "<th>"."<span class=\"complet\">Complet !</span>"."</th>";
		}
		 
		echo "</tr>";
		
		// Récupération des noms et âges des enfants inscrits, par créneau
		// -----------------------------------------------------------------------------------
			
		// on vide la variable $result car sinon les enfants du creneau précédent sont conservés (aucune idée d'où se fait la boucle...)
		$result = array();
			array_push($result,getInscrits($mon_creneau_id,"pushIn",array()));
			
		// remplissage du créneau avec des valeurs nulles s'il manque des enfants, afin de faire apparaître toutes les cases
			for ($i=sizeof($result[sizeof($result)-1]);$i<$creneau["capacite"];$i++)
		{
				array_push($result[sizeof($result)-1],array());
			}
		
		// Affichage des enfants inscrits au créneau courant
		//------------------------------------------------------------------
			
		echo "<tr align=center>";
		
		// $result = tableau double
		// $ enfant = tableau[id_enfant, prenom,nom,date_naissance,boolean]
		// le boolean indique si le créneau est valide ou pas
		foreach($result as $creneau)
		{
		  foreach($creneau as $enfant)
		  {
			echo "<td class=\"border\">";
			writeNom($enfant);
			echo "</td>";
		  }
		}
		
		echo "</tr>";
		
		echo "</table>";
			 
		return $result;
	}
 
  // --------------------------------------------------------------------
  // writeDetailCreneau ()
  // --------------------------------------------------------------------
  
	function writeDetailCreneau($creneau,$result)
  {
		echo "\n"
			."<h3 class=\"identification\"><a href=\"index.php\">"
			."  ".$creneau["jour"]."\n"
			."  ".utf8_encode($creneau["heure"])."\n"
			."</a></h3>"
			."<p>Ce créneau est réservé aux enfants âgé ".utf8_encode($creneau["age"])."<br/>\n"
			."Pour s'inscrire, votre enfant doit être né entre le ".formatDate($creneau["naissance_min"])." et le ".formatDate($creneau["naissance_max"])."</p>\n";
      
		if (0<($creneau["disponible"]+$creneau["attente"])) 
    {
			echo "<cite>il y a actuellement<br/>"
			."<span class=\"number\">".$creneau["disponible"]."</span> place(s) disponible(s) et <br/>"
			."<span class=\"number\">".$creneau["attente"]."</span> en attente de validation par paiement.</cite>";
		} 
    else 
    {
			echo "<span class=\"complet\">Complet !</span>";
		}
	
		if(is_null($result))
    {
			return $creneau;
		}
		
		array_push($result,getInscrits($creneau["ID"],"pushIn",array()));
		
		for ($i=sizeof($result[sizeof($result)-1]);$i<$creneau["capacite"];$i++)
    {
			array_push($result[sizeof($result)-1],array());
		}
		return $result;
		
	}
 
  // --------------------------------------------------------------------
  // writePreinscription ()
  // --------------------------------------------------------------------
	
	function writePreinscription($preinscription,$result)
  {
		echo "\n  <tr>\n"
			."    <td>".$preinscription['choix']."</td>\n"
			."    <td>".$preinscription['jour']."</td>\n"
			."    <td>".utf8_encode($preinscription['heure'])."</td>\n"
			."    <td>";
				
			if(!$preinscription['disponible'])
      {
				$creneau_trouve=false;
				echo "Complet";
			} 
      else 
      { 
				$creneau_trouve=true;
				echo "\n      <form method=\"post\" action=\"index.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"creneau\" value=\"".$preinscription['ID_creneau']."\" />\n"
					."        <input type=\"hidden\" name=\"inscription\" value=\"".$preinscription['ID_inscription']."\" />\n"
					."        <input type=\"submit\" name=\"setCreneau\" value=\"Valider le créneau\"/>\n"
					."      </form>\n";
			}
		echo	"    </td>\n"
			."  </tr>\n";
		return $creneau_trouve||$result;
	}
	
  // --------------------------------------------------------------------
  // writePreinscriptionInfo ()
  // --------------------------------------------------------------------
	function writePreinscriptionInfo($preinscription,$result)
  {
		$preinscriptionInfo = $result ."\n"
			."    ".$preinscription['choix']
			." (".$preinscription['jour']
			." ".utf8_encode($preinscription['heure'])
			." - ".$preinscription['lieu'];
				
		if(!$preinscription['disponible'])
    {
			$preinscriptionInfo .= ": complet !";
		}
		$preinscriptionInfo .= "), \n";

		return $preinscriptionInfo;
	}
	
	function writeValideFreeCreneau($creneau,$result)
  {
		if ($creneau['disponible']>0)
    {
			echo "\n  <tr>\n"
				."    <td>".utf8_encode($creneau['age'])."</td>\n"
				."    <td>".$creneau['jour']."</td>\n"
				."    <td>".utf8_encode($creneau['heure'])."</td>\n"
				."    <td>";
					
				if(!$creneau['disponible'])
        {
					echo "Complet";
				} 
        else 
        { 
					echo "\n      <form method=\"post\" action=\"index.php\" enctype=\"multipart/form-data\">\n"
						."        <input type=\"hidden\" name=\"creneau\" value=\"".$creneau['ID']."\" />\n"
						."        <input type=\"hidden\" name=\"inscription\" value=\"".$result."\" />\n"
						."        <input type=\"submit\" name=\"setCreneau\" value=\"Valider le créneau\"/>\n"
						."      </form>\n";
				}
			echo	"    </td>\n"
				."  </tr>\n";
		}
		return $result;
	}
 
  // ------------------------------------------------------------------------------------------------------------------------------------
  // writeCreneauxByAge () : appelé dans l'étape 3 de l'inscription
  // Indique les créneaux possibles suivant l'âge de l'enfant
  // Les classe en groupes "créneau dispo", "créneau complet avec attente de validation", "créneau fratrie"
  // ------------------------------------------------------------------------------------------------------------------------------------
	
	function writeCreneauxByAge(&$values,$row,$errors)
  {
    trace("-> writeCreneauxByAge()");
    
	$name           = $row['name'];
	$class          = "";
    $msg_dispo      = "";
    $msg_en_attente = "";
    $msg_fratrie    = "";
    $value_msg      = "";    
    $flagPresenceCreneau = false;  // ce flag indique si un créneau est 100% complet (i.e. tous les paiements ont été validées)
    $flagEnAttente       = false;  // ce flag indique si un des créneaux a des places en attente de paiement
    $flagFratrie         = false;  // ce flag indique si un des créneaux fratrie a des places libres ou en attente de paiement

    
    if(isset($errors[$name]))
    {
			$class="class=\"error\"";
		}
		
		$creneaux=getFreeCreneaux($_POST['naissance'],"pushIn",array());
    
		foreach($creneaux as $creneau)
    {
			$value_msg = "";
      
      if($creneau["valide"]) 
      {
        $flagPresenceCreneau = true;
        // inialisation des variables
				$creneauName = $name."_".$creneau['ID'];
				unset($values[$creneauName]);
        
        $post_creneauName = "";
        if (isset($_POST[$creneauName]))
        {
          $post_creneauName = trim($_POST[$creneauName]);
        }
        
        // Couleur blanche : Par défaut
        $color = "#FFFFFF";
        if ($creneau["disponible"] == 0)
        {
          // Couleur jaune :  complet mais avec des personne en attente de validation
          $color = "#FFFF99";
          $flagEnAttente = true;
        }
                    
        if ($creneau["pour_fratrie"] == 1)
        {
          $flagFratrie = true;
        }
        
        // remplissage de la valeur (si le créneau est complet, ce message n'apparait pas)
				$value_msg  .="<input ".$class
                      ." type=\"text\" size=\"1\" style=\"background-color: ".$color
                      ."\" maxlength=\"1\" name=\"".$creneauName
                      ."\" value=\"".$post_creneauName
                      ."\" />"
                      .$creneau["jour"]." ".utf8_encode($creneau["heure"])." "
                      ."(".utf8_encode($creneau["age"])
                      .")"
					  ." - à ".$creneau["lieu"]
					  ."<br/>"
                      ."<cite>il y a actuellement "
                      ."<span class=\"number\">".$creneau["disponible"]."</span> place(s) disponible(s) et "
                      ."<span class=\"number\">".$creneau["attente"]."</span> en attente de validation par paiement.</cite>"
                      ."<br/>";
          
			}
      
      // créneau réservé aux fratries
      if ($creneau["pour_fratrie"] == 1)
      {
        $flagFratrie = true;
        $msg_fratrie .= $value_msg;
      }
      // le créneau est complet mais il y a des places en attente de paiement
      else if ($creneau["disponible"] != 0)
      {
        $msg_dispo .= $value_msg;
      }
      // le créneau a des places libres
      else
      {
        $msg_en_attente .= $value_msg;
      }
		} // End Foreach
    
    //****** TEXTE FINAL ******
    // tous les créneaux possibles sont complets
    if ($flagPresenceCreneau == false)
    {
				$values[$name].=
					"<br/>"."<br/>"
          ."Il n'y a pas de place disponible pour un enfant né le ".$_POST['naissance']
          ."<br/>"."Vous pouvez être informés des places qui se libèrent via le forum d'Aqua-Bébé."
					."<br/>"."<br/>";     


    }
    // il reste des places dispo et/ou en attente de validation de paiement
    else
    {
      $values[$name].= "<strong>Les âges indiqués correspondent à l'âge de l'enfant au 1er septembre.</strong>"
                      ."<br/><br/>"
					  ."<u>LISTE DES CRENEAUX DISPONIBLES :</u>"
                      ."<br/><br/>"
                      .$msg_dispo
                      ."<br/>";
      
      // le message s'affiche si certains créneaux possibles ont des places en attente de paiement
      if ($flagEnAttente == true)
      {
        $values[$name].= "<u>LISTE DES CRENEAUX COMPLETS MAIS AVEC DES PLACES EN ATTENTE DE PAIEMENT :</u>"
                      ."<br/>"
                      ."<strong>Une affectation sur un de ces créneaux ne sera étudiée que si une place se libère.</strong>"
                      ."<br/><br/>"
                      .$msg_en_attente
                      ."<br/>";
      }
      
      // le message ne s'affiche pas si le creneau fratrie est complet (avec tous les paiements validés)
      if ($flagFratrie == true)
      {
        $values[$name].= "<u>CRENEAU(X) RESERVE(S) AUX FRATRIES :</u>"
                      ."<br/>"
                      ."Seules les fratries (2 enfants ou plus) peuvent être inscrites sur ce créneau."
                      ."<br/>"
                      ."<strong>Si l'enfant inscrit ne fait pas partie d'une fratrie, ce créneau lui sera refusé</strong>."
                      ."<br/><br/>"
                      .$msg_fratrie;
      }
    }
    trace("  message affiché : $values[$name]");
    trace("<- writeCreneauxByAge()");
	}	
	
 
  // ------------------------------------------------------------------------------------------------------------------------------------
  // verify_writeCreneauxByAge ($row) 
  // ------------------------------------------------------------------------------------------------------------------------------------
  
	function verify_writeCreneauxByAge($row)
  {
		$name=$row['name'];
		$length=strlen($name)+1;
		
		$vals=array();
		foreach ($_POST as $postName=>$postValue)
    {
			if((strlen($postName)>$length) && (0==substr_compare($postName,$name."_",0,$length)) )
      { 
				if ( (null!=$postValue) && (0!=strlen($postValue))) 
        {
					if (!filter_var($postValue, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[1-9]{1}/")))) 
          {
						return _MSG_ERREUR_CRENEAUX_1;
					}
					array_push($vals,$postValue);
				} 
        else 
        {
					unset ($_POST[$postName]);
				}
			}
		}
		
		// il faut qu'il y ait au moins un créneau identifié comme choix préféré : 1
		if(false === array_search(1,$vals))
    {
			return _MSG_ERREUR_CRENEAUX_2;
		}
		//chaque chiffre ne doit etre utilisé qu'une fois
		if(sizeof($vals)!=sizeof(array_unique($vals)))
    {
			return _MSG_ERREUR_CRENEAUX_3;
		}
		sort($vals);
		//dans le tableau trié, le dernier chiffre doit être égal à la taille du tableau
		if($vals[sizeof($vals)-1]!=sizeof($vals))
    {
			return _MSG_ERREUR_CRENEAUX_4;
		}
		//résumé des 4 tests : le tableau trié ne contient que des chiffres distints compris entre 1 et 9, le 1 étant présent et la dernière valeur étant la taille du tableau, il est donc de la forme 1, 2, 3 .....
		return null;
	}


?>
