<?php

  
function trace($text)
{
	// La première fois, on forge le nom du fichier de trace
	if (! isset($_SESSION["TRACE"]))
	{
		// Fichier <racine du site>/Traces/ddMMYYYY_HH_MM_SS.txt
		$_SESSION["TRACE"] = $_SERVER["DOCUMENT_ROOT"]."/Traces/".date('dMy_G_i_s').".txt";
    trace("Nouvelle instance de trace.");
	}
	
	// Ouverture du fichier  de trace
	$fichier = fopen($_SESSION["TRACE"], 'a+');
	
	// Erciture de la trace
	fputs($fichier, $text);
	fputs($fichier, "\r\n");
	
	// Fermeture du fichier
	fclose($fichier);
}
?>
