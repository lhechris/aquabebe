<?php
include_once("api/objects/personne.php");
include_once("api/objects/paiement.php");

function convertDtoPostEnfantToPersonne($dtoPostEnfant) {
    $enfant = new Personne();
    $enfant->setId($dtoPostEnfant->getId());
    $enfant->setNom($dtoPostEnfant->getNom());
    $enfant->setPrenom($dtoPostEnfant->getPrenom());
    $enfant->setSexe($dtoPostEnfant->getSexe());
    $enfant->setNaissance($dtoPostEnfant->getNaissance());
    $enfant->setHandicap($dtoPostEnfant->getHandicap());
    $enfant->setAdresse($dtoPostEnfant->getAdresse());
    $enfant->setCp($dtoPostEnfant->getCp());
    $enfant->setCommune($dtoPostEnfant->getCommune());
    $enfant->setTel($dtoPostEnfant->getTelephone());
    $enfant->setTel2($dtoPostEnfant->getTelephone2());
    $enfant->setMel($dtoPostEnfant->getMel());
    return $enfant;
}

function convertDtoPostEnfantToPaiement($dtoPostEnfant) {
    $paiement = new Paiement();
    $paiement->setId($dtoPostEnfant->getPaiementid());
    $paiement->setPayeur($dtoPostEnfant->getPayeur());
    $paiement->setMontant($dtoPostEnfant->getMontant());
    $paiement->setMoyen($dtoPostEnfant->getMoyen());
    $paiement->setMois($dtoPostEnfant->getMois());
    $paiement->setRemarques($dtoPostEnfant->getRemarques());
    return $paiement;
}
?>