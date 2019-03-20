<?php

include_once("api/objects/creneau.php");

function convertDtoAddCreneau($dtoCreneau) {
    $creneau=new Creneau();
    $creneau->setSaison($dtoCreneau->getSaison());
    $creneau->setLieu($dtoCreneau->getLieu());
    $creneau->setJour($dtoCreneau->getJour());
    $creneau->setHeure($dtoCreneau->getHeure());
    $creneau->setAge($dtoCreneau->getAge());
    $creneau->setPourFratrie($dtoCreneau->getPourFratrie());
    $creneau->setNaissanceMin($dtoCreneau->getNaissanceMin());
    $creneau->setNaissanceMax($dtoCreneau->getNaissanceMax());
    $creneau->setnbMoisMini($dtoCreneau->getNbMoisMini());
    $creneau->setCapacite($dtoCreneau->getCapacite());

    return $creneau;
}

?>