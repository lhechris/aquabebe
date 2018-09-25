<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=null;
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	$_SESSION["ADMIN"]=true;
	
	startPage($specific_css);
?>
	<h2>Vous &ecirc;tes connect&eacute; en tant qu'administrateur</h2>

<?php
 stopPage();
?>

</html>


