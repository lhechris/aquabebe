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
	require_once(DOCUMENT_ROOT."/script/creneaux.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");

	define("_TITLE","Créneaux de notre activité");
	
	startPage($specific_css);
  
	echo "<meta http-equiv=\"refresh\" content=\"30;url=index.php\" /> ";
  
	// ---------------------------------------------------------------------
	// Affichage des créneaux de la SAISON  COURANTE
	// ---------------------------------------------------------------------
  
	echo "<h2>A venir - créneaux de la nouvelle saison</h2><br/>";
	
	// --------------------------------------------------------------------
	// Fin de la page
	// --------------------------------------------------------------------
	stopPage();
?>

</html>


