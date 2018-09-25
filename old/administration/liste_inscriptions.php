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
	  	
	define("_TITLE","Consultation des inscriptions");
	
	startPage($specific_css);
    
	$precedent_valide=true;
  
  $saison= $_GET['saison'];
  
  echo "<h2>SAISON $saison </h2>";
  
  //SVG à déplacer éventuellement une fois ok
	function writeListeInscriptions($inscription)
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
          ."    <td>".$inscription['jour']."&nbsp;: ".utf8_encode($inscription['heure']) ."</td>\n"
          ."    <td>".$link_open.$inscription['nom'].$link_close            ."</td>\n"
          ."    <td>".$link_open.$inscription['prenom'].$link_close         ."</td>\n"
          ;
		
    writeCertificatMedical($inscription);
    
    writeVaccins($inscription);
		
    //echo  "    <td><a href=\"".REPOSITORY."/administration/facture.php?id=".$inscription['ID']."\">Facture</a></td>\n"
    echo  "    <td><a href=\"".REPOSITORY."/administration/facture.php?id=".$inscription['ID']."&saison=".$_GET['saison']."\">Facture</a></td>\n";
          
		
    writeFactureRemise($inscription);
	
	echo "</tr>\n";
    return $inscription;
	}
  	
?>
<div class="validation">
	
	<h4>LISTE des PERSONNES INSCRITES avec infos sur CERTIFICAT / VACCIN / FACTURE</h4>
	
	<table class="validation">
		<tr>
			<th>Créneau</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Certificat</th>
			<th>Vaccins</th>
			<th>Facture</th>
			<th> </th>
		</tr>
		<?php $precedent_valide=getInscriptionsValidesByCreneau("writeListeInscriptions",true,$saison);?>
	</table>

</div>

<?php
 stopPage();
?>

</html>


