<?php
class dtoAddCreneau {
    private $id;
    private $saison;
    private $lieu;
    private $jour;
    private $heure;
    private $age;
    private $pour_fratrie;
    private $naissance_min;
    private $naissance_max;
    private $nb_mois_mini;
    private $capacite;

    public function __construct()
    {
    }

    public function getId() { return $this->id;  }
    public function setId($id)  {  $this->id = $id; }

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

    public function getPourFratrie() { return $this->pour_fratrie;}
    public function setPourFratrie($pour_fratrie) { $this->pour_fratrie=$pour_fratrie;}

    public function getNaissanceMin() { return $this->naissance_min;}
    public function setNaissanceMin($naissance_min) { $this->naissance_min=$naissance_min;}

    public function getNaissanceMax() { return $this->naissance_max;}
    public function setNaissanceMax($naissance_max) { $this->naissance_max=$naissance_max;}

    public function getNbMoisMini() { return $this->nb_mois_mini;}
    public function setnbMoisMini($nb_mois_mini) { $this->nb_mois_mini=$nb_mois_mini;}

    public function getCapacite() { return $this->capacite;}
    public function setCapacite($capacite) { $this->capacite=$capacite;}

    /*public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
    }*/
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