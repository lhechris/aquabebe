<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=array();
	$specific_css[0]="formulaire_contact.css";
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");
	require_once(DOCUMENT_ROOT."/script/sms.php");
	
	define("_TITLE","Envoi de SMS");
    
  //$saison = ($_GET['ma_saison']);
  //echo $saison;
  
	
	startPage($specific_css);
	
	$_POST['sms']=str_replace ( "\'", "'", $_POST['sms']) ;
	
	if (isset($_POST['sms']) && isset($_POST['creneaux']) ) 
  {
		echo sendSMSByCreneaux($_POST['creneaux'],$_POST['sms']);
		echo "<br/><br/><a href=\"".$_SERVER['PHP_SELF']."\">Envoyer un autre sms...</a>";
	} else {
?>
		<div class="formulaire">
			<form method="post" action="<?=$_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
				<table>
					<tr>
						<td class="label">Saison :</td>
						<td class="value"><?php echo SAISON;?></td>
					</tr>
					<tr>
						<td class="label">Destinataires</td>
						<td class="value"><select name="creneaux[]" MULTIPLE size=8>
						<?php 
							$creneaux = getCreneaux("pushIn",array(),SAISON); 
							foreach ($creneaux as $creneau) {
								echo "<option value=\"".$creneau['ID']."\">Groupe du ".$creneau['jour']." ".utf8_encode($creneau['heure'])."</option>";
							}		 
						?>
						</select></td>
					</tr>
					<tr>
						<td class="label">SMS :</td>
						<td class="value"><TEXTAREA name="sms" COLS="50" ROWS="15" wrap="hard"><?=$_POST['sms'];?></TEXTAREA></td>
					</tr> 
					<tr>
						<td class="buttons" colspan="2">
							<input type="submit" value="Envoyer"/>
							<input type="reset" value="Annuler"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
<?php
	}
	
 	stopPage();
?>

</html>


