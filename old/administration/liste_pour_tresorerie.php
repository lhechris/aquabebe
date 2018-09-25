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
	require_once(DOCUMENT_ROOT."/script/mel.php");
	  	
	define("_TITLE","Consultation pour la tresorerie");
	
	startPage($specific_css);
  
  $saison= $_GET['saison'];
  
  echo "<h2>SAISON $saison </h2>";
  
  //SVG à déplacer éventuellement une fois ok
	function writeListeTresorerie($inscription)
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
		echo "\n  <tr>\n"
			."    <td>".$link_open.$inscription['nom'].$link_close."</td>\n"
			."    <td>".$link_open.$inscription['prenom'].$link_close."</td>\n"
			."    <td>".$inscription['jour']."&nbsp;: ".utf8_encode($inscription['heure'])."</td>\n"
			."    <td>".$inscription['payeur']."</td>\n"
			."    <td>".$inscription['montant']."</td>\n"
			."    <td>".$inscription['remarques']."</td>\n"
      ;
		
		return $inscription;
	}
  	
?>
<div class="validation">
	
	<h4>LISTE POUR LA TRESORERIE</h4>
	
	<table class="validation">
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Créneau</th>
			<th>Payeur</th>
			<th>Montant</th>
      <th>Remarques</th>
		</tr>
		<?php $precedent_valide=getPaiementsValides("writeListeTresorerie",true,$saison);?>
	</table>

</div>

<?php
 stopPage();
?>

</html>


