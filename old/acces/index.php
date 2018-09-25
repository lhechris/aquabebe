<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=array();
	$specific_css[0]="acces.css";
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	require_once(DOCUMENT_ROOT."/lang/fr/acces_index_fr.php");
		
	startPage($specific_css);
  

?>
  
    <div id="index_p1" class="right"><?=_LOCAL_P1?></div>
	<div id="index_p2" class="left"><?=_LOCAL_P2?></div>

<?php
 stopPage();
?>

</html>


