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
	require_once(DOCUMENT_ROOT."/script/mel.php");
	require_once(DOCUMENT_ROOT."/script/paiement.php");
	
	require_once(DOCUMENT_ROOT."/lang/fr/formulaire_text.php");
  
  // Recuperation des données du formulaire Validation_Paiement [validation_paiement.php] pour la fonction setPaiement() dans dbFunctions2.php
  if( isset($_POST['button_setPaiement']) && isset($_POST['payeur']) 
      && isset($_POST['mois']) && isset($_POST['montant'])
      && isset($_POST['moyen'])
      && isset($_POST['remarques'])
      && isset($_POST['inscription']) )
  {
		setPaiement(array('payeur'        =>$_POST['payeur'],
                      'mois'          =>$_POST['mois'],
                      'montant'       =>$_POST['montant'],
                      'moyen'         =>$_POST['moyen'],
                      'remarques'     =>$_POST['remarques'],
                      'ID_inscription'=>$_POST['inscription']),
                "sendMailSetPaiement");
	}
  
  // Recuperation des données du formulaire Validation_Creneau [xxx.php] pour la fonction setCreneau() dans dbFunctions2.php
	if( isset($_POST['setCreneau']) && isset($_POST['inscription']) && isset($_POST['creneau']) )
  {
		setCreneau(array('ID_inscription'=>$_POST['inscription'],'ID_creneau'=>$_POST['creneau']),"sendMailSetCreneau");
	}
	
	define("_TITLE","Validation des inscriptions");
	
	startPage($specific_css);
	
	$precedent_valide=true;
  

?>


<h2>SAISON <?php echo SAISON;?></h2>
  
<div class="validation">
	<table class="validation">
		<tr>
			<th>Date de paiement</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Age</th>
			<th>Paiement</th>
			<th>Créneau</th>
		</tr>
		<?php $precedent_valide=getInscriptionsEnCours("writeInscription",true);?>
	</table>
	
	<hr/>
	
	<h4>Les personnes suivantes ont dépassé la date limite de paiement.</h4>
	
	<table class="validation">
		<tr>
			<th>Date de paiement</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Age</th>
			<th>Paiement</th>
			<th>Créneau</th>
		</tr>
		<?php $precedent_valide=getInscriptionsHorsDelai("writeInscription",false);?>
	</table>
	
	<hr/>
	
	<h4>Liste des personnes inscrites par ordre alphabétique</h4>
	
	<table class="validation">
		<tr>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Age</th>
			<th>Créneau</th>
			<th>Certificat</th>
			<th>Vaccins</th>
			<th>Facture</th>
		</tr>
    
 		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>   
      
    
    </tr>
		<?php $precedent_valide=getInscriptionsValides("writeListeAdministrative",true);?>
	</table>

</div>

<?php
 stopPage();
?>

</html>


