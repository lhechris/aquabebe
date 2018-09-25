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
	require_once(DOCUMENT_ROOT."/script/paiement.php");
	
	define("_TITLE","Valider un créneau");
	
	startPage($specific_css);
	

?>

	<div class="coordonnees">
		<?php $enfant = getEnfantById($_POST['id_enfant'],"writeCoordonnees"); ?>
	</div>
	<div class="preinscriptions">
		<table class="preinscription">
			<tr>
				<th>Choix</th>
				<th>Jour</th>
				<th>Heure</th>
				<th>Disponibilité</th>
			</tr>
			<?php $creneau_trouve = getPreinscriptions($_POST['id'],"writePreinscription",null); ?>
		</table>


		<?php if(!$creneau_trouve){ ?>
			<h4>Aucun des créneaux choisis n'est disponible pour cet enfant. Voici les créneaux auquel il peut s'inscrire compte tenu de son age&nbsp;:</h4>
			<table class="preinscription">
				<tr>
					<th>Ages</th>
					<th>Jour</th>
					<th>Heure</th>
					<th>Disponibilité</th>
				</tr>
				<?php $creneau_trouve = getFreeCreneaux($enfant['naissance'],"writeValideFreeCreneau",$_POST['id']); ?>
			</table>
		<?php	} ?>
		
	</div>

	<hr/>
	<table class="creneaux">
		<tr>
			<?php $result = getCreneaux("writeCreneau",array()); ?>
		</tr>
		<tr>
			<?php foreach($result as $creneau){ ?>
				<td>
					<table>
						<?php 
              foreach($creneau as $enfant)
              {
                echo "<tr><td class=\"border\">";
                writeNom($enfant);
                echo "</td></tr>";
              }	
            ?>	
					</table>
				</td>
			<?php }	?>
		</tr>
	</table>
<?php
 stopPage();
?>

</html>


