<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=array();
	$specific_css[0]="formulaire_contact.css";
	
	require_once("../../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");

	require_once(DOCUMENT_ROOT."/commun/formulaire_contact.php");//???TODO

	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");	
	require_once(DOCUMENT_ROOT."/script/reglement_interieur.php");
	require_once(DOCUMENT_ROOT."/script/paiement.php");
	require_once(DOCUMENT_ROOT."/script/creneaux.php");
	require_once(DOCUMENT_ROOT."/script/diffusion_image.php");
	require_once(DOCUMENT_ROOT."/script/validation.php");
	require_once(DOCUMENT_ROOT."/script/coordonnees.php");
	require_once(DOCUMENT_ROOT."/script/mel.php");
	
	define("_TITLE","Inscription en ligne à Aqua-Bébé");
	define("_VALIDER","Valider");
	
	startPage($specific_css);
	
	$patterns=array();
	$p=0;
	
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 1 : Renseignements concernant l'enfant
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Enfant",null,"utf-8",false),array(),"Etape ".($p+1));
	$i=0;
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Prénom",null,"utf-8",false),
                                'name'=>"prenom",
                                'required'=>true,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Nom",null,"utf-8",false),
                                'name'=>"nom",
                                'required'=>true,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Sexe",null,"utf-8",false),
                                'name'=>"sexe",
                                'required'=>true,
                                'type'=>"radio:M,F");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Date de naissance (jj/mm/aaaa)",null,"utf-8",false),
                                'name'=>"naissance",
                                'required'=>true,
                                'type'=>"date");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("L'enfant présente-t-il un handicap ?",null,"utf-8",false),
                                'name'=>"handicap",
                                'required'=>false,
                                'type'=>"radio:Oui,Non");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Adresse",null,"utf-8",false),
                                'name'=>"adresse",
                                'required'=>true,
                                'type'=>"textlong");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Code postal",null,"utf-8",false),
                                'name'=>"cp",
                                'required'=>true,
                                'type'=>"cp");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Commune",null,"utf-8",false),
                                'name'=>"commune",
                                'required'=>true,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Tel Portable (pour être joint par SMS en cas d'annulation de séance)",null,"utf-8",false),
                                'name'=>"tel1",
                                'required'=>true,
                                'type'=>"tel_portable");
                                //'type'=>"tel");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Autre tel",null,"utf-8",false),
                                'name'=>"tel2",
                                'required'=>false,
                                'type'=>"tel");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("E-mail",null,"utf-8",false),
                                'name'=>"mail",
                                'required'=>true,
                                'type'=>"mail");

  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 2 : Renseignements concernant les parents
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Parents",null,"utf-8",false),array(),"Etape ".($p+1));
	$i=0;
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Parents",null,"utf-8",false),
                                'name'=>null,
                                'required'=>true,
                                'type'=>"none");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Prénom",null,"utf-8",false),
                                'name'=>"prenom_p1",
                                'required'=>true,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Nom",null,"utf-8",false),
                                'name'=>"nom_p1",
                                'required'=>true,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Sexe",null,"utf-8",false),
                                'name'=>"sexe_p1",
                                'required'=>true,
                                'type'=>"radio:M,F");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Profession",null,"utf-8",false),
                                'name'=>"profession_p1",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Adresse si différente de celle de l'enfant",null,"utf-8",false),
                                'name'=>"adresse_p1",
                                'required'=>false,
                                'type'=>"textlong");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Code postal",null,"utf-8",false),
                                'name'=>"cp_p1",
                                'required'=>false,
                                'type'=>"cp");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Commune",null,"utf-8",false),
                                'name'=>"commune_p1",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Tel",null,"utf-8",false),
                                'name'=>"tel_p1",
                                'required'=>false,
                                'type'=>"tel");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("E-mail",null,"utf-8",false),
                                'name'=>"mail_p1",
                                'required'=>false,
                                'type'=>"mail");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Autre parent",null,"utf-8",false),
                                'name'=>null,
                                'required'=>false,
                                'type'=>"none");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Prénom",null,"utf-8",false),
                                'name'=>"prenom_p2",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Nom",null,"utf-8",false),
                                'name'=>"nom_p2",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Sexe",null,"utf-8",false),
                                'name'=>"sexe_p2",
                                'required'=>false,
                                'type'=>"radio:M,F");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Profession",null,"utf-8",false),
                                'name'=>"profession_p2",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Adresse si différente de celle de l'enfant",null,"utf-8",false),
                                'name'=>"adresse_p2",
                                'required'=>false,
                                'type'=>"textlong");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Code postal",null,"utf-8",false),
                                'name'=>"cp_p2",
                                'required'=>false,
                                'type'=>"cp");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Commune",null,"utf-8",false),
                                'name'=>"commune_p2",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Tel",null,"utf-8",false),
                                'name'=>"tel_p2",
                                'required'=>false,
                                'type'=>"tel");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("E-mail",null,"utf-8",false),
                                'name'=>"mail_p2",
                                'required'=>false,
                                'type'=>"mail");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Si l'accompagnateur habituel n'est pas un des 2 parents",null,"utf-8",false),
                                'name'=>null,
                                'required'=>false,
                                'type'=>"none");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Prénom",null,"utf-8",false),
                                'name'=>"prenom_a",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Nom",null,"utf-8",false),
                                'name'=>"nom_a",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Sexe",null,"utf-8",false),
                                'name'=>"sexe_a",
                                'required'=>false,
                                'type'=>"radio:M,F");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Lien avec l'enfant",null,"utf-8",false),
                                'name'=>"lien_a",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Profession",null,"utf-8",false),
                                'name'=>"profession_a",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Adresse si différente de celle de l'enfant",null,"utf-8",false),
                                'name'=>"adresse_a",
                                'required'=>false,
                                'type'=>"textlong");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Code postal",null,"utf-8",false),
                                'name'=>"cp_a",
                                'required'=>false,
                                'type'=>"cp");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Commune",null,"utf-8",false),
                                'name'=>"commune_a",
                                'required'=>false,
                                'type'=>"text");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Tel",null,"utf-8",false),
                                'name'=>"tel_a",
                                'required'=>false,
                                'type'=>"tel");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("E-mail",null,"utf-8",false),
                                'name'=>"mail_a",
                                'required'=>false,
                                'type'=>"mail");
	
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 3 : Créneaux + paiement
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------	
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Choix des créneaux",null,"utf-8",false),array(),"Etape ".($p+1));
  
	$i=0;
  
	$patterns[$p][1][$i++]=array('label'=>"<br/>".htmlentities("Voici les créneaux auxquels vous pouvez inscrire votre enfant. 
                                    Indiquez votre créneau préféré (1) puis, à défaut, les autres créneaux (2,3...).",null,"utf-8",false)
                                    ."<br/>"."<br/>"
                                    .htmlentities("Si aucune autre demande n'a été validée avant que vous n'ayez terminé votre inscription
                                    et si votre créneau préféré a des places libres, alors une place sur ce créneau vous est 
                                    réservée pendant 7 jours.",null,"utf-8",false)
                                    ."<br/>"."<br/>"
                                    .htmlentities("Vous avez donc 7 jours au maximum pour nous faire parvenir votre règlement 
                                    et confirmer votre inscription.",null,"utf-8",false)
                                    ."<br/>"."<br/>"
                                    .htmlentities("Si votre créneau préféré comporte uniquement des places en attente de 
                                    validation de paiement (en jaune), nous attendrons la fin du délai de 7 jours (attente max du paiement par autrui). Si 
                                    au terme de ce délai, le règlement de l'autre personne ne nous est pas parvenu, vous remonterez dans la
                                    liste d'attente et la place pourra éventuellement vous être attribuée. En attendant, une place sur votre 2ème, 3ème... choix est réservée.",
                                    null,"utf-8",false)
                                    ."<br/>"."<br/>",
                                'name'=>null,
                                'required'=>false,
                                'type'=>"none");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Créneaux disponibles",null,"utf-8",false),
                               'name'=>"creneaux",
                               'required'=>true,
                               'type'=>"function:writeCreneauxByAge");
	
  if (!isset($_SESSION["ADMIN"])) 
  {
  
	// SI TRAVAUX : A REMETTRE POUR INSCRIPTION 2013-2014
                                
 /*   $patterns[$p][1][$i++]=array( 'label'=>"<br/>"
											.htmlentities("
												En raison des travaux prévus au Centre Rosine Bet en 2012-2013, 
												les séances sur Saint Lys pourraient ne pas se poursuivre durant 
												toute la saison. Pour les enfants nés après le 01/09/2009 l'activité 
												pourra etre poursuivie à la piscine de Villeuve-Tolosane le samedi matin. 
												Pour les autres enfants, Aqua-Bébé remboursera les séances non réalisées.
												",null,"utf-8",false)
                                          ."<br/>",
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none");
                                
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Lu et accepté :",null,"utf-8",false),
                                  'name'=>"truc1",  // valeur non récupérée dans le traitement final
                                  'required'=>true,
                                  'type'=>"checkbox");
*/	
	// FIN DE "SI TRAVAUX"
                                
    $patterns[$p][1][$i++]=array( 'label'=>"<br/>".htmlentities("Pour valider l'inscription, le paiement intégral doit être parvenu 
                                          à l'association dans les 7 jours suivant la validation de ce formulaire. Vous pouvez payer en 
                                          deux ou plusieurs chèques.",null,"utf-8",false)
                                          ."<br/>",
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none");
                                
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Lu et accepté :",null,"utf-8",false),
                                  'name'=>"paiement_validite",
                                  'required'=>true,
                                  'type'=>"checkbox");
                                  
                                
    $patterns[$p][1][$i++]=array( 'label'=>"<br/>"
                                          .htmlentities(" L'adhésion annuelle à l'association (20€) est à régler spécifiquement et uniquement pour le 1er enfant. La cotisation, elle, est calculée en fonction de la date d'inscription et du nombre d'enfants inscrits. Le montant à payer est indiqué dans la page Tarifs.",null,"utf-8",false),
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none");
                                  
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Lu :",null,"utf-8",false),
                                  'name'=>"truc2",  // valeur non récupérée dans le traitement final
                                  'required'=>false,
                                  'type'=>"checkbox");
                                  
    $patterns[$p][1][$i++]=array('label'=>"<br/>".htmlentities("L'accès à la piscine n'est possible qu'après présentation du carnet de vaccination
                                    à jour, remise du règlement intérieur signé et remise d'un certificat 
                                    médical de moins de 3 mois attestant qu'il n'y a pas de contre-indication à la pratique de l'activité 
                                    pour l'enfant.",null,"utf-8",false),
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none");
                                  
    $patterns[$p][1][$i++]=array( 'label'=>htmlentities("Lu et accepté :",null,"utf-8",false),
                                  'name'=>"certificat_validite",
                                  'required'=>true,
                                  'type'=>"checkbox");
  }
	
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 4 : Demande dautorisation de diffusion dimage
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Demande dautorisation de diffusion dimage",null,"utf-8",false),array(),"Etape ".($p+1));
	$i=0;
  
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Demande dautorisation de diffusion dimage",null,"utf-8",false),
                               'name'=>null,
                               'required'=>false,
                               'type'=>"none");
                               
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Je déclare avoir eu connaissance que toute personne présente lors de l'activité de 
                                                      l'association Aqua-Bébé ci-dessus identifiée à laquelle nous adhérons puisse être 
                                                      photographiée. ",null,"utf-8",false),
                                'name'=>"image_diffusion",
                                'required'=>true,
                                'type'=>"function:writeAutorisation");
                                
	if (!isset($_SESSION["ADMIN"])) 
  {
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Fait sur internet, le ",null,"utf-8",false).date("j/m/Y")
                                          .htmlentities(" Signature (Prénom Nom)",null,"utf-8",false),
                                  'name'=>"image_signature",
                                  'required'=>true,
                                  'type'=>"text");
	} 
  else 
  {
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Fait à",null,"utf-8",false),
                                  'name'=>"image_lieu",
                                  'required'=>true,
                                  'type'=>"text");
                                  
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Le",null,"utf-8",false),
                                  'name'=>"image_date",
                                  'required'=>true,
                                  'type'=>"date");
                                  
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Signature (Prénom Nom)",null,"utf-8",false),
                                  'name'=>"image_signature",
                                  'required'=>true,
                                  'type'=>"text");
	}
 
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 5 : Règlement intérieur
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Règlement intérieur",null,"utf-8",false),array(),"Etape ".($p+1));
  
	$i=0;
  
	if (!isset($_SESSION["ADMIN"])) 
  {
    $patterns[$p][1][$i++]=array('label'=>getRI(),
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none");
	}
  
	$patterns[$p][1][$i++]=array('label'=>htmlentities("J'ai lu et j'accepte d'appliquer le règlement intérieur.",null,"utf-8",false),
                                'name'=>"reglement",
                                'required'=>true,
                                'type'=>"checkbox");
  
                                  
	if (!isset($_SESSION["ADMIN"])) 
  {
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Fait sur internet, le ",null,"utf-8",false).date("j/m/Y")
                                          .htmlentities(" Signature (Prénom Nom)",null,"utf-8",false),
                                  'name'=>"reglement_signature",
                                  'required'=>true,
                                  'type'=>"text");  
	} 
  else 
  {
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Fait à",null,"utf-8",false),
                                  'name'=>"reglement_lieu",
                                  'required'=>true,
                                  'type'=>"text");
                                  
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Le  ..  / .. / ....",null,"utf-8",false),
                                  'name'=>"reglement_date",
                                  'required'=>true,
                                  'type'=>"date");
                                  
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Signature (Prénom Nom)",null,"utf-8",false),
                                  'name'=>"reglement_signature",
                                  'required'=>true,
                                  'type'=>"text");  
	}
	
 
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 6 : Paiement
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Paiement",null,"utf-8",false),array(),"Etape ".($p+1));
  
	$i=0;
  
	if (!isset($_SESSION["ADMIN"])) 
  {

    $patterns[$p][1][$i++]=array('label'=>"<br/>".htmlentities("Choisissez votre moyen de paiement puis validez ce formulaire.
                                          A la validation, votre inscription sera en attente de paiement. Vous serez informés par mél
                                          de la réception de votre paiement, puis de l'attribution de votre créneau.",
                                          null,"utf-8",false),
                                  'name'=>null,
                                  'required'=>false,
                                  'type'=>"none"); 
    
    
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Choix du paiement :",
                                          null,"utf-8",false),
                                  'name'=>"paiement_moyen",
                                  'required'=>true,
                                  'type'=>"function:writePaiement");
	} 
  else 
  {
    $patterns[$p][1][$i++]=array('label'=>htmlentities("Le paiement de ",null,"utf-8",false).getMontant()
                                          .htmlentities(" (ou adapté à la fratrie) a été reçu par l'association.",null,"utf-8",false),
                                  'name'=>"paiement_recu",
                                  'required'=>true,
                                  'type'=>"checkbox");
	}
	
	writeForm($patterns);
	
	stopPage();
?>

</html>


