<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	//$specific_css=array();
	//$specific_css[0]="local.css";
	$specific_css=null;
  define( "_TITLE", htmlentities("FAQ",null,"utf-8",false));
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	require_once(DOCUMENT_ROOT."/lang/fr/faq_index_fr.php");
		
	startPage($specific_css);

  

?>
<h2>QUESTIONS / REPONSES</h2>
<?=_FAQ_01?><br/>
<?=_FAQ_02?><br/>
<?=_FAQ_03?><br/>
<?=_FAQ_04?><br/>
<?=_FAQ_05?><br/>
<?=_FAQ_06?><br/>
<?=_FAQ_07?><br/>
<?=_FAQ_08?><br/>
<?=_FAQ_09?><br/>
<?php
 stopPage();
?>

</html>
