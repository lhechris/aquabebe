<?php

class dtoCreneauPreinscrit {
    private $id;
    private $nom;
    private $prenom;
    private $naissance;
    private $age;
    private $choix;
    private $validation;

    public function getId() { return $this->id;  }
    public function setId($id)  {  $this->id = $id; }

    public function getNom() { return $this->nom;  }
    public function setNom($nom)  {  $this->nom = $nom; }

    public function getPrenom() { return $this->prenom;  }
    public function setPrenom($prenom)  {  $this->prenom = $prenom; }

    public function getNaissance() { return $this->naissance;  }
    public function setNaissance($naissance)  {  $this->naissance = $naissance; }

    public function getAge() { return $this->age;  }
    public function setAge($age)  {  $this->age = $age; }

    public function getChoix() { return $this->choix;  }
    public function setChoix($choix)  {  $this->choix = $choix; }

    public function getValidation() { return $this->validation;  }
    public function setValidation($validation)  {  $this->validation = $validation; }

    public function toArray() {
        $vars = get_object_vars($this);
        return $vars;
    }

}

class dtoCreneau {
    private $id;
    private $lieu;
    private $jour;
    private $heure;
    private $age;
    private $pour_fratrie;
    private $capacite;
    private $preinscrits;
    private $remain;
    private $iscomplet;

    public function __construct()
    {
        $this->preinscrits=array();
    }
    public function getId() { return $this->id;  }
    public function setId($id)  {  $this->id = $id; }

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

    public function getCapacite() { return $this->capacite;}
    public function setCapacite($capacite) { $this->capacite=$capacite;}

    public function addPreinscrit($preinscrit) { array_push($this->preinscrits,$preinscrit);  }
    public function getPreinscrits() { return $this->preinscrits;  }
    public function setPreinscrits($enfants)  {  $this->preinscrits = $preinscrits; }

    public function getRemain() { return $this->remain;  }
    public function setRemain($remain)  {  $this->remain = $remain; }

    public function getIscomplet() { return $this->iscomplet;  }
    public function setIscomplet($iscomplet)  {  $this->iscomplet = $iscomplet; }

    public function toArray() {
        $vars = get_object_vars($this);
        if ($this->preinscrits!=null) {
            $vars["preinscrits"]=array();
            foreach($this->preinscrits as $p) {
                array_push($vars["preinscrits"],$p->toArray());
            }
        }
        return $vars;           
      }
  
    /*public function fromArray($json) {
        $vars = get_object_vars($this);
        foreach($json as $key => $value) {
            $valuesck=$value;
            if (array_key_exists($key,$vars)) {
                $this->$key=$valuesck;
            }
        }
    }*/
}
?>