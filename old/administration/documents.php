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
	require_once(DOCUMENT_ROOT."/script/mel.php");
	//require_once(DOCUMENT_ROOT."/script/sms.php");
	
	require_once(DOCUMENT_ROOT."/lang/fr/formulaire_text.php");
	
	define("_TITLE","Liste des inscriptions");
	
	startPage($specific_css);
	
?>

<div class="validation">

<?php
if ($handle = opendir('DOC_ADMIN')) {
    echo "<ul>";
	
    while (false !== ($entry = readdir($handle))) {
        if ($entry!="." && $entry!="..") 
		{
			echo "  <li>$entry</li>";
			echo "  <ul>";
			if ($hdl = opendir("DOC_ADMIN/$entry")) {
				 while (false !== ($entry1 = readdir($hdl))) {
					if ($entry1!="." && $entry1!=".."){
						echo "<li><a href=\"DOC_ADMIN/$entry/$entry1\">$entry1</a></li>";
					}
				 }
				 closedir ($hdl);
			}
			echo "  </ul>";
		}
    }
	
    closedir($handle);
    echo "<ul>";
}
?>  
    
</div>

<?php
 stopPage();
?>

</html>


