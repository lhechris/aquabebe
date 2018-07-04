<?php
include_once('daoClass.php');
include_once('inscription.php');

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

        trace_info("insert preinscription: inscription=".$preinscription->getInscription()->getId()." creneau=".$inscription->getCreneau()->getId());
        $query="insert into preincription( 	ID_inscription,ID_creneauPrimaire,choixPrimaire,reservation)  values(";
               
        $query.=$preinscription->getInscription()->getId().",";
        $query.=$preinscription->getCreneau()->getId().",";
        $query.=$preinscription->getChoix().",";
        $query.=$preinscription->getReservation();
        $query.=")";

        try {
            $stmt=$this->pdo->query($query);
            $inscriptionid=$this->pdo->lastInsertId();
            trace_info($query);
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
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