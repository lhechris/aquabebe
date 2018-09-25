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
	require_once(DOCUMENT_ROOT."/script/mel.php");
	
	define("_TITLE","Envoi de message");
  
  $saison = $_GET['saison'];
  
  //echo "saison= ".$_GET['saison'];
	
	startPage($specific_css);
	if (isset($_POST['message'])) {
		$_POST['message']=str_replace ( "\'", "'", $_POST['message']) ;
	}
	
	if (isset($_POST['subject']) && isset($_POST['message']) &&isset($_POST['creneaux']) ) {
		$fichierupload="";
		if ($_FILES['attach']['error'] > 0)
		{
			$erreur = "Erreur lors du transfert";
		} else {       
			$fichierupload="upload/".$_FILES['attach']['name'];
			$resultat = move_uploaded_file($_FILES['attach']['tmp_name'],$fichierupload);
			if (!$resultat) $erreur= "Erreur transfert fichier";
			
		}   

	
		echo sendMailByCreneaux($_POST['creneaux'],$_POST['subject'],$_POST['message'],$fichierupload);
		echo "<br/><br/><a href=\"".$_SERVER['PHP_SELF']."\">Envoyer un autre message...</a>";
	} else {
?>
		<div class="formulaire">
			<form method="post" action="<?=$_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
				<table>
					<tr>
						<td class="label">Saison :</td>
						<td class="value"><?php echo $saison;?></td>
					</tr>
					<tr>
						<td class="label">Destinataires</td>
						<td class="value"><select name="creneaux[]" MULTIPLE size=8>
						<?php 
							$creneaux = getCreneaux("pushIn",array(),$saison); 
							foreach ($creneaux as $creneau) {
								echo "<option value=\"".$creneau['ID']."\">Groupe du ".$creneau['jour']." ".$creneau['lieu']." ".utf8_encode($creneau['heure'])."</option>";
							}		 
						?>
						</select></td>
					</tr>
					<tr>
						<td class="label">Sujet :</td>
						<td class="value"><input type="texte" name="subject" value="<?=$_POST['subject'];?>" size="93" maxlength="100"/></td>
					</tr>
					<tr>
						<td class="label">Message :</td>
						<td class="value"><TEXTAREA name="message" COLS="70" ROWS="30" wrap="hard"><?=$_POST['message'];?></TEXTAREA></td>
					</tr>
					<tr><td></td><td><input type="file" name="attach" /></td><td></td></tr>					
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


