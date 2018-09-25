<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	//$specific_css=array();
	//$specific_css[0]="local.css";
	$specific_css=null;
  define( "_TITLE", htmlentities("Infos CA",null,"utf-8",false));
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	require_once(DOCUMENT_ROOT."/lang/fr/administration_infos_ca_fr.php");
		
	startPage($specific_css);

  

?>
<h2>COORDONNEES CA & E-MAILS</h2>
<?=_CA_01?>
<?=_CA_02?>
<?=_CA_03?>
<?=_CA_04?>


<?php
 stopPage();
?>

</html>
