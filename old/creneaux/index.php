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
  
	// echo "<meta http-equiv=\"refresh\" content=\"30;url=index.php\" /> ";
  
	// ---------------------------------------------------------------------
	// Affichage des créneaux de la SAISON  COURANTE
	// ---------------------------------------------------------------------
  
	echo "<center><h1>Créneaux de la saison ".SAISON." </h1></center><br/>";
	  echo '<p class="nouveaute"><span class="avertissement">Nouveauté 2018:</span> Nous avons 2 nouveaux créneaux <strong>initiation à la natation</strong> le dimanche matin.Ces créneaux sont ouverts pour les enfants nés entre le 30/06/2011 et le 31/08/2013 .</p>';
	// Affichage du calendrier des séances
	echo  "<p><b>Le calendrier des séances ".SAISON." se trouve ".
			"<a href=\"../doc-pub/AQUABEBE-Planning.pdf\" Target=\"_blank\">ici</a></b>.</p>";
	
	// Affichage du RI + Diffusion d'image
	echo  "<p><b>Le règlement intérieur et le formulaire d'autorisation de diffusion d'images ".SAISON." se trouvent ".
			"<a href=../doc-pub/AQUABEBE-Reglement_interieur.pdf Target=_blank>là</a></b>.</p>";
			
	 //echo "<p class=\"avertissement\">C'est enfin la reprise à Saint-Lys. Les séances reprendront la semaine du 14 décembre avant les congés de noël </p>";//
	// ---------------------------------------------------------------------
	// Affichage sur les limites des dates de créneau
	// ---------------------------------------------------------------------

	echo  "<p>
	<b>
	
	Les dates indiquées pour définir les ages limites dans les créneaux s'entendent comme <u>incluses</u></font></b>.</p>";
	echo  "<p>
	<b>
	
	S'il n'y a plus de place pour votre enfant n'hesitez pas à nous envoyer un mail. Nous pouvons réajuster certains créneaux en fonction des demandes</u></font></b>.</p>";
	
	
    // ---------------------------------------------------------------------
	// MESSAGE SUR LES TRAVAUX DE ST LYS(mis pour début de la saison 2014-2015)
	// ---------------------------------------------------------------------
	
	//echo "<h2>Message important pour les séances ".SAISON." sur Saint Lys.</h2>";

	//echo "<p><b>En raison des prolongations des travaux au Centre Rosine Bet courant 2015,les séances sur Saint-Lys <font color=red>ne pourront pas </font> avoir lieu cette année</b>.<br />";

	
	// affichage des créneaux sans les inscriptions en cours
	// à utiliser durant la phase de test et d'inscription des
	// membres du CA
	//$result = getCreneaux("writeCreneauNewFormat_Vide",array(),SAISON);
	
	// affichage des créneaux et des inscriptions en cours
	$result = getCreneaux("writeCreneauNewFormat",array(),SAISON);
  
   	// ---------------------------------------------------------------------
	// MESSAGE SUR LES TRAVAUX DE ST LYS(à mettre pour la saison 2013-2014)
	// ---------------------------------------------------------------------
	/*
	echo "<h2>Message important pour les séances ".SAISON." sur Saint Lys.</h2><br/>";
	$mon_texte=htmlentities("En raison des travaux prévus au Centre Rosine Bet en 2012-2013,
			les séances sur Saint Lys pourraient ne pas se poursuivre durant toute la saison.
			Pour les enfants nés après le 01/09/2009, l'activité pourra être poursuivie 
			à la piscine de Villeuve-Tolosane le samedi matin. Pour les autres enfants,  
			Aqua-Bébé remboursera les séances non réalisées.",null,null,false);
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


