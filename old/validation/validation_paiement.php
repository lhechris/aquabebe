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
	
	define("_TITLE","Valider un paiement");
	
	startPage($specific_css);
	

?>

	<div class="coordonnees">
		<?php 
      if (isset($_POST['id_enfant']))
      {
        $enfant = getEnfantById($_POST['id_enfant'],"writeCoordonnees");
      }
      else
      {
        //echo "DEBUG : _POST['id_enfant'] = NULL";
      }
       
    ?>
	</div>
	<div class="preinscriptions">
		<form method="post" action="index.php" enctype="multipart/form-data">
			<table class="preinscription">
				<tr>
					<th colspan="2">Paiement de l'inscription</th>
				</tr>
				<tr>
					<th>Payeur</th>
					<td><input type="text" name="payeur"/></td>
				</tr>
				<tr>
					<th>Mois Année</th>
					<td><input type="text" name="mois"/></td>
				</tr>
				<tr>
					<th>Montant total</th>
					<td><input type="text" name="montant"/></td>
				</tr>
	<!--	A REMETTRE SI UTILISATION DE CB ou PAYPAL
				<tr>
					<th>Moyen (ch&egrave;que, 4 ch&egrave;ques, espèces...)</th>
					<td><input type="text" name="moyen"/></td>
				</tr>
        -->
        <input type="hidden" name="moyen" value="cheque" />
        
				<tr>
					<th>Remarques (n° des ch&egrave;ques, montants, banque,...)</th>
					<td><input type="text" name="remarques"/></td>
				</tr>
				<tr>
					<th colspan="2">
						<input type="hidden" name="inscription" value="<?=$_POST['id'];?>" />
						<input type="submit" name="button_setPaiement" value="Valider (paiement)"/>
					</th>
				</tr>
			</table>
		</form>


		
		<table class="preinscription">
			<tr>
				<th>Cr&eacute;neaux choisis par ordre de préférence</th>
			</tr>
			<tr>
				<td><?php 
                if (isset($_POST['id']))
                {
                  echo getPreinscriptions($_POST['id'],"writePreinscriptionInfo",null) ;
                }
                else
                {
                  //echo "DEBUG : _POST['id'] = NULL";
                }
             ?></td>
			</tr>
		</table>
		
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


