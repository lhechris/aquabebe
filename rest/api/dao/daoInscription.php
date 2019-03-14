<?php
include_once('daoClass.php');
include_once('api/objects/inscription.php');
include_once('api/objects/preinscription.php');
include_once('api/objects/personne.php');
include_once("api/mailcertificat.php");
include_once("api/mailvaccins.php");
include_once("config.php");

class daoInscription extends daoClass {

    /**
     * Met a jour le certificat et envoi le mail
     */
    public function get($id) {
        $inscrid = intval($id);
        if ($inscrid<=0){
            trace_error("Bad Id:".$id);
            return false;
        }

        $query ="select  ID,".                       /* 0 */
                        "ID_enfant,".                /* 1 */
                        "ID_creneau,".               /* 2 */
                        "date_max,".                 /* 3 */
                        "paiement,".                 /* 4 */
                        "paiement_date,".            /* 5 */
                        "certificat_medical,".       /* 6 */
                        "vaccins,".                  /* 7 */
                        "facture_remise,".           /* 8 */
                        "diffusion_image,".          /* 9 */
                        "diffusion_image_date,".     /* 10 */
                        "diffusion_image_lieu,".     /* 11 */
                        "diffusion_image_signature,"./* 12 */
                        "reglement_interieur_date,". /* 13 */
                        "reglement_interieur_lieu,".      /* 14 */
                        "reglement_interieur_signature ". /* 15 */
                "from inscription ".
                "where ID=".$inscrid;

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }

        $inscription=new Inscription();

        foreach($liste as $r)
        {
            $inscription->setId($r[0]);
            $inscription->setEnfant($r[1]);
            $inscription->setCreneau($r[2]);
            $inscription->setDateMax($r[3]);
            $inscription->setPaiement($r[4]);
            $inscription->setPaiementDate($r[5]);
            $inscription->setCertificatMedical($r[6]);
            $inscription->setVaccins($r[7]);
            $inscription->setFactureRemise($r[8]);
            $inscription->setDiffusionImage($r[9]);
            $inscription->setDiffusionImageDate($r[10]);
            $inscription->setDiffusionImageLieu($r[11]);
            $inscription->setDiffusionImageSignature($r[12]);
            $inscription->setReglementInterieurDate($r[13]);
            $inscription->setReglementInterieurLieu($r[14]);
            $inscription->setReglementInterieurSignature($r[15]);
        }  
        return $inscription;

    }

    public function getReservations() {
        $query ="select  inscription.ID,".                       /* 0 */
                        "inscription.ID_enfant,".                /* 1 */
                        "inscription.ID_creneau,".               /* 2 */
                        "inscription.date_max,".                 /* 3 */
                        "inscription.paiement,".                 /* 4 */
                        "inscription.paiement_date,".            /* 5 */
                        "inscription.certificat_medical,".       /* 6 */
                        "inscription.vaccins,".                  /* 7 */
                        "inscription.facture_remise,".           /* 8 */
                        "inscription.diffusion_image,".          /* 9 */
                        "inscription.diffusion_image_date,".     /* 10 */
                        "inscription.diffusion_image_lieu,".     /* 11 */
                        "inscription.diffusion_image_signature,"./* 12 */
                        "inscription.reglement_interieur_date,". /* 13 */
                        "inscription.reglement_interieur_lieu,".      /* 14 */
                        "inscription.reglement_interieur_signature,". /* 15 */
                        "creneau.saison,".                            /* 16 */
                        "creneau.lieu,".                              /* 17 */
                        "creneau.jour,".                              /* 18 */
                        "creneau.heure,".                             /* 19 */
                        "creneau.age,".                               /* 20 */
                        "creneau.pour_fratrie,".                      /* 21 */
                        "creneau.naissance_min,".                     /* 22 */
                        "creneau.naissance_max,".                     /* 23 */
                        "creneau.nb_mois_mini,".                      /* 24 */
                        "creneau.capacite,".                          /* 25 */
                        "creneau.ID,".                                /* 26 */
                        "personne.nom,".                              /* 27 */
                        "personne.prenom,".                           /* 28 */
                        "personne.sexe,".                             /* 29 */
                        "personne.naissance,".                        /* 30 */
                        "preinscription.choix,".                      /* 31 */
                        "preinscription.reservation ".                /* 32 */
                "from personne, inscription,preinscription,creneau ".
                "where inscription.ID_enfant=personne.ID and ".
                "preinscription.id_inscription=inscription.ID and ".
                "creneau.ID=preinscription.ID_creneau and ".
                "creneau.saison='".CURRENT_SAISON."' ".
                "order by personne.ID";

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        $preinscriptions=array();

        foreach($liste as $r)
        {
            $inscription=new Inscription();
            $inscription->setId($r[0]);
            $inscription->setDateMax($r[3]);
            $inscription->setPaiement($r[4]);
            $inscription->setPaiementDate($r[5]);
            $inscription->setCertificatMedical($r[6]);
            $inscription->setVaccins($r[7]);
            $inscription->setFactureRemise($r[8]);
            $inscription->setDiffusionImage($r[9]);
            $inscription->setDiffusionImageDate($r[10]);
            $inscription->setDiffusionImageLieu($r[11]);
            $inscription->setDiffusionImageSignature($r[12]);
            $inscription->setReglementInterieurDate($r[13]);
            $inscription->setReglementInterieurLieu($r[14]);
            $inscription->setReglementInterieurSignature($r[15]);
            $creneau=new Creneau();
            $creneau->setId($r[26]);
            $creneau->setSaison($r[16]);
            $creneau->setLieu($r[17]);
            $creneau->setJour($r[18]);
            $creneau->setHeure($r[19]);
            $creneau->setAge($r[20]);
            $creneau->setPourFratrie($r[21]);
            $creneau->setNaissanceMin($r[22]);
            $creneau->setNaissanceMax($r[23]);
            $creneau->setNbMoisMini($r[24]);
            $creneau->setCapacite($r[25]);
            $enfant=new Personne();
            $enfant->setId($r[1]);
            $enfant->setPrenom($r[27]);
            $enfant->setNom($r[28]);
            $enfant->setSexe($r[29]);
            $enfant->setNaissance($r[30]);

            $inscription->setEnfant($enfant);
            $inscription->setCreneau($creneau);

            $preinscription=new PreInscription();
            $preinscription->setInscription($inscription);
            $preinscription->setCreneau($creneau);
            $preinscription->setChoix($r[31]);
            $preinscription->setReservation($r[32]);

            array_push($preinscriptions,$preinscription);
        }  
        return $preinscriptions;

    }


    public function insert($inscription)
    {

        $query="INSERT INTO inscription("
            ."ID_enfant,"
            ."ID_creneau,"
            ."date_max,"
            ."paiement,"
            ."paiement_date,"
            ."certificat_medical,"
            ."vaccins,"
            ."facture_remise,"
            ."diffusion_image,"
            ."diffusion_image_date,"
            ."diffusion_image_lieu,"
            ."diffusion_image_signature,"
            ."reglement_interieur_date,"
            ."reglement_interieur_lieu,"
            ."reglement_interieur_signature) VALUES(";
               
        $query.=$inscription->getEnfant()->getId().",";
        $query.=$inscription->getCreneau()->getId().",";
        $query.="'".$inscription->getDateMax()."',";
        $query.=$this->intornull($inscription->getPaiement()).",";
        $query.=$this->strornull($inscription->getPaiementDate()).",";
        $query.=$this->intornull($inscription->getCertificatMedical()).",";
        $query.=$this->intordefault($inscription->getVaccins(),0).",";
        $query.=$this->intornull($inscription->getFactureRemise()).",";
        $query.=$this->intornull($inscription->getDiffusionImage()).",";
        $query.=$this->strornull($inscription->getDiffusionImageDate()).",";
        $query.=$this->strornull($inscription->getDiffusionImageLieu()).",";
        $query.=$this->strornull($inscription->getDiffusionImageSignature()).",";
        $query.=$this->strornull($inscription->getReglementInterieurDate()).",";
        $query.=$this->strornull($inscription->getReglementInterieurLieu()).",";
        $query.=$this->strornull($inscription->getReglementInterieurSignature());
        $query.=")";
        trace_info($query);

        try {
            $stmt=$this->pdo->query($query);
            $inscriptionid=$this->pdo->lastInsertId();
            $inscription->setId($inscriptionid);            
            trace_info("Return id:".$inscriptionid);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;
    }

    public function insertPreinscription($preinscription)
    {

        trace_info("insert preinscription: inscription=".$preinscription->getInscription()->getId()." creneau=".$preinscription->getCreneau()->getId());
        $query="insert into preinscription( 	ID_inscription,ID_creneau,choix,reservation)  values(";
               
        $query.=$preinscription->getInscription()->getId().",";
        $query.=$preinscription->getCreneau()->getId().",";
        $query.=$preinscription->getChoix().",";
        $query.=$preinscription->getReservation();
        $query.=")";

        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;
    }

    public function addPaiement($inscription) {

        trace_info("Ajoute le paiement ".$inscription->getPaiement()." a l'inscription ".$inscription->getId());
        $query ="update inscription set paiement=".$inscription->getPaiement()." ";
        $query.="where id=".$inscription->getId();

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;
    }

    public function updateCreneau($inscription) {

        trace_info("Defini le creneau ".$inscription->getCreneauid()." a l'inscription ".$inscription->getId());
        $query ="update inscription set id_creneau=".$inscription->getCreneauid()." ";
        $query.="where id=".$inscription->getId();

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        
        //met la reservation pour le creneau
        $query ="update preinscription set reservation=1 ";
        $query.="where id_creneau=".$inscription->getCreneauid()." and ";
        $query.="id_inscription=".$inscription->getId();

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        //remet a 0 les autres prereservations 
        $query ="update preinscription set reservation=0 ";
        $query.="where id_creneau!=".$inscription->getCreneauid()." and ";
        $query.="id_inscription=".$inscription->getId();

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        //TODO envoi le mail

        return true;
    }

    /**
     * Met a jour le certificat et envoi le mail
     */
    public function updateCertificat($inscription) {
        $this->updateCertificatVaccinsFacture($inscription,true,false,false);    
    }
    /**
     * Met a jour le vaccins et envoi le mail
     */
    public function updateVaccins($inscription) {
        $this->updateCertificatVaccinsFacture($inscription,false,true,false);    
    }
    /**
     * Met a jour la facture et envoi le mail ?? a vérifier
     */
    public function updatefacture($inscription) {
        $this->updateCertificatVaccinsFacture($inscription,false,false,true);    
    }

    private function updateCertificatVaccinsFacture($inscription,$iscertificat,$isvaccins,$isfacture) {
             
        $id = intval($inscription->getId());
        if ($id<=0){
            trace_error("Bad Id:".$inscription->getId());
            return false;
        }

        $query ="update inscription set ";
        if ($iscertificat) {$query .="certificat_medical=1 ";}
        if ($isvaccins) {$query .="vaccins=1 ";}
        if ($isfacture) {$query .="facture_remise=1 ";}
        $query.="where ID=".$id;

        trace_debug($query);
        
        try {
            $stmt=$this->pdo->query($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }

        //recherche l'enfant 
        $query = "select personne.id,".       /* 0 */
                        "personne.nom,".      /* 1 */
                        "personne.prenom,".   /* 2 */
                        "personne.sexe,".     /* 3 */
                        "personne.naissance,"./* 4 */
                        "personne.type,".     /* 5 */
                        "personne.handicap,". /* 6 */
                        "personne.mel ".      /* 7 */
                 "from personne,inscription ".
                 "where inscription.ID=".$id." and ".
                 "inscription.ID_enfant=personne.ID";
        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }

        $enfant=new Personne();

        foreach($liste as $r)
        {
            $enfant->setId($r[0]);
            $enfant->setNom($r[1]);
            $enfant->setPrenom($r[2]);
            $enfant->setSexe($r[3]);
            $enfant->setNaissance($r[4]);
            $enfant->setType($r[5]);
            $enfant->setHandicap($r[6]);
            $enfant->setMel($r[7]);
        } 
        if ($iscertificat) { mailcertificat($enfant);}
        if ($isvaccins) { mailvaccins($enfant);}
        if ($isfacture) { /*TO DO check if we need to send mail*/}

        return true;

    }



    private function strornull($v)
    {
        if ($v=="") {
            return "NULL";
        }else {
            return "'".$v."'";
        }

    }
    private function intornull($v)
    {
        if ($v=="") {
            return "NULL";
        }else {
            return $v;
        }
    }
    private function intordefault($v,$def)
    {
        if ($v=="") {
            return $def;
        }else {
            return $v;
        }
    }

}


?>