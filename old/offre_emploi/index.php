<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	//$specific_css=array();
	//$specific_css[0]="local.css";
	$specific_css=null;
  define( "_TITLE", htmlentities("Offre d'emploi",null,"ISO-8859-1",false));
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	require_once(DOCUMENT_ROOT."/lang/fr/offre_emploi_index_fr.php");
		
	startPage($specific_css);

  

?>

<div><?=_OFFRE_EMPLOI?></div>

<?php
 stopPage();
?>

</html>


