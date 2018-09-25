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
	
	define("_TITLE","Coordonnées");
	
	startPage($specific_css);
	

?>

	<div class="coordonnees">
		<?php $enfant = getEnfantById($_GET['id'],"writeCoordonnees"); ?>
	</div>
	<div class="preinscriptions">
	    <table>
	    	<?php $inscription = getInscriptionByEnfant($_GET['id'],"writeInscription",true); ?>
			<tr>	    
				<?php writeCertificatMedical($inscription); ?>
			</tr>
		</table>
	</div>
	
	<hr/>
  
	<?php 
    echo "<h2>Créneaux de la saison ".SAISON." </h2><br/>";
    getCreneaux("writeCreneauNewFormat",array(),SAISON);
    stopPage();
?>

</html>


