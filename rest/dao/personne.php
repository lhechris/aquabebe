<?php
class Personne{
    private $id;
    private $nom;
    private $prenom;
    private $sexe;
    private $naissance;
    private $handicap;
    private $type;
    private $profession;
    private $adresse;
    private $cp;
    private $commune;
    private $tel;
    private $tel2;
    private $mel;

    public function getId() { return $this->id;}
    public function setId($id) { $this->id=$id;}

    public function getNom() { return $this->nom;}
    public function setNom($nom) { $this->nom=$nom;}
   
    public function getPrenom() { return $this->prenom;}
    public function setPrenom($prenom) { $this->prenom=$prenom;}

    public function getSexe() { return $this->sexe;}
    public function setSexe($v) { $this->sexe=$v;}

    public function getNaissance() { return $this->naissance;}
    public function setNaissance($naissance) { $this->naissance=$naissance;}

    public function getHandicap() { return $this->handicap;}
    public function setHandicap($v) { $this->handicap=$v;}

    public function getType() { return $this->type;}
    public function setType($v) { $this->type=$v;}

    public function getProfession() { return $this->profession;}
    public function setProfession($v) { $this->profession=$v;}

    public function getAdresse() { return $this->adresse;}
    public function setAdresse($v) { $this->adresse=$v;}

    public function getCp() { return $this->cp;}
    public function setCp($v) { $this->cp=$v;}

    public function getCommune() { return $this->commune;}
    public function setCommune($v) { $this->commune=$v;}

    public function getTel() { return $this->tel;}
    public function setTel($v) { $this->tel=$v;}

    public function getTel2() { return $this->tel2;}
    public function setTel2($v) { $this->tel2=$v;}

    public function getMel() { return $this->mel;}
    public function setMel($v) { $this->mel=$v;}
}
?>