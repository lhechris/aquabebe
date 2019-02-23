<?php
    class dtoFacture {

        private $nom;
        private $prenom;
        private $payeur;
        private $montant;
        private $naissance;
        private $jour;
        private $heure;
        private $lieu;

        public function toArray() {
            $vars = get_object_vars($this);
            return $vars;
        }
    

        public function getNom() { return $this->nom;  }
        public function setNom($nom)  {  $this->nom = $nom; }

        public function getPrenom() { return $this->prenom;  }
        public function setPrenom($prenom)  {  $this->prenom = $prenom; }

        public function getPayeur() { return $this->payeur;  }
        public function setPayeur($payeur)  {  $this->payeur = $payeur; }

        public function getMontant() { return $this->montant;  }
        public function setMontant($montant)  {  $this->montant = $montant; }

        public function getNaissance() { return $this->naissance;  }
        public function setNaissance($naissance)  {  $this->naissance = $naissance; }

        public function getJour() { return $this->jour;  }
        public function setJour($jour)  {  $this->jour = $jour; }

        public function getHeure() { return $this->heure;  }
        public function setHeure($heure)  {  $this->heure = $heure; }

        public function getLieu() { return $this->lieu;  }
        public function setLieu($lieu)  {  $this->lieu = $lieu; }
    }
?>