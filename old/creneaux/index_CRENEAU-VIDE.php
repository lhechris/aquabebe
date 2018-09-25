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

	define("_TITLE","Créneaux de notre activité");
	
	startPage($specific_css);
  
	echo "<meta http-equiv=\"refresh\" content=\"600;url=index.php\" /> ";
  
	// ---------------------------------------------------------------------
	// Affichage des créneaux de la SAISON  COURANTE
	// ---------------------------------------------------------------------
  
	echo "<h2>Créneaux de la saison ".SAISON." </h2><br/>";
	
	// Affichage du calendrier des séances
	echo  "<p>Le calendrier des séances ".SAISON." se trouve ".
			"<a href=\"Planning_".SAISON.".pdf\" onclick=\"javascript:window.open(this.href);return(false);\">ici</a>.</p>";
	
	// Affichage du RI + Diffusion d'image
	echo  "<p>Le règlement intérieur et le formulaire d'autorisation de diffusion d'images ".SAISON." se trouvent ".
			"<a href=\"RI_".SAISON.".pdf\" onclick=\"javascript:window.open(this.href);return(false);\">ici</a>.</p>";
			
	// affichage des créneaux sans les inscriptions en cours
	// à utiliser durant la phase de test et d'inscription des
	// membres du CA
	$result = getCreneaux("writeCreneauNewFormat_Vide",array(),SAISON);
	
	// affichage des créneaux et des inscriptions en cours
	//$result = getCreneaux("writeCreneauNewFormat",array(),SAISON);
	//echo "<h2>A venir - créneaux de la nouvelle saison</h2><br/>";
  
   	// ---------------------------------------------------------------------
	// MESSAGE SUR LES TRAVAUX DE ST LYS(à mettre pour la saison TBD)
	// ---------------------------------------------------------------------
	/*
	echo "<h2>Message important pour les séances ".SAISON." sur Saint Lys.</h2><br/>";
	$mon_texte=htmlentities("En raison des travaux prévus au Centre Rosine Bet en 2012-2013,
			les séances sur Saint Lys pourraient ne pas se poursuivre durant toute la saison.
			Pour les enfants nés après le 01/09/2009, l'activité pourra être poursuivie 
			à la piscine de Villeuve-Tolosane le samedi matin. Pour les autres enfants,  
			Aqua-Bébé remboursera les séances non réalisées.",null,"utf-8",false);
	echo "<p>$mon_texte</p>";
	*/		
	// ------------------------------------------------------------------------
	// Affichage des créneaux de la SAISON  PRECEDENTE
	// ------------------------------------------------------------------------
  
	echo "<h2>Créneaux de la saison ".SAISON_PRECEDENTE." </h2><br/>";
	$result = getCreneaux("writeCreneauNewFormat",array(),SAISON_PRECEDENTE);
  
	// --------------------------------------------------------------------
	// Fin de la page
	// --------------------------------------------------------------------
	stopPage();
?>

</html>


