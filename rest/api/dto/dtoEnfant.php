<?php

include_once("api/badchar.php");

class dtoEnfant{
    private $id;
    private $nom;
    private $prenom;
    private $sexe;
    private $naissance;
    private $handicap;
    private $mel;
    private $adresse;
    private $cp;
    private $commune;
    private $telephone;
    private $telephone2;
    private $payeur;
    private $montant;
    private $moyen;
    private $mois;
    private $remarques;
    private $paiementid;
    private $paiementdate;
    private $datemax;
    private $inscriptionid;
    private $preinscriptions;
    private $parents;
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


    public function getId() { return $this->id;  }
    public function setId($id)  {  $this->id = $id; }

    public function getNom() { return $this->nom;  }
    public function setNom($nom)  {  $this->nom = $nom; }

    public function getPrenom() { return $this->prenom;  }
    public function setPrenom($prenom)  {  $this->prenom = $prenom; }

    public function getSexe() { return $this->sexe;  }
    public function setSexe($sexe)  {  $this->sexe = $sexe; }

    public function getNaissance() { return $this->naissance;  }
    public function setNaissance($naissance)  {  $this->naissance = $naissance; }

    public function getHandicap() { return $this->handicap;  }
    public function setHandicap($handicap)  {  $this->handicap = $handicap; }

    public function getAdresse() { return $this->adresse;  }
    public function setAdresse($adresse)  {  $this->adresse = $adresse; }

    public function getCp() { return $this->cp;  }
    public function setCp($cp)  {  $this->cp = $cp; }

    public function getCommune() { return $this->commune;  }
    public function setCommune($commune)  {  $this->commune = $commune; }

    public function getTelephone() { return $this->telephone;  }
    public function setTelephone($telephone)  {  $this->telephone = $telephone; }

    public function getTelephone2() { return $this->telephone2;  }
    public function setTelephone2($telephone2)  {  $this->telephone2 = $telephone2; }

    public function getPayeur() { return $this->payeur;  }
    public function setPayeur($payeur)  {  $this->payeur = $payeur; }

    public function getMontant() { return $this->montant;  }
    public function setMontant($montant)  {  $this->montant = $montant; }

    public function getMoyen() { return $this->moyen;  }
    public function setMoyen($moyen)  {  $this->moyen = $moyen; }

    public function getMois() { return $this->mois;  }
    public function setMois($mois)  {  $this->mois = $mois; }

    public function getRemarques() { return $this->remarques;  }
    public function setRemarques($remarques)  {  $this->remarques = $remarques; }

    public function getPaiementid() { return $this->paiementid;  }
    public function setPaiementid($paiementid)  {  $this->paiementid = $paiementid; }

    public function getPaiementdate() { return $this->paiementdate;  }
    public function setPaiementdate($paiementdate)  {  $this->paiementdate = $paiementdate; }

    public function getDatemax() { return $this->datemax;  }
    public function setDatemax($datemax)  {  $this->datemax = $datemax; }

    public function getVaccins() { return $this->vaccins;  }
    public function setVaccins($vaccins)  {  $this->vaccins = $vaccins; }

    public function getPreinscriptions() { return $this->preinscriptions;  }
    public function setPreinscriptions($preinscriptions)  {  $this->preinscriptions = $preinscriptions; }

    public function getParents() { return $this->parents;  }
    public function setParents($parents)  {  $this->parents = $parents; }


    public function getCertificatMedical() { return $this->certificat_medical;  }
    public function setCertificatMedical($certificat_medical)  {  $this->certificat_medical = $certificat_medical; }

    public function getFactureRemise() { return $this->facture_remise;  }
    public function setFactureRemise($facture_remise)  {  $this->facture_remise = $facture_remise; }

    public function getDiffusionImage() { return $this->diffusion_image;  }
    public function setDiffusionImage($diffusion_image)  {  $this->diffusion_image = $diffusion_image; }

    public function getDiffusionImageDate() { return $this->diffusion_image_date;  }
    public function setDiffusionImageDate($diffusion_image_date)  {  $this->diffusion_image_date = $diffusion_image_date; }

    public function getDiffusionImageLieu() { return $this->diffusion_image_lieu;  }
    public function setDiffusionImageLieu($diffusion_image_lieu)  {  $this->diffusion_image_lieu = $diffusion_image_lieu; }

    public function getDiffusionImageSignature() { return $this->diffusion_image_signature;  }
    public function setDiffusionImageSignature($diffusion_image_signature)  {  $this->diffusion_image_signature = $diffusion_image_signature; }

    public function getReglementInterieurDate() { return $this->reglement_interieur_date;  }
    public function setReglementInterieurDate($reglement_interieur_date)  {  $this->reglement_interieur_date = $reglement_interieur_date; }

    public function getReglementInterieurLieu() { return $this->reglement_interieur_lieu;  }
    public function setReglementInterieurLieu($reglement_interieur_lieu)  {  $this->reglement_interieur_lieu = $reglement_interieur_lieu; }

    public function getReglementInterieurSignature() { return $this->reglement_interieur_signature;  }
    public function setReglementInterieurSignature($reglement_interieur_signature)  {  $this->reglement_interieur_signature = $reglement_interieur_signature; }

    public function getInscriptionid() { return $this->inscriptionid;  }
    public function setInscriptionid($inscriptionid)  {  $this->inscriptionid = $inscriptionid; }

    public function getMel() { return $this->mel;  }
    public function setMel($mel)  {  $this->mel = $mel; }


    public function toArray() {
        $vars = get_object_vars($this);
         if ($this->preinscriptions!=null) {
            $vars["preinscriptions"]=array();
            foreach($this->preinscriptions as $p) {
                array_push($vars["preinscriptions"],$p->toArray());
            }            
        }
        if ($this->parents!=null) {
            $vars["parents"]=array();
            foreach($this->parents as $p) {
                array_push($vars["parents"],$p->toArray());
            }            
        }
        return $vars;
    }

}

?>