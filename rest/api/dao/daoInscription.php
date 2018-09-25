<?php
include_once('daoClass.php');
include_once('api/objects/inscription.php');
include_once('api/objects/preinscription.php');

class daoInscription extends daoClass {

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