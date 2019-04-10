<?php
include_once('daoClass.php');
include_once('api/dto/dtoEnfant.php');
include_once('api/dto/dtoPreinscription.php');
include_once('api/dto/dtoParent.php');
include_once("daoPaiement.php");

class daoEnfant extends daoClass {

    public function get($id) {

        //TODO test id
        
        $query="select personne.id, ".                /* 0 */
                       "personne.prenom, ".           /* 1 */
                       "personne.nom, ".              /* 2 */
                       "personne.naissance, ".        /* 3 */
                       "personne.tel,".               /* 4 */
                       "personne.adresse,".           /* 5 */
                       "personne.cp,".                /* 6 */
                       "personne.commune,".           /* 7 */
                       "personne.handicap,".          /* 8 */
                       "personne.mel,".               /* 9 */
                       "personne.sexe,".              /* 10 */
                       "creneau.id, ".                /* 11 */
                       "creneau.lieu, ".              /* 12 */
                       "creneau.jour, ".              /* 13 */
                       "creneau.heure, ".             /* 14 */
                       "inscription.id, ".            /* 15 */
                       "inscription.date_max, ".      /* 16 */
                       "inscription.paiement, ".      /* 17 */
                       "inscription.paiement_date, ".                /* 18 */
                       "inscription.certificat_medical, ".           /* 19 */
                       "inscription.vaccins, ".                      /* 20 */
                       "inscription.facture_remise, ".               /* 21 */
                       "inscription.diffusion_image, ".              /* 22 */
                       "inscription.diffusion_image_date, ".         /* 23 */
                       "inscription.diffusion_image_lieu, ".         /* 24 */
                       "inscription.diffusion_image_signature, ".    /* 25 */
                       "inscription.reglement_interieur_date, ".     /* 26 */
                       "inscription.reglement_interieur_lieu, ".     /* 27 */
                       "inscription.reglement_interieur_signature, "./* 28 */
                       "inscription.id_creneau,".                    /* 29 */
                       "preinscription.choix, ".                     /* 30 */
                       "preinscription.reservation ".                /* 31 */
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
        $enfant=new dtoEnfant();

        foreach($liste as $r)
        {
            $enfant->setId($r[0]);
            $enfant->setPrenom(html_entity_decode($r[1]));
            $enfant->setNom(html_entity_decode($r[2]));
            $enfant->setNaissance($r[3]);
            $enfant->setTelephone($r[4]);
            $enfant->setAdresse(html_entity_decode($r[5]));
            $enfant->setCp($r[6]);
            $enfant->setCommune(html_entity_decode($r[7]));
            $enfant->setHandicap($r[8]);
            $enfant->setMel($r[9]);
            $enfant->setSexe($r[10]);

            $preinsc=new dtoPreinscription();
            $preinsc->setCreneauid($r[11]);
            $preinsc->setCreneau($r[12]." ".$r[13]." ".$r[14]);
            $preinsc->setInscriptionid($r[15]);
            $preinsc->setChoix($r[30]);
            $preinsc->setReservation($r[31]);
            
            $enfant->setInscriptionid($r[15]);

            $enfant->setDateMax($r[16]);
            $enfant->setPaiementid($r[17]);
            $enfant->setPaiementdate($r[18]);
            $enfant->setCertificatMedical($r[19]);
            $enfant->setVaccins($r[20]);
            $enfant->setFactureRemise($r[21]);
            $enfant->setDiffusionImage($r[22]);
            $enfant->setDiffusionImageDate($r[23]);
            $enfant->setDiffusionImageLieu($r[24]);
            $enfant->setDiffusionImageSignature($r[25]);
            $enfant->setReglementInterieurDate($r[26]);
            $enfant->setReglementInterieurLieu($r[27]);
            $enfant->setReglementInterieurSignature($r[28]);

            array_push($preinscriptions,$preinsc);
        }
        $enfant->setPreinscriptions($preinscriptions);
        
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
            trace_debug("Return ".count($liste)." parents");
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }

        $parents=array();
        foreach($liste as $r)
        {
            $parent=new dtoParent();
            $parent->setId($r[0]);
            $parent->setPrenom(html_entity_decode($r[1]));
            $parent->setNom(html_entity_decode($r[2]));
            $parent->setTelephone($r[4]);
            array_push($parents,$parent);
        }
        $enfant->setParents($parents);

        //recherche paiement
        $daopaiement=new daoPaiement();
        $paiement=$daopaiement->get($enfant->getPaiementid());
        if ($paiement!=null) {
            $enfant->setPayeur($paiement->getPayeur());
            $enfant->setMontant($paiement->getMontant());
            $enfant->setMoyen($paiement->getMoyen());
            $enfant->setMois($paiement->getMois());
            $enfant->setRemarques($paiement->getRemarques());
        }
        return $enfant;
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