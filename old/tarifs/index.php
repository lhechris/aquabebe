<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	
	$specific_css=null;
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	
	require_once(DOCUMENT_ROOT."/script/paiement.php");
	
	require_once(DOCUMENT_ROOT."/script/mel.php");
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	
	define("_TITLE","Les tarifs de la cotisation");
	
	startPage($specific_css);
  
  echo "<h2>La cotisation (saison ".SAISON.")</h2>";

?>

<p>La cotisation est constituée de l'adhésion à l'association pour la période scolaire <?php echo SAISON;?>
    et de la participation à l'activité "bébé nageurs" ou "Initiation à la natation". <br />
    L'adhésion est de 20€ et est à acquitter uniquement pour le 1er enfant. La participation à l'activité s'élève à 180€ pour un enfant.<br/>
    La cotisation totale s'élève donc à 200€ pour le 1er enfant. <br />
	La participation est dégressive si vous vous inscrivez en cours d'année. Si vous 
    inscrivez plusieurs enfants, une remise sera appliquée sur les tarifs.<br />
	
	Au delà de deux enfants, merci de nous consulter. <br />
</p>
	
       
<h2>Calculer le montant de votre cotisation</h2>

<div class="validation">
<table class="validation">
<tr align=center>
	<th>Vous inscrivez votre enfant</th>
	<th>1 enfant</th>
	<th>2 enfants</th>
</tr>
<tr>
	<td>Avant le 15 Octobre</td>
	<td>1 chèque de 180€ (ou 3 x 60€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 340€ (ou 2 x 115€ et 1*110€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Novembre</td>
	<td>1 chèque de 160€ (ou 2 x 50€ et 1*60€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 304€ (ou 2 x 100€ et 1*104€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Décembre</td>
	<td>1 chèque de 140€ (ou 2 x 50€ et 1*40€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 266€ (ou 2 x 90€ et 1*86€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Janvier</td>
	<td>1 chèque de 120€ (ou 3 x 40€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 228€ (ou 3 x 76€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Février</td>
	<td>1 chèque de 100€ (ou 2 x 35€ et 1*30€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 190€ (ou 2 x 65€ et 1*60€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Mars</td>
	<td>1 chèque de 80€ (ou 2 x 40€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 152€ (ou 2 x 76€)<br /> + 1 chèque de 20€</td>
</tr>
<tr>
	<td>En Avril</td>
	<td>1 chèque de 60€ (ou 2 x 30€)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 114€ (ou 2 x 57€)<br /> + 1 chèque de 20€</td>
</tr>
	<td>En Mai</td>
	<td>1 chèque de 40€ <br />(pas de paiement en plusieurs fois)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 76€ <br />(pas de paiement en plusieurs fois)<br /> + 1 chèque de 20€</td>
</tr>
	<td>En Juin</td>
	<td>1 chèque de 20€ <br />(pas de paiement en plusieurs fois)<br /> + 1 chèque de 20€</td>
	<td>1 chèque de 38€ <br />(pas de paiement en plusieurs fois)<br /> + 1 chèque de 20€</td>
</tr>
</table>
</div>

<h2>Encaissement des chèques</h2>
<p>Les chèques seront encaissés après la première séance validée et avec le calendrier suivant :</p>
    <ul>- adhésion 20€  au 15 octobre<br/>
        - 1er chèque au 15 octobre<br/>
        - 2ème chèque au 15 novembre<br/>
        - 3ème chèque au 15 décembre<br/></ul>
		<br />
        <br />
		
	<!--- <h2>Pour l'année 2015</h2> 
	<p>Les personnes ne s'inscrivant qu'aux créneaux libérés par l'ouverture de Saint-Lys, les dates seront les suivantes, après la première séance validée :  </p>
		<ul>- adhésion 20  au 15 octobre<br/>
        - 1er chèque au 15 février<br/>
        - 2ème chèque au 15 mars<br/>
		- 3ème chèque au 15 avril<br/>
        - 4ème chèque au 15 mai<br/></ul> ---!>

<?php
 stopPage();
?>

</html>


