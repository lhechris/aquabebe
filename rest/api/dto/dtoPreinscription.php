<?php
    class dtoPreinscription {
        private $creneau;
        private $creneauid;
        private $inscriptionid;
        private $choix;
        private $reservation;

        public function getCreneau() { return $this->creneau;  }
        public function setCreneau($creneau)  {  $this->creneau = $creneau; }

        public function getCreneauid() { return $this->creneauid;  }
        public function setCreneauid($creneauid)  {  $this->creneauid = $creneauid; }

        public function getInscriptionid() { return $this->inscriptionid;  }
        public function setInscriptionid($inscriptionid)  {  $this->inscriptionid = $inscriptionid; }

        public function getChoix() { return $this->choix;  }
        public function setChoix($choix)  {  $this->choix = $choix; }

        public function getReservation() { return $this->reservation;  }
        public function setReservation($reservation)  {  $this->reservation = $reservation; }

        public function toArray() {
            $vars = get_object_vars($this);
            return $vars;
        }
    }
?>