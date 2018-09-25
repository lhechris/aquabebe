<?php

include_once('daoClass.php');
include_once('api/objects/paiement.php');
include_once("config.php");

class daoPaiement extends daoClass {


    /**
     * Ajoute un nouveau paiement
     */
    public function insert($obj)
    {        
        /*$query="insert into paiement(payeur,montant,moyen,mois,remarques) values(";
        $query.="'".$obj->getPayeur()."',";
        $query.=$obj->getMontant().",";
        $query.="'".$obj->getMoyen()."',";
        $query.="'".$obj->getMois()."',";
        $query.="'".$obj->getRemarques()."'";
        $query.=")";

        trace_info($query);
        $paiementid=-1;
        try {
            $stmt=$this->pdo->query($query);
            $paiementid=$this->pdo->lastInsertId();
            $obj->setId($paiementid);
            trace_info("Return id=$paiementid");
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return false;
        }
        return true;*/

        $values=array(
            "payeur"    => $this->pdo->quote($obj->getPayeur()),
            "montant"   => intval($obj->getMontant()),
            "moyen"     => $this->pdo->quote($obj->getMoyen()),
            "mois"      => $this->pdo->quote($obj->getMois()),
            "remarques" => $this->pdo->quote($obj->getRemarques())    
        );

        $identifiant=$this->doInsert("paiement",$values);
        $obj->setId($identifiant);
    }


    /**
     * Retourne l'objet paiement donne par id
     */
    public function get($id) {

        //TODO test id
        $identifiant=intval($id);

        $query="select id, ".       /* 0 */
                      "payeur, ".   /* 1 */
                      "montant, ".  /* 2 */
                      "moyen, ".    /* 3 */
                      "mois,".      /* 4 */
                      "remarques ". /* 5 */
        "from paiement where id=$identifiant ";
        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return NULL;
        }

        if (count($liste)==0) { return NULL;}
        $paiement=new Paiement();

        foreach($liste as $r)
        {
            $paiement->setId($r[0]);
            $paiement->setPayeur($r[1]);
            $paiement->setMontant($r[2]);
            $paiement->setMoyen($r[3]);
            $paiement->setMois($r[4]);
            $paiement->setRemarques($r[5]);
        }

        return $paiement;
    }


    /**
     * Modifie le paiement 
     */
    public function update($oldpaiement,$newpaiement) {
        
        $values=array();
        if ($oldpaiement->getPayeur()!=$newpaiement->getPayeur()) {
            array_push($values,"payeur=".$this->pdo->quote($newpaiement->getPayeur()));
        }
        if ($oldpaiement->getMontant()!=$newpaiement->getMontant()) {
            array_push($values,"montant=".$this->pdo->quote($newpaiement->getMontant()));
        }
        if ($oldpaiement->getMoyen()!=$newpaiement->getMoyen()) {
            array_push($values,"moyen=".$this->pdo->quote($newpaiement->getMoyen()));
        }
        if ($oldpaiement->getMois()!=$newpaiement->getMois()) {
            array_push($values,"mois=".$this->pdo->quote($newpaiement->getMois()));
        }
        if ($oldpaiement->getRemarques()!=$newpaiement->getRemarques()) {
            array_push($values,"remarques=".$this->pdo->quote($newpaiement->getRemarques()));
        }
        
        $this->doUpdate("paiement",$oldpaiement->getId(),$values);


    }


}


?>