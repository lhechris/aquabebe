<?php

class dtoPostEnfant{
    private $id;
    private $nom;
    private $prenom;
    private $sexe;
    private $naissance;
    private $handicap;
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
    private $creneauselected;

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

    public function getCreneauselected() { return $this->creneauselected;  }
    public function setCreneauselected($creneauselected)  {  $this->creneauselected = $creneauselected; }

    public function toArray() {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function fromArray($json) {
        $vars = get_object_vars($this);
        foreach($json as $key => $value) {
            //$valuesck=htmlentities($value);
            $valuesck=$value;
            if (array_key_exists($key,$vars)) {
                $this->$key=$valuesck;
            }
        }
    }
}

?>