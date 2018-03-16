<?php
class Inscription{
    private $inscription;
    private $creneau;
    private $choix;
    private $reservation;

    public function __construct()
    {
        
    }

    public function getInscription() { return $this->Inscription;}
    public function setInscription($v) { $this->=$v;}

    public function getCreneau() { return $this->creneau;}
    public function setCreneau($v) { $this->creneau=$v;}

    public function getChoix() { return $this->choix;}
    public function setChoix($v) { $this->choix=$v;}

    public function getReservation() { return $this->reservation;}
    public function setReservation($v) { $this->reservation=$v;}

}

?>