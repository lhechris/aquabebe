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
	
	if( isset($_POST['setCertificatMedical']) && isset($_POST['id']) )
	{
		setCertificatMedical($_POST['id'],"sendMailSetCertificatMedical");
	}
	
	if( isset($_POST['setVaccins']) && isset($_POST['id']) )
	{
		setVaccins($_POST['id'],"sendMailSetVaccins");
	}
	
	if( isset($_POST['setFactureRemise']) && isset($_POST['id']) )
	{
		setFactureRemise($_POST['id'],"");
	}
?>

<div class="validation">
  
	<h2>Saison <?php echo SAISON;?></h2>
	<ul>
		<li>Nos coordonnées : <a href="infos_ca.php">c'est ici...</a></li>
		<li>Pour envoyer un e-mail aux adhérents : <a href="mail_saison.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
		<li>Pour imprimer les enveloppes des enfants : <a href="enveloppes.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
		<li>Pour imprimer une/des factures</li>
      <ul>
        <li>Une facture : <a href="liste_inscriptions.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
        <li>Toutes les factures (by Charlie for the angels) : <a href="allFactures.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
      </ul>
		<li>Listes spécifiques</li>
      <ul>
        <li>Pour valider les certificats / vaccins : <a href="liste_inscriptions.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
        <li>Pour la trésorerie : <a href="liste_pour_tresorerie.php?saison=<?php echo SAISON;?>">c'est ici...</a></li>
        <li>Pour le secrétariat : <a href="liste_pour_secretariat.php?saison=<?php echo SAISON;?>">avec e-mails...</a> et 
                                  <a href="liste_pour_secretariat_tel.php?saison=<?php echo SAISON;?>">avec tel...</a></li>
      </ul>
		<li>Pour voir les tarifs : <a href="../tarifs">c'est ici...</a></li>
		<li>Pour voir les coordonnées des enfants : <a href="../creneaux">c'est ici...</a></li>
		<li> Documents<a href="documents.php">c'est ici...</a></li>
	</ul>
  
	<h2>Saison <?php echo SAISON_PRECEDENTE;?></h2>
  <ul>
		<li>Pour envoyer un e-mail : <a href="mail_saison.php?saison=<?php echo SAISON_PRECEDENTE;?>">c'est ici...</a></li>
		<li>Pour imprimer les enveloppes des enfants : <a href="enveloppes.php?saison=<?php echo SAISON_PRECEDENTE;?>">c'est ici...</a></li>
		<li>Listes spécifiques</li>
      <ul>
        <li>Pour voir les inscrits et/ou imprimer une facture : <a href="liste_inscriptions.php?saison=<?php echo SAISON_PRECEDENTE;?>">c'est ici...</a></li>
        <li>Pour le secrétariat : <a href="liste_pour_secretariat.php?saison=<?php echo SAISON_PRECEDENTE;?>">avec e-mails...</a></li>
      </ul>
		<!-- <li>Ancien (résultat déménagement) : <a href="resultat_questionnaire.php">c'est ici...</a></li>-->
	</ul>
    
</div>

<?php
 stopPage();
?>

</html>


