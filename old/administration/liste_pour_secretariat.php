<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=null;
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");
	require_once(DOCUMENT_ROOT."/script/creneaux.php");
	  	
	define("_TITLE","Consultation pour la tresorerie");
	
	startPage($specific_css);
  
  $saison= $_GET['saison'];
  
  echo "<h2>SAISON $saison </h2>";
  
  //SVG à déplacer éventuellement une fois ok
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // getInscriptionsValidesForSecretariat() :
  // récupère les données nécessaires pour la liste utile pour le secrétariat
  // ----------------------------------------------------------------------------------------------------------------------------------------------  
	function getInscriptionsValidesForSecretariat($action, $result=null, $saison=SAISON)
  {
    trace("-> getInscriptionsValidesForSecretariat()");
    trace("  saison = $saison");
    
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT  inscription.ID, inscription.ID_enfant, inscription.ID_creneau, 
                      personne.prenom, personne.nom, personne.naissance, personne.mel,
                      creneau.jour, creneau.heure
              FROM  personne, inscription
              LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
              WHERE inscription.ID_enfant = personne.ID
                    AND inscription.paiement IS NOT NULL
                    AND creneau.saison = $saison
              ORDER BY personne.nom;";

		return executeQuery($query,$action,$result);
	}
  
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeListeSecretariat()
  // ----------------------------------------------------------------------------------------------------------------------------------------------
	function writeListeSecretariat($inscription)
	{
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
          ."    <td>".$inscription['nom']." ".$inscription['prenom']."</td>\n"
          ."    <td>".$inscription['mel']."</td>\n"
          ."    <td>".ageEnMois($inscription['naissance'])             ." mois</td>\n"
          ."    <td>".$inscription['jour']."&nbsp;: ".utf8_encode($inscription['heure']) ."</td>\n"
          ;
		
    // récupération des infos des parents via une autre query SQL
    $id_enfant = $inscription['ID_enfant'];
    $saison    = $_GET['saison'];
    $precedent_valide=getEnfantById($id_enfant,"writeListeSecretariat_Suite",true,$saison);
    
		return $inscription;
	}
  
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // writeListeSecretariat_Suite()
  //  Afiche les infos des parents
  // ----------------------------------------------------------------------------------------------------------------------------------------------
	function writeListeSecretariat_Suite($personne)
	{
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
    
    // on affiche le nom des parents 
    // (pas de <tr> car l'affichage se fait sur la même ligne que l'enfant) dans le tableau
		if ($personne_type=="parent")
    {
      echo "    <td>".$personne['nom']." ".$personne['prenom']."</td>\n";
		}
		return $personne;
	}
  	
?>
<div class="validation">
	
	<h4>LISTE POUR LE SECRETARIAT</h4>
	
	<table class="validation">
		<tr>
			<th>Nom & Prénom Enfant</th>
			<th>E-mail</th>
			<th>Date de naissance</th>
			<th>Créneau</th>
			<th>Nom & Prénom Parent 1</th>
			<th>Nom & Prénom Parent 2</th>
		</tr>
		<?php $precedent_valide=getInscriptionsValidesForSecretariat("writeListeSecretariat",true,$saison);?>
	</table>

</div>

<?php
 stopPage();
?>

</html>


