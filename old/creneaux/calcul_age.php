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
	require_once(DOCUMENT_ROOT."/script/creneaux.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");
	
	define("_TITLE", "Vérifier l'âge pour ce créneau");
	
	startPage($specific_css);
	
	if (isset($_GET['id'])) {
		$ID_creneau = $_GET['id'];
	}
	if (isset($_POST['id'])) {
		$ID_creneau = $_POST['id'];
	}

?>

<h2>Votre enfant peut-il s'inscrire à ce créneau ?</h2>

	<div class="coordonnees">
		<div class="part">
			<?php $creneau = getCreneau($ID_creneau,"writeDetailCreneau",array()); ?>
		</div>
	</div>
		
	<div class="preinscriptions">
	<?php if (isset($_POST['calcul'])){
		/*if ((1<=$_POST['nb_enfants']) && ($_POST['nb_enfants']<5)) {
			$annee_max=10;
			$annee = date("y");
			$mois = date("m");
			$adhesion=20;
			if ((9==$annee) && ($mois<=9)){
				$cotisation=200;
			} else {
				$cotisation=20*(($annee_max-$annee)*12+7-$mois);
			}
			$reduction = 1- ( ($_POST['nb_enfants']-1)*0.1 );
			$total = ($cotisation*$reduction + $adhesion) * $_POST['nb_enfants']; 
			echo "<p>Pour ".$_POST['nb_enfants'];
			if($_POST['nb_enfants']>1) {
				echo " enfants, ";
			} else {
				echo " enfant, ";
			}
			echo "le montant de la cotisation s'élève à ".$total."&euro;</p>"; 
		} else {
			echo "<p>Impossible de calculer la cotisation avec ces informations à ce jour.</p>";
		}*/
		
		if ((!is_long($_POST['jour'])) || (!is_long($_POST['mois'])) || (!is_long($_POST['annee'])) || (!checkdate($_POST['mois'],$_POST['jour'],$_POST['annee'])) ) {
			echo "<div class=\"complet\">"._MSG_ERREUR_DATE_2. gettype($_POST['jour'])."</div>";
		} else {
			$date=$_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
			if ($date<$creneau['naissance_min']){
				echo "Trop petit";
			}
			
		}
	} else { 
		/*<form method="post" action="<?=$_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
			Veuillez saisir la date de naissance de votre enfant&nbsp;: <input type="text" size="2" maxlength="2" name="jour" value="jour" />/<input type="text" size="2" maxlength="2" name="mois" value="mois" />/<input type="text" size="2" maxlength="4" name="annee" value="année" />
			<input type="hidden" name="id" value="<?=$ID_creneau;?>"/>
			<input type="submit" name="calcul" value="Calculer"/>
		</form>*/
		echo "<hr/><h4>Bientôt vous retrouverez ici le calcul de l'âge de votre enfant par rapport à ce créneau&nbsp;!</h4>";
	} ?>
				
	</div>
	
	<hr/>

<?php
 stopPage();
?>

</html>


