<?php
include_once('daoClass.php');
include_once('personne.php');

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
        if ($this->_insert($parent2)==false){
            return false;
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
}


?>