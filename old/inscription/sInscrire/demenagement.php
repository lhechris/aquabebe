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

	require_once(DOCUMENT_ROOT."/commun/formulaire_contact.php");
	
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");	
	require_once(DOCUMENT_ROOT."/script/validation_demenagement.php");
	require_once(DOCUMENT_ROOT."/script/mel.php");
	
	define("_TITLE","D�m�nagement");
	define("_VALIDER","Valider");
	
	startPage($specific_css);
	
	$patterns=array();
	$p=0;
	
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 1 : Renseignements concernant l'enfant
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$patterns[$p]=array("Etape ".($p+1).htmlentities("&nbsp;: Identification de l'enfant",null,"utf-8",false),array(),"Etape ".($p+1));
	$i=0;                      
  $patterns[$p][1][$i++]=array('label'=>htmlentities("Si fratrie, une seule r�ponse sera enregistr�e pour la fratrie. Si la r�ponse doit �tre diff�rente par enfant, contactez demenagement@aquabebe.fr.",null,"utf-8",false)."<br/>"."<br/>",
                                'name'=>null,
                                'required'=>false,
                                'type'=>"none");

	$patterns[$p][1][$i++]=array('label'=>htmlentities("E-mail (utilis� lors de l'inscription)",null,"utf-8",false),
                                'name'=>"mail",
                                'required'=>true,
                                'type'=>"mail2");

  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
  // Etape 2 : D�cision
  // -----------------------------------------------------------------------------------------------------------------------------------------------------------------	
	$patterns[++$p]=array("Etape ".($p+1).htmlentities("&nbsp;: D�cision",null,"utf-8",false),array(),"Etape ".($p+1));
  
	$i=0;
  
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Aqua-B�b� d�m�nage � St Lys (au centre Rosine Bet). Que choisissez vous ?",null,"utf-8",false)."<br/>"."<br/>",
                                'name'=>null,
                                'required'=>false,
                                'type'=>"none");
                                
	$patterns[$p][1][$i++]=array('label'=>htmlentities("Je choisis de continuer l'activit�&nbsp;:",null,"utf-8",false),
                               'name'=>"continuation",
                               'required'=>true,
                               'type'=>"radio:Non,Oui");
	
  		
	writeForm($patterns);
	
	stopPage();
?>

</html>


