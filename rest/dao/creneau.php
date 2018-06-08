<?php
class Creneau{
    private $id;
    private $saison;
    private $lieu;
    private $jour;
    private $heure;
    private $age;
    private $pour_fratri;
    private $naissance_min;
    private $naissance_max;
    private $nb_mois_mini;
    private $capacite;
    private $nb_inscrit;
    private $enfants;

    public function __construct()
    {
        $this->enfants=array();
    }

    public function getId() { return $this->id;}
    public function setId($id) { $this->id=$id;}

    public function getSaison() { return $this->saison;}
    public function setSaison($saison) { $this->saison=$saison;}

    public function getLieu() { return $this->lieu;}
    public function setLieu($lieu) { $this->lieu=$lieu;}

    public function getJour() { return $this->jour;}
    public function setJour($jour) { $this->jour=$jour;}

    public function getHeure() { return $this->heure;}
    public function setHeure($heure) { $this->heure=$heure;}

    public function getAge() { return $this->age;}
    public function setAge($age) { $this->age=$age;}

    public function getPourFratri() { return $this->pour_fratri;}
    public function setPourFratri($pour_fratri) { $this->pour_fratri=$pour_fratri;}

    public function getNaissanceMin() { return $this->naissance_min;}
    public function setNaissanceMin($naissance_min) { $this->naissance_min=$naissance_min;}

    public function getNaissanceMax() { return $this->naissance_max;}
    public function setNaissanceMax($naissance_max) { $this->naissance_max=$naissance_max;}

    public function getNbMoisMini() { return $this->nb_mois_mini;}
    public function setnbMoisMini($nb_mois_mini) { $this->nb_mois_mini=$nb_mois_mini;}

    public function getCapacite() { return $this->capacite;}
    public function setCapacite($capacite) { $this->capacite=$capacite;}

    public function getNbInscrit() { return $this->nb_inscrit;}
    public function setNbInscrit($value) { $this->nb_inscrit=$value;}

    public function getEnfants() { return $this->enfants;}
    public function addEnfant($enfant) { array_push($this->enfants,$enfant);}
}
?>