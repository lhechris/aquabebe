<?php
    class dtoAdherent {
        private $id;
        private $nom;
        private $prenom;
        private $naissance;
        private $creneau;
        private $certificat;
        private $vaccins;
        private $facture;
    
        public function getId() { return $this->id;}
        public function setId($id) { $this->id=$id;}
    
        public function getNom() { return $this->nom;}
        public function setNom($nom) { $this->nom=$nom;}
       
        public function getPrenom() { return $this->prenom;}
        public function setPrenom($prenom) { $this->prenom=$prenom;}
    
        public function getNaissance() { return $this->naissance;}
        public function setNaissance($naissance) { $this->naissance=$naissance;}
    
        public function getCreneau() { return $this->creneau;}
        public function setCreneau($v) { $this->creneau=$v;}
    
        public function getCertificat() { return $this->certificat;}
        public function setCertificat($v) { $this->certificat=$v;}
    
        public function getVaccins() { return $this->vaccins;}
        public function setVaccins($v) { $this->vaccins=$v;}
    
        public function getFacture() { return $this->facture;}
        public function setFacture($v) { $this->facture=$v;}

        public function toArray() {
            $vars = get_object_vars($this);
            return $vars;
        }
    } 
?>