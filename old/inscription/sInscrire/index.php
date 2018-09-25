<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=null;
	
	require_once("../../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	define("_TITLE","S'inscrire");
	
	startPage($specific_css);

?>

<h2>Inscription <?php echo SAISON; ?> </h2>

<ul>
  <!--<li>Nous sommes complets pour la saison. La page créneaux vous indiquera si des places se libèrent.</li>-->
	<li><strong>Inscription en ligne : <a href="inscription.php">DEMARRER</a></strong>
	  <br/><strong>Créneaux fratrie</strong>: Ces créneaux sont réservés aux fratries. Ne peuvent s'y inscrire que 2 (ou plus) enfants étant frères et/ou soeurs. Dans ce cas il faut être 2 (ou plus) accompagnants dans l'eau (un par enfant).
	  <br/><strong>Attention, vous devez faire indépendamment l'inscription pour chaque enfant de la fratrie.</strong>
      <br/> Note : A la fin de l'inscription, vous recevez un e-mail indiquant que votre inscription a été prise en compte.
  </li>
 
  	<li>Inscription par courrier : Contactez Aqua-Bébé
	
	<!--<li>Inscription par courrier : Imprimez et complétez
       <a href="dossier_inscription_2013-2014.pdf" onclick="javascript:window.open(this.href);return(false);">le formulaire d'inscription</a>
       et renvoyez-le-nous accompagné du règlement complet à l'adresse indiquée.</li>-->
       
</ul>

<h2>Une question ? Un problème ?</h2>

<ul>
  <li>Pour tout problème technique lors de l'inscription :<br/>
    * contactez <img src="<?=REPOSITORY?>/images/contact-head.jpg" alt="adresse à recopier" /> et<br/>
    * envoyez en parallèle votre dossier d'inscription par la poste avec votre règlement.
  </li>
    <li>Pour toute autre question, vous pouvez nous joindre à : <img src="<?=REPOSITORY?>/images/contact-head.jpg" alt="adresse à recopier" /></li>
</ul>

<p><strong><br/>Que ce soit pour l'inscription ou pour toute communication en cours d'année, l'E-mail est la solution 
          que l'association Aqua-Bébé utilise de manière privilégiée.</strong></p>



<?php
 stopPage();
?>

</html>


