<?php
include_once('daoClass.php');
include_once('api/objects/creneau.php');
include_once('api/objects/personne.php');
include_once('config.php');

class daoCreneau extends daoClass {

    public function getAll()
    {
        $query="select creneau.id,creneau.lieu,creneau.heure,creneau.jour,creneau.age,creneau.capacite,personne.prenom,personne.naissance,personne.id,preinscription.choix,preinscription.reservation ".
        "from creneau,inscription,personne,preinscription ".
        "where creneau.id=inscription.id_creneau ".
          "and inscription.ID_enfant=personne.id ".
          "and creneau.saison='".CURRENT_SAISON."' ".
          "and personne.type='enfant' ".
          "and preinscription.id_inscription=inscription.id ".
        "order by creneau.id";
        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }
        $creneaux=array();        
        foreach($liste as $r)
        {
            //Ne prend que les reservations primaire
            if ((string)$r[9]=="1") {
                if ((sizeof($creneaux)==0) || ($creneaux[sizeof($creneaux)-1]->getId()!=$r[0]))
                {
                    $creneau=new Creneau();
                    $creneau->setId($r[0]);
                    $creneau->setHeure($r[2]);
                    $creneau->setlieu($r[1]);
                    $creneau->setJour($r[3]);
                    $creneau->setAge($r[4]);
                    $creneau->setCapacite($r[5]);
                    array_push($creneaux,$creneau);
                }                
                $enfant=new Personne();
                $enfant->setId($r[8]);
                if ((string)$r[10]=="1") 
                {
                    $enfant->setPrenom($r[6]);
                    $enfant->setNaissance($r[7]);
                }
               /* else
                {
                    $enfant->setPrenom("?");
                    $enfant->setNaissance("");
                }*/
                $creneaux[sizeof($creneaux)-1]->addEnfant($enfant);
            }
        }
        return $creneaux;
    }

    public function getByNaissance($naissance)
    {
        //check date format YYYY-MM-DD
        $naissance=htmlentities($naissance);
        list($y,$m,$d)=sscanf($naissance,"%d-%d-%d");
        if (($y<2001) || ($m<1) || ($m>12) || ($d<1) || ($d>31)) { return array();}

        $naissance="$y-$m-$d";

        try {
            $stmt=$this->pdo->query("SELECT creneau.id,creneau.lieu,creneau.heure,creneau.jour,creneau.age,creneau.capacite,count(*),creneau.naissance_min,creneau.naissance_max ".
                                    "FROM creneau,inscription ".
                                    "WHERE creneau.id=inscription.id_creneau ".
                                          "AND creneau.saison='".CURRENT_SAISON."' ".
                                          "AND date(creneau.naissance_min)<=date('$naissance') AND date(creneau.naissance_max)>=date('$naissance') ".
                                    "GROUP BY (creneau.id) ORDER BY creneau.lieu,creneau.jour,creneau.heure");
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }
        $creneaux=array();        
        foreach($liste as $r)
        {
            $creneau=new Creneau();
            $creneau->setId($r[0]);
            $creneau->setHeure($r[2]);
            $creneau->setLieu($r[1]);
            $creneau->setJour($r[3]);
            $creneau->setAge($r[4]);
            $creneau->setCapacite($r[5]);
            $creneau->setNbInscrit($r[6]);
            $creneau->setNaissanceMin($r[7]);
            $creneau->setNaissanceMax($r[8]);
            array_push($creneaux,$creneau);
        }
        return $creneaux;
    }

    /**
     * Retourne la liste des creneaux
     */
    function getList() {
        
        try {
            $query="SELECT id,lieu,heure,jour ".
            "FROM creneau ".
            "WHERE saison='".CURRENT_SAISON."' ".
            "ORDER BY lieu,jour,heure";

            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return array();            
        }
        $creneaux=array();
        foreach($liste as $r)
        {
            $creneau=new Creneau();
            $creneau->setId($r[0]);
            $creneau->setLieu($r[1]);
            $creneau->setHeure($r[2]);
            $creneau->setJour($r[3]);
            array_push($creneaux,$creneau);
        }
        return $creneaux;
    }

    /**
     * Retourne la liste des email d'un creneaux
     */
    function getEmails($id) {
        
        //TODO check id

        $emails=array();
        try {
            $query="SELECT personne.mel ".
            "FROM inscription,personne ".
            "WHERE inscription.id_creneau=".$id." ".
              "and inscription.ID_enfant=personne.id ".
              "and personne.type='enfant' ";
    
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return array();            
        }

        foreach($liste as $r)
        {
            array_push($emails,$r[0]);
        }
        return $emails;
    }


}


?>