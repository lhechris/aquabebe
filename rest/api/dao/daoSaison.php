<?php

include_once('daoClass.php');
include_once("config.php");

class daoSaison extends daoClass {


    /**
     * Retourne l'objet paiement donne par id
     */
    public function getAll() {

        $query="select saison from creneau group by saison";
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
        $saisons=[];

        trace_info(print_r($liste,true));
        foreach($liste as $r)
        {
            array_push($saisons,$r[0]);
        }

        return $saisons;
    }

}


?>