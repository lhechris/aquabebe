<?php 
session_start();

require_once("../constant.php");

require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
require_once(DOCUMENT_ROOT."/script/coordonnees.php");

  trace("-> fichier allFactures.php");

  $saison = $_GET['saison'];
  trace("Saison $saison");
  
	$query = "SELECT inscription.ID
			FROM  inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
			WHERE inscription.paiement IS NOT NULL
				AND inscription.paiement != 0
				AND creneau.saison = \"$saison\"
				ORDER BY creneau.lieu, creneau.jour, creneau.heure
		;";
	
if (! isset($_SESSION["CONNECTED"]) || 0==$_SESSION["CONNECTED"]) 
  {
    $con = mysql_connect(HOST,USER,PASSWORD);
    if (!$con) 
    {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db(DATABASE, $con);
    $_SESSION["CONNECTED"] = 1;
  } 
  else 
  {
    $_SESSION["CONNECTED"] ++;
  }
  
  $result = mysql_query($query);
  //$result = mysql_query($query) or die('Erreur SQL !<br/>'.$query.'<br/>'.mysql_error());
  
  if((null != $result) && is_resource($result)) 
  {
    ob_start();
    while($row = mysql_fetch_row($result)) 
    {
      $inscriptionId = $row[0];
      $inscriptions = getPaiementInscriptionById($inscriptionId,"pushIn", array());
      $inscription = $inscriptions[0];
    
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
			else
			{
        $montant_lettre = $montant;			
			}
      $jour = $inscription['jour'];
      $heure = utf8_encode($inscription['heure']);
      
			// information sur l'enfant
			$enfants = getPersonneEnfantByID($inscription['ID_enfant'],"pushIn",array());
			$enfant = $enfants[0];
			$prenom = $enfant['prenom'];
      $nom = $enfant['nom'];
      $sexe=$enfant['sexe'];
      $naissance = formatDate($enfant['naissance']);
  
      trace("  INFORMATION RECUPEREE inscription $inscriptionId   Payeur $payeur  moyeb $moyen  montant $montant   montant lettre $montant_lettre  jour $jour  heure $heure   enfants $prenom $nom  sexe $sexe    naissance $naissance");
 
      require(DOCUMENT_ROOT.'/script/facture.php');
    }  
    // conversion HTML => PDF
		$content = utf8_decode(ob_get_clean());
    
		require_once(DOCUMENT_ROOT.'/commun/html2pdf_v3.24/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4', 'fr');
    
    //ecriture du fichier PDF sur le serveur (laisser les 2 lignes : la 2ème ligne est en toute fin de code)
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('allFactures.pdf',false);
	}
  else
  {
    trace("Erreur SQL ? ");
    trace("query = $query");
    trace("retour erreur de sql : ".mysql_error());
  }

  $_SESSION["CONNECTED"] --;
  if (0==$_SESSION["CONNECTED"]) 
  {
    mysql_close($con);
  }   
?>

