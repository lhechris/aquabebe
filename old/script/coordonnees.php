<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/script/trace.php");
  
	function ageEnMois($naissance)
  {
		return round((date('Y')*12+date('m')+date('j')/30)-(substr($naissance,0,4)*12+substr($naissance,5,2)+substr($naissance,8,2)/30),0);
	}
	
	function formatDate($date) 
  {
		$tab = explode("-",$date);
		if (sizeof ($tab)==3) 
    {
			return $tab[2]."/".$tab[1]."/".$tab[0];
		}
		$tab = explode("/",$date);
		if (sizeof ($tab)==3) 
    {
			return $tab[2]."-".$tab[1]."-".$tab[0];
		}
		return null;
	}
	
  // ------------------------------------------------
	// writeNom(enfant)
  // ------------------------------------------------
	function writeNom($enfant)
  {
		//echo "<tr><td class=\"border\">";
		if (0==sizeof($enfant)) 
    {
			echo "&nbsp;";
		} 
    else 
    {
			if(isset($_SESSION["ADMIN"])) 
      {
				echo "<a href=\"".REPOSITORY."/administration/coordonnees.php?id=".$enfant['ID']."\">";
			}
			if($enfant['valide']) 
      {
        echo $enfant["prenom"];
				if(isset($_SESSION["ADMIN"])) 
        {
					echo " ".$enfant['nom']."</a>";
				}
				if(null != $enfant['nom'])
        {
					echo " (".ageEnMois($enfant['naissance'])."&nbsp;mois)";
				}
			} 
      else 
      {
        echo "<span class=\"reservation\">?</span>";
			}
			if(isset($_SESSION["ADMIN"])) 
      {
				echo "</a>";
        if (!$enfant['valide']) 
        {
          echo "\n<EM>&lt ".$enfant["prenom"]." ".$enfant['nom']." &gt</EM>";
        }
      }		
		}
		//echo "</td></tr>";
	}
	
  // ------------------------------------------------
	// writeCoordonnees()
  // ------------------------------------------------
	function writeCoordonnees($personne,$result)
  {
    //trace("-> writeCoordonnees()");
    
    // initialisation des variables
    $personne_type = "";
    
    if (isset($personne['type']))
    {
      $personne_type = $personne['type'];
    }
    else
    {
      //trace("  personne['type'] est NULL");
    }
    
		if ($personne_type=="enfant") 
    {
			if($personne['sexe'])
      {
				$sexe = "fille";
			} 
      else 
      {
				$sexe = "garcon";
			}
		} 
    else 
    {
			if($personne['sexe'])
      {
				$sexe = "feminin";
			} 
      else 
      {
				$sexe = "masculin";
			}
		}
		echo "\n<div class=\"part $sexe\">\n";
		
		if( ($personne_type!="enfant") && ($personne_type!="parent")) 
    {
			$type=" (".$personne_type.")";
		}
		echo "  <h3>".$personne['prenom']." ".$personne['nom']." : ".$personne_type."</h3>\n";
    		
		if ($personne_type=="enfant") 
    {
			$age = ageEnMois($personne['naissance']);
			echo "  <p>$age mois (".formatDate($personne['naissance']).")</p>\n";
		} 
    else 
    {
			echo "  <p>".$personne['profession']."&nbsp;</p>\n";
		}
		
		
		echo "  <p>".$personne['tel']." - ".$personne['tel2']."</p>\n";
		
		if(null != $personne['mel'])
    {
			echo "  <a class=\"mail\" href=\"mailto:".$personne['mel']."\">".$personne['mel']."</a>\n";
		}
		echo "  <address>".$personne['adresse']."<br/>".$personne['cp']." ".$personne['commune']."</address>\n";
		
		echo "</div>";	
		
    //trace("<- writeCoordonnees()");
		if(is_null($result)) 
    {
			return $personne;
		} 
    else 
    {
			return $result;
		}
	}
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeInscription()
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  
	function writeInscription($inscription,$precedent_valide)
  {
		//trace("-> writeInscription()");
    //trace( "   precedenr_valide : $precedent_valide");
    
    echo "\n  <tr>\n"
			."    <td>".$inscription['date_max']."</td>\n"
			."    <td><a href=\"".REPOSITORY."/administration/coordonnees.php?id=".$inscription['ID_enfant']."\">".$inscription['prenom']."</a></td>\n"
			."    <td><a href=\"".REPOSITORY."/administration/coordonnees.php?id=".$inscription['ID_enfant']."\">".$inscription['nom']."</a></td>\n";
      
			if (isset($inscription['naissance'])) 
      {
				echo "    <td>".ageEnMois($inscription['naissance'])." mois</td>\n";
			}
      
			if($inscription['paiement_recu'])  // ok. Cf inscription.php (ligne 412), coordonnees.php (l.156 et 190), dbFunctions2.php (l. 186, 204, 251)
      {
				echo "    <td>Payé</td>\n";
        $precedent_valide=true;  // ajout SVG
			} 
      else 
      {
				//trace( "   inscription : paiement non reçu)";
        
        $precedent_valide=false;
				echo "    <td>\n"
					."      <form method=\"post\" action=\"validation_paiement.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"id\" value=\"".$inscription['ID']."\" />\n"
					."        <input type=\"hidden\" name=\"id_enfant\" value=\"".$inscription['ID_enfant']."\" />\n"
					."        <input type=\"submit\" name=\"xyz\" value=\"Valider un paiement\" />\n"
					."      </form>\n"
					."    </td>\n";
			}
      
			if ($inscription['creneau_affecte']) // ok cf dbFunctions2.php (ligne 203, 221, 268)
      { 
				echo "    <td>".$inscription['jour']."&nbsp;: ".utf8_encode($inscription['heure'])."</td>\n";
			} 
      else if ($inscription['paiement_recu'] && $precedent_valide) 
      {
				$precedent_valide=false;
				echo "    <td>\n"
					."      <form method=\"post\" action=\"validation_creneaux.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"id\" value=\"".$inscription['ID']."\" />\n"
					."        <input type=\"hidden\" name=\"id_enfant\" value=\"".$inscription['ID_enfant']."\" />\n"
					."        <input type=\"submit\" name=\"setCreneau\" value=\"Valider un créneau\" />\n"
					."      </form>\n"
					."    </td>\n";
			} 
      else 
      {
				echo "    <td>".getPreinscriptions($inscription['ID'],"writePreinscriptionInfo",null)."</td>\n";
			}
		echo "  </tr>\n";
		
		return $precedent_valide;
	}
	
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeListeAdministrative()
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  
	function writeListeAdministrative($inscription)
  {
    trace("-> writeListeAdministrative()");
		if(isset($_SESSION["ADMIN"])) 
    {
			$link_open = "<a href=\"".REPOSITORY."/administration/coordonnees.php?id=".$inscription['ID_enfant']."\">";
			$link_close = "</a>";
		} 
    else 
    {	
			$link_open = "";
			$link_close = "";
		}
		echo  "\n  <tr>\n"
          ."    <td>".$link_open.$inscription['prenom'].$link_close         ."</td>\n"
          ."    <td>".$link_open.$inscription['nom'].$link_close            ."</td>\n"
          ."    <td>".ageEnMois($inscription['naissance'])             ." mois</td>\n"
          ."    <td>".$inscription['jour']	."&nbsp;: ".utf8_encode($inscription['heure'])
											." à ".$inscription['lieu']."</td>\n";
		
    writeCertificatMedical($inscription);
    
    writeVaccins($inscription);
		
    echo  "    <td><a href=\"".REPOSITORY."/administration/facture.php?id=".$inscription['ID']."\">Facture</a></td>\n"
          ."  </tr>\n";
		
    
    //trace("<- writeListeAdministrative()");
		return $inscription;
	}
	
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeCertificatMedical()
  // ----------------------------------------------------------------------------------------------------------------------------------------------
	function writeCertificatMedical($inscription)
	{
		if($inscription['certificat_medical'])
		{
			echo "    <td>Certificat m&eacute;dical re&ccedil;u</td>\n";
		} 
		else 
		{
			echo "    <td>\n"
					."      <form method=\"post\" action=\"/administration/index.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"id\" value=\"".$inscription['ID']."\" />\n"
					."        <input type=\"submit\" name=\"setCertificatMedical\" value=\"Déposer le certificat\" />\n"
					."      </form>\n"
					."    </td>\n";
		}
		return $inscription;
	}
	
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeVaccins() : indique si les vaccins ont été vus et validés
  // ----------------------------------------------------------------------------------------------------------------------------------------------
	function writeVaccins($inscription)
	{
		//trace("writeVaccins()");
    
		if($inscription['vaccins'])
		{
			echo "    <td>Vaccins valid&eacute;s</td>\n";
		} 
		else 
		{
			echo "    <td>\n"
					."      <form method=\"post\" action=\"/administration/index.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"id\" value=\"".$inscription['ID']."\" />\n"
					."        <input type=\"submit\" name=\"setVaccins\" value=\"Valider les vaccins\" />\n"
					."      </form>\n"
					."    </td>\n";
		}
		return $inscription;
	}
	
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeFactureRemise() : indique si la facture a été remise aux parents
  // ----------------------------------------------------------------------------------------------------------------------------------------------
	function writeFactureRemise($inscription)
	{
		//trace("writeFactureRemise()");
    
		if($inscription['facture_remise'])
		{
			echo "    <td>remise</td>\n";
		} 
		else 
		{
			echo "    <td>\n"
					."      <form method=\"post\" action=\"/administration/index.php\" enctype=\"multipart/form-data\">\n"
					."        <input type=\"hidden\" name=\"id\" value=\"".$inscription['ID']."\" />\n"
					."        <input type=\"submit\" name=\"setFactureRemise\" value=\"Remettre la facture\" />\n"
					."      </form>\n"
					."    </td>\n";
		}
		return $inscription;
	}
?>
