<?php 
	session_start();
	
	require_once("../constant.php");
	
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");
		
	if( isset($_GET['id']) ){
		
		$inscriptions = getPaiementInscriptionById($_GET['id'],"pushIn", array());
		$inscription = $inscriptions[0];
		
		$enfants = getPersonneEnfantByID($inscription['ID_enfant'],"pushIn",array());
		$enfant = $enfants[0];
		
    $saison = $_GET['saison'];
		$payeur = $inscription['payeur'];
		$moyen = $inscription['moyen'];
		$montant =$inscription['montant'];
		if($montant==220) {
			$montant_lettre = "deux cent vingt";
		} else if($montant==200) {
			$montant_lettre = "deux cents";
		} else if($montant==182) {
			$montant_lettre = "cent quatre-vingts deux";
		} else if($montant==180) {
			$montant_lettre = "cent quatre-vingts";
		} else if($montant==160) {
			$montant_lettre = "cent soixante";
		} else if($montant==140) {
			$montant_lettre = "cent quarante";
		} else if($montant==120) {
			$montant_lettre = "cent vingt";
		} else if($montant==100) {
			$montant_lettre = "cent";
		} else if($montant==80) {
			$montant_lettre = "quatre-vingts";
		} else if($montant==60) {
			$montant_lettre = "soixante";
		} else if($montant==40) {
			$montant_lettre = "quarante";
		} else if($montant==20) {
			$montant_lettre = "vingt";
		}
		
		$prenom = $enfant['prenom'];
		$nom = $enfant['nom'];
		$sexe=$enfant['sexe'];
		$naissance = formatDate($enfant['naissance']);
		
		$jour = $inscription['jour'];
		$heure = utf8_encode($inscription['heure']);
		
	}


		ob_start();
		require(DOCUMENT_ROOT.'/script/facture.php');
		$content = utf8_decode(ob_get_clean());
		// conversion HTML => PDF
		require_once(DOCUMENT_ROOT.'/commun/html2pdf_v3.24/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4', 'fr');
		
		//ecriture du fichier PDF sur le serveur (laisser les 2 lignes)
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('facture.pdf',false);
?>

