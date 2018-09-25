<?php
include_once("api/facture.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoPaiement.php");

$daopers = new DaoPersonne();
$res=$daopers->getById(3133);
$inscription=null;
$creneau=null;
foreach($res["preinscriptions"] as $preinsc ) {
    if ($preinsc->getReservation()==1) {
        $inscription=$preinsc->getInscription();
        $creneau=$preinsc->getCreneau();
    }
}
$daopaiement=new daoPaiement();
$paiement=$daopaiement->get($inscription->getPaiement());

facture($res["enfant"],$inscription,$paiement,$creneau);

/*echo chiffre2lettre(100)."<br/>";
echo chiffre2lettre(300)."<br/>";
echo chiffre2lettre(851)."<br/>";
echo chiffre2lettre(182)."<br/>";
echo chiffre2lettre(1242)."<br/>";
echo chiffre2lettre(200)."<br/>";*/

?>