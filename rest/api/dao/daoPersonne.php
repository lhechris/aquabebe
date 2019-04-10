<?php
include_once('daoClass.php');
include_once('api/objects/personne.php');
include_once('api/objects/inscription.php');
include_once("api/objects/preinscription.php");
include_once('api/objects/creneau.php');

class daoPersonne extends daoClass {

    private function _insert($obj)
    {
        $query="insert into personne(prenom,nom,sexe,naissance,handicap,type,adresse,cp,commune,tel,tel2,mel) values(";
        $query.="'".$obj->getPrenom()."',";
        $query.="'".$obj->getNom()."',";
        if ($obj->getSexe()=="") {$query.='NULL,';} else { $query.= $obj->getSexe().",";}
        if ($obj->getNaissance()=="") {$query.='NULL,';} else { $query.= "'".$obj->getNaissance()."',";}
        if ($obj->getHandicap()=="") {$query.='0x00,';} else { $query.= $obj->getHandicap().",";}
        $query.="'".$obj->getType()."',";
        $query.="'".$obj->getAdresse()."',";
        if ($obj->getCp()=="") {$query.='NULL,';} else { $query.= $obj->getCp().",";}
        $query.="'".$obj->getCommune()."',";
        $query.="'".$obj->getTel()."',";
        $query.="'".$obj->getTel2()."',";
        $query.="'".$obj->getMel()."'";
        $query.=")";

        trace_info($query);
        $personneid=-1;
        try {
            $stmt=$this->pdo->query($query);
            $personneid=$this->pdo->lastInsertId();
            $obj->setId($personneid);
            trace_info("Return id=$personneid");
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;
    }

    public function insert($enfant,$parent1,$parent2)
    {
        $enfant->setType('enfant');
        $parent1->setType('parent');
        $parent2->setType('parent');

        if ($this->_insert($enfant)==false){
            return false;
        }
        if ($this->_insert($parent1)==false){
            return false;
        }
        if ($parent2->getNom()!="") {
            if ($this->_insert($parent2)==false){
                return false;
            }
        }
        
        $query="insert into enfant(ID_enfant,ID_personne) values(".$enfant->getID().",".$parent1->getID().")";
        try {
            $stmt=$this->pdo->query($query);
            trace_info("insert enfant ".$enfant->getID()." / parent1 ".$parent2->getID()." ok");
            trace_info($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        if ($parent2->getID()!="") {
            $query="insert into enfant(ID_enfant,ID_personne) values(".$enfant->getID().",".$parent2->getID().")";
            try {
                $stmt=$this->pdo->query($query);
                trace_info($query);
            }catch(PDOException  $e ){
                trace_info("Error $e");
                trace_error("Error ".$query."\n  ".$e);
                return false;
            }
        }
        return true;
    }


    public function get($saison) {

        if (strlen($saison)!=9) {
            trace_error("daoPersonne::get bad saison length expected 9");
            return false;
        }

        $query="select personne.id, ".                /* 0 */
                       "personne.prenom, ".           /* 1 */
                       "personne.nom, ".              /* 2 */
                       "personne.naissance, ".        /* 3 */
                       "personne.tel,".               /* 4 */
                       "personne.adresse,".           /* 5 */
                       "personne.cp,".                /* 6 */
                       "personne.commune,".           /* 7 */                       
                       "creneau.id, ".                /* 8 */
                       "creneau.lieu, ".              /* 9 */
                       "creneau.jour, ".              /* 10 */
                       "creneau.heure, ".             /* 11 */
                       "inscription.id, ".            /* 12 */
                       "inscription.paiement, ".      /* 13 */
                       "preinscription.choix, ".      /* 14 */
                       "preinscription.reservation, "./* 15 */
                       "paiement.id, ".               /* 16 */ 
                       "paiement.montant, ".          /* 17 */
                       "paiement.mois ".              /* 18 */
        "from creneau,inscription,personne,preinscription,paiement ".
        "where creneau.id=preinscription.id_creneau ".
          "and inscription.ID_enfant=personne.id ".
          "and creneau.saison='$saison' ".
          "and personne.type='enfant' ".
          "and preinscription.id_inscription=inscription.id ".
          "and preinscription.reservation=1 ".
          "and paiement.id=inscription.paiement ".
        "order by personne.nom,personne.prenom,preinscription.choix";
        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return array();
        }
        $personnes=array();        
        foreach($liste as $r)
        {
            $enfant=new Personne();
            $enfant->setId($r[0]);
            $enfant->setPrenom($r[1]);
            $enfant->setNom($r[2]);
            $enfant->setNaissance($r[3]);
            $enfant->setTel($r[4]);
            $enfant->setAdresse($r[5]);
            $enfant->setCp($r[6]);
            $enfant->setCommune($r[7]);

            $creneau=new Creneau();
            $creneau->setId($r[8]);
            $creneau->setLieu($r[9]);
            $creneau->setJour($r[10]);
            $creneau->setHeure($r[11]);

            $inscription=new Inscription();
            $inscription->setId($r[12]);
            $inscription->setPaiement($r[13]);

            $paiement=new Paiement();
            $paiement->setId($r[16]);
            $paiement->setMontant($r[17]);
            $paiement->setMois($r[18]);

            $preinscription=new Preinscription();
            $preinscription->setInscription($inscription);
            $preinscription->setCreneau($creneau);
            $preinscription->setChoix($r[14]);
            $preinscription->setReservation($r[15]);


            array_push($personnes,array("enfant"=>$enfant,"preinscription"=>$preinscription,"paiement"=>$paiement ));
        }
        return $personnes;

    }


    public function getById($id) {

        //TODO test id
        
        $query="select personne.id, ".                /* 0 */
                       "personne.prenom, ".           /* 1 */
                       "personne.nom, ".              /* 2 */
                       "personne.naissance, ".        /* 3 */
                       "personne.tel,".               /* 4 */
                       "personne.adresse,".           /* 5 */
                       "personne.cp,".                /* 6 */
                       "personne.commune,".           /* 7 */                       
                       "creneau.id, ".                /* 8 */
                       "creneau.lieu, ".              /* 9 */
                       "creneau.jour, ".              /* 10 */
                       "creneau.heure, ".             /* 11 */
                       "inscription.id, ".            /* 12 */
                       "inscription.date_max, ".      /* 13 */
                       "inscription.paiement, ".      /* 14 */
                       "inscription.paiement_date, ".                /* 15 */
                       "inscription.certificat_medical, ".           /* 16 */
                       "inscription.vaccins, ".                      /* 17 */
                       "inscription.facture_remise, ".               /* 18 */
                       "inscription.diffusion_image, ".              /* 19 */
                       "inscription.diffusion_image_date, ".         /* 20 */
                       "inscription.diffusion_image_lieu, ".         /* 21 */
                       "inscription.diffusion_image_signature, ".    /* 22 */
                       "inscription.reglement_interieur_date, ".     /* 23 */
                       "inscription.reglement_interieur_lieu, ".     /* 24 */
                       "inscription.reglement_interieur_signature, "./* 25 */
                       "inscription.id_creneau,".                    /* 26 */
                       "preinscription.choix, ".                     /* 27 */
                       "preinscription.reservation ".                /* 28 */
        "from creneau,inscription,personne,preinscription ".
        "where creneau.id=preinscription.id_creneau ".
          "and inscription.ID_enfant=personne.id ".
          "and personne.id=$id ".
          "and preinscription.id_inscription=inscription.id ".
        "order by preinscription.choix";
        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }

        $preinscriptions=array();
        $enfant=new Personne();

        foreach($liste as $r)
        {
            $enfant->setId($r[0]);
            $enfant->setPrenom(html_entity_decode($r[1]));
            $enfant->setNom(html_entity_decode($r[2]));
            $enfant->setNaissance($r[3]);
            $enfant->setTel($r[4]);
            $enfant->setAdresse(html_entity_decode($r[5]));
            $enfant->setCp($r[6]);
            $enfant->setCommune(html_entity_decode($r[7]));

            $creneau=new Creneau();
            $creneau->setId($r[8]);
            $creneau->setLieu(html_entity_decode($r[9]));
            $creneau->setJour($r[10]);
            $creneau->setHeure($r[11]);

            $inscription=new Inscription();
            $inscription->setId($r[12]);
            $inscription->setDateMax($r[13]);
            $inscription->setPaiement($r[14]);
            $inscription->setPaiementDate($r[15]);
            $inscription->setCertificatMedical($r[16]);
            $inscription->setVaccins($r[17]);
            $inscription->setCreneauid($r[26]);

            $preinscription=new Preinscription();
            $preinscription->setInscription($inscription);
            $preinscription->setCreneau($creneau);
            $preinscription->setChoix($r[27]);
            $preinscription->setReservation($r[28]);

            array_push($preinscriptions,$preinscription);
        }
        
        //recherche les parents
        $query="select personne.id, ".                /* 0 */
                       "personne.prenom, ".           /* 1 */
                       "personne.nom, ".              /* 2 */
                       "personne.naissance, ".        /* 3 */
                       "personne.tel,".               /* 4 */
                       "personne.adresse,".           /* 5 */
                       "personne.cp,".                /* 6 */
                       "personne.commune ".           /* 7 */                       
        "from personne,enfant ".
        "where enfant.id_enfant=$id ".
        "and enfant.ID_personne=personne.id ".
        "and enfant.ID_enfant!=enfant.ID_personne ".
        "order by personne.id";

        trace_debug($query);

        $liste=array();
        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }

        $parents=array();
        foreach($liste as $r)
        {
            $parent=new Personne();
            $parent->setId($r[0]);
            $parent->setPrenom(html_entity_decode($r[1]));
            $parent->setNom(html_entity_decode($r[2]));
            $parent->setNaissance($r[3]);
            $parent->setTel($r[4]);
            $parent->setAdresse(html_entity_decode($r[5]));
            $parent->setCp($r[6]);
            $parent->setCommune(html_entity_decode($r[7]));
            array_push($parents,$parent);
        }

        return array("enfant"=>$enfant,"preinscriptions"=>$preinscriptions,"parents"=>$parents);
    }


    /**
     * UPDATE personne
     */
    function update($oldpers,$newpers)
    {
        $values=array();
        if ($oldpers->getPrenom() != $newpers->getPrenom()) {
            array_push($values,"prenom='".$newpers->getPrenom()."'");
        }
        if ($oldpers->getNom() != $newpers->getNom()) {
            array_push($values,"nom='".$newpers->getNom()."'");
        }
        if ($oldpers->getSexe() != $newpers->getSexe()) {
            array_push($values,"sexe=".$newpers->getSexe());
        }
        if ($oldpers->getNaissance() != $newpers->getNaissance()) {
            array_push($values,"naissance='".$newpers->getNaissance()."'");
        }
        if ($oldpers->getHandicap() != $newpers->getHandicap()) {
            array_push($values,"handicap=".$newpers->getHandicap());
        }
        if ($oldpers->getType() != $newpers->getType()) {
            array_push($values,"type='".$newpers->getType()."'");
        }
        if ($oldpers->getProfession() != $newpers->getProfession()) {
            array_push($values,"profession='".$newpers->getProfession()."'");
        }
        if ($oldpers->getAdresse() != $newpers->getAdresse()) {
            array_push($values,"adresse='".$newpers->getAdresse()."'");
        }
        if ($oldpers->getCp() != $newpers->getCp()) {
            array_push($values,"cp=".$newpers->getCp());
        }
        if ($oldpers->getCommune() != $newpers->getCommune()) {
            array_push($values,"commune='".$newpers->getCommune()."'");
        }
        if ($oldpers->getTel() != $newpers->getTel()) {
            array_push($values,"tel='".$newpers->getTel()."'");
        }
        if ($oldpers->getTel2() != $newpers->getTel2()) {
            array_push($values,"tel2='".$newpers->getTel2()."'");
        }
        if ($oldpers->getMel() != $newpers->getMel()) {
            array_push($values,"mel='".$newpers->getMel()."'");
        }

        return $this->doUpdate("personne",$oldpers->getId(),$values);

    }


}


?>