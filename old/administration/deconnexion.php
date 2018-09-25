<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=null;
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	unset($_SESSION["ADMIN"]);
	
	startPage($specific_css);
?>
	<h2>Vous &ecirc;tes d&eacute;connect&eacute; du mode administrateur</h2>

<?php
 stopPage();
?>

</html>


