<?php 
	session_start();
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	
  $saison = $_GET['saison'];
  trace("fichier enveloppes.php");
  trace("  saison : $saison");
	
	$enfants = getEnfantsBySaison("pushIn",array(),$saison);
	
	if( ! (sizeof($enfants)>0)) 
  { 
		$enfants = array(array('prenom'=>"Aucun",'nom'=>"Enfant",'adresse'=>"Enregistré",'cp'=>"31270",'commune'=>"Frouzins"),array('prenom'=>"Titi"));
	}


		ob_start();
		require(DOCUMENT_ROOT.'/script/enveloppe.php');
		$content = utf8_decode(ob_get_clean());
		// conversion HTML => PDF
		require_once(DOCUMENT_ROOT.'/commun/html2pdf_v3.24/html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','dl', 'fr');
		
		//ecriture du fichier PDF sur le serveur (laisser les 2 lignes)
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('enveloppes.pdf',false);
?>

