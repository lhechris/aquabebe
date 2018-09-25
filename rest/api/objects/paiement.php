<?php

include_once("api/badchar.php");

class Paiement {

    private $id;
    private $payeur;
    private $montant;
    private $moyen;
    private $mois;
    private $remarques;

    function getId() { return $this->id;}
    function setId($v) { $this->id=$v;}

    function getPayeur() { return $this->payeur;}
    function setPayeur($v) { $this->payeur=replacebadchar($v);}

    function getMontant() { return $this->montant;}
    function setMontant($v) { $this->montant=$v;}

    function getMoyen() { return $this->moyen;}
    function setMoyen($v) { $this->moyen=$v;}

    function getMois() { return $this->mois;}
    function setMois($v) { $this->mois=$v;}

    function getRemarques() { return $this->remarques;}
    function setRemarques($v) { $this->remarques=replacebadchar($v);}
}

?>