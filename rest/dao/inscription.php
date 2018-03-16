<?php
class Inscription{
    private $id;
    private $enfant;
    private $creneau;
    private $date_max;
    private $paiement;
    private $paiement_date;
    private $certificat_medical;
    private $vaccins;
    private $facture_remise;
    private $diffusion_image;
    private $diffusion_image_date;
    private $diffusion_image_lieu;
    private $diffusion_image_signature;
    private $reglement_interieur_date;
    private $reglement_interieur_lieu;
    private $reglement_interieur_signature;
  

    public function __construct()
    {
        
    }

    public function getId() { return $this->id;}
    public function setId($id) { $this->id=$id;}

    public function getEnfant() { return $this->enfant;}
    public function setEnfant($v) { $this->enfant=$v;}

    public function getCreneau() { return $this->creneau;}
    public function setCreneau($v) { $this->creneau=$v;}

    public function getDateMax() { return $this->date_max;}
    public function setDateMax($v) { $this->date_max=$v;}

    public function getPaiement() { return $this->paiement;}
    public function setPaiement($v) { $this->paiement=$v;}

    public function getPaiementDate() { return $this->paiement_date;}
    public function setPaiementDate($v) { $this->paiement_date=$v;}

    public function getCertificatMedical() { return $this->certificat_medical;}
    public function setCertificatMedical($v) { $this->certificat_medical=$v;}

    public function getVaccins() { return $this->vaccins;}
    public function setVaccins($v) { $this->vaccins=$v;}

    public function getFactureRemise() { return $this->facture_remise;}
    public function setFactureRemise($v) { $this->facture_remise=$v;}

    public function getDiffusionImage() { return $this->diffusion_image;}
    public function setDiffusionImage($v) { $this->diffusion_image=$v;}

    public function getDiffusionImageDate() { return $this->diffusion_image_date;}
    public function setDiffusionImageDate($v) { $this->diffusion_image_date=$v;}

    public function getDiffusionImageLieu() { return $this->diffusion_image_lieu;}
    public function setDiffusionImageLieu($v) { $this->diffusion_image_lieu=$v;}

    public function getDiffusionImageSignature() { return $this->diffusion_image_signature;}
    public function setDiffusionImageSignature($v) { $this->diffusion_image_signature=$v;}

    public function getReglementInterieurDate() { return $this->reglement_interieur_date;}
    public function setReglementInterieurDate($v) { $this->reglement_interieur_date=$v;}

    public function getReglementInterieurLieu() { return $this->reglement_interieur_lieu;}
    public function setReglementInterieurLieu($v) { $this->reglement_interieur_lieu=$v;}

    public function getReglementInterieurSignature() { return $this->reglement_interieur_signature;}
    public function setReglementInterieurSignature($v) { $this->reglement_interieur_signature=$v;}

}
?>