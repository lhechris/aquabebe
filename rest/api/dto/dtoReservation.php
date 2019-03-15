<?php

class dtoReservationPreinsc {
  private $choix;
  private $reservation;
  private $creneauid;
  private $creneaulieu;
  private $creneaujour;
  private $creneauheure;
  private $status;
  
  public function getChoix() { return $this->choix;  }
  public function setChoix($choix)  {  $this->choix = $choix; }

  public function getReservation() { return $this->reservation;  }
  public function setReservation($reservation)  {  $this->reservation = $reservation; }

  public function getCreneauId() { return $this->creneauid;  }
  public function setCreneauId($creneauid)  {  $this->creneauid = $creneauid; }

  public function getCreneauLieu() { return $this->creneaulieu;  }
  public function setCreneauLieu($creneaulieu)  {  $this->creneaulieu = $creneaulieu; }

  public function getCreneauJour() { return $this->creneaujour;  }
  public function setCreneauJour($creneaujour)  {  $this->creneaujour = $creneaujour; }

  public function getCreneauHeure() { return $this->creneauheure;  }
  public function setCreneauHeure($creneauheure)  {  $this->creneauheure = $creneauheure; }

  public function getStatus() { return $this->status;  }
  public function setStatus($status)  {  $this->status = $status; }

  public function toArray() {
    $vars = get_object_vars($this);
    return $vars;
  }

}

class dtoReservation {
    private $id;
    private $prenom;
    private $nom;
    private $paiement_date;
    private $age;
    private $preinscriptions;
    private $datemax;

    public function __construct() {
      $this->preinscriptions=array();
    }

    public function getId() { return $this->id;  }
    public function setId($id)  {  $this->id = $id; }

    public function getPrenom() { return $this->prenom;  }
    public function setPrenom($prenom)  {  $this->prenom = $prenom; }

    public function getNom() { return $this->nom;  }
    public function setNom($nom)  {  $this->nom = $nom; }

    public function getPaiementDate() { return $this->paiement_date;  }
    public function setPaiementDate($paiement_date)  {  $this->paiement_date = $paiement_date; }

    public function getAge() { return $this->age;  }
    public function setAge($age)  {  $this->age = $age; }

    public function addPreinscription($preinscription)  {  array_push($this->preinscriptions,$preinscription); }
    public function getPreinscriptions() { return $this->preinscriptions;  }

    public function getDateMax() { return $this->datemax;  }
    public function setDateMax($datemax)  {  $this->datemax = $datemax; }

    public function toArray() {
      $vars = get_object_vars($this);
      if ($this->preinscriptions!=null) {
        $vars["preinscriptions"]=array();
        foreach($this->preinscriptions as $p) {
            array_push($vars["preinscriptions"],$p->toArray());
        }            
    }
      return $vars;
    }

}

?>