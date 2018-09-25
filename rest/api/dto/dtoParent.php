<?php
    class dtoParent {
        private $id;
        private $nom;
        private $prenom;
        private $telephone;        

        public function getId() { return $this->id;  }
        public function setId($id)  {  $this->id = $id; }

        public function getNom() { return $this->nom;  }
        public function setNom($nom)  {  $this->nom = $nom; }

        public function getPrenom() { return $this->prenom;  }
        public function setPrenom($prenom)  {  $this->prenom = $prenom; }

        public function getTelephone() { return $this->telephone;  }
        public function setTelephone($telephone)  {  $this->telephone = $telephone; }

        public function toArray() {
            $vars = get_object_vars($this);
            return $vars;
        }
    }
?>