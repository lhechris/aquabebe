<?php
include_once('daoClass.php');
include_once('inscription.php');

class daoInscription extends daoClass {

    public function insert($inscription)
    {

        trace_info("insert : ".$inscription->getEnfant()->getNom());
        $query="insert into incription(ID_enfant,ID_creneau,date_max,paiement,paiement_date,certificat_medical,vaccins,facture_remise,diffusion_image,".
        "diffusion_image_date,diffusion_image_lieu,diffusion_image_signature,reglement_interieur_date,reglement_interieur_lieu,".
        "reglement_interieur_signature values(";
               
        $query.=$inscription->getEnfant()->getId().",";
        $query.=$inscription->getCreneau().",";
        $query.="'".$inscription->getDateMax()."',";
        $query.=$inscription->getPaiement().",";
        $query.="'".$inscription->getPaiementDate()."',";
        $query.=$inscription->getCertificatMedical().",";
        $query.=$inscription->getVaccins().",";
        $query.=$inscription->getFactureRemise().",";
        $query.=$inscription->getDiffusionImage().",";
        $query.="'".$inscription->getdiffusion_image_date()."',";
        $query.="'".$inscription->getdiffusion_image_lieu()."',";
        $query.="'".$inscription->getdiffusion_image_signature()."',";
        $query.="'".$inscription->getreglement_interieur_date()."',";
        $query.="'".$inscription->getreglement_interieur_lieu()."',";
        $query.="'".$inscription->getreglement_interieur_signature()."'";
        $query.=")";

        try {
            $stmt=$this->pdo->query($query);
            $inscriptionid=$this->pdo->lastInsertId();
            $inscription->setId($inscriptionid);            
        }catch(PDOException  $e ){
            trace_info("Error $e\n");
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
        }catch(PDOException  $e ){
            trace_info("Error $e\n");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;
    }

}


?>