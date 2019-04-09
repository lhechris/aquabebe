<?php
include_once('daoClass.php');
include_once('api/objects/creneau.php');
include_once('api/objects/personne.php');

include_once('config.php');

class daoCreneau extends daoClass {

    public function getAll($saison)
    {
        //TODO check saison
        $saison=$saison;
        if (($saison=="")|| ($saison=="current")) {$saison=CURRENT_SAISON;}

        $query="select creneau.id,".                 /* 0 */
                      "creneau.lieu,".               /* 1 */
                      "creneau.heure,".              /* 2 */
                      "creneau.jour,".               /* 3 */
                      "creneau.age,".                /* 4 */
                      "creneau.capacite,".           /* 5 */
                      "personne.prenom,".            /* 6 */
                      "personne.naissance,".         /* 7 */
                      "personne.id,".                /* 8 */
                      "preinscription.choix,".       /* 9 */
                      "preinscription.reservation ". /* 10 */
                      "from creneau ".
                      "left join inscription on creneau.id=inscription.id_creneau ".
                      "left join personne on inscription.ID_enfant=personne.id and personne.type='enfant' ".
                      "left join preinscription on preinscription.id_inscription=inscription.id and preinscription.id_creneau=creneau.id ".
                      "where creneau.saison='".$saison."' ".
                      "order by creneau.id ";
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
                    $creneau->setlieu($r[1]);
                    $creneau->setHeure($r[2]);
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

    public function listWithPreInscrits($saison)
    {
        //TODO check saison
        $saison=$saison;
        if (($saison=="")|| ($saison=="current")) {$saison=CURRENT_SAISON;}

        $query="select creneau.id,".                 /* 0 */
                      "creneau.lieu,".               /* 1 */
                      "creneau.heure,".              /* 2 */
                      "creneau.jour,".               /* 3 */
                      "creneau.age,".                /* 4 */
                      "creneau.capacite,".           /* 5 */
                      "personne.prenom,".            /* 6 */
                      "personne.naissance,".         /* 7 */
                      "personne.id,".                /* 8 */
                      "preinscription.choix,".       /* 9 */
                      "preinscription.reservation,". /* 10*/
                      "inscription.id ".             /* 11*/
                      "from creneau ".
                      "left join inscription on creneau.id=inscription.id_creneau ".
                      "left join personne on inscription.ID_enfant=personne.id and personne.type='enfant' ".
                      "left join preinscription on preinscription.id_inscription=inscription.id and preinscription.id_creneau=creneau.id ".
                      "where creneau.saison='".$saison."' ".
                      "order by creneau.id,inscription.id ";
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
            $creneau=null;
            if ((sizeof($creneaux)==0) || ($creneaux[sizeof($creneaux)-1]->getId()!=$r[0]))
            {
                $creneau=new Creneau();
                $creneau->setId($r[0]);
                $creneau->setlieu(html_entity_decode($r[1]));
                $creneau->setHeure(html_entity_decode($r[2]));
                $creneau->setJour($r[3]);
                $creneau->setAge($r[4]);
                $creneau->setCapacite($r[5]);
                array_push($creneaux,$creneau);
            } else {
                $creneau=$creneaux[sizeof($creneaux)-1];
            }              
            if ($r[9]!=null) {
                $inscription=new Inscription();
                $inscription->setId($r[11]);
                $preinscription=new Preinscription();
                $preinscription->setChoix($r[9]);
                $preinscription->setReservation($r[10]);
                $enfant=new Personne();
                $enfant->setPrenom(html_entity_decode($r[6]));
                $enfant->setNaissance($r[7]);
                $enfant->setId($r[8]);
                $inscription->setEnfant($enfant);
                $preinscription->setInscription($inscription);
                $creneau->addPreinscription($preinscription);
            }
        }
        return $creneaux;
    }

    public function getByNaissance($naissance)
    {
        //check date format YYYY-MM-DD
        $naissance=$naissance;
        list($y,$m,$d)=sscanf($naissance,"%d-%d-%d");
        if (($y<2001) || ($m<1) || ($m>12) || ($d<1) || ($d>31)) { return array();}

        $naissance="$y-$m-$d";

        try {
            $stmt=$this->pdo->query("SELECT creneau.id,creneau.lieu,creneau.heure,creneau.jour,creneau.age,creneau.capacite,count(*),creneau.naissance_min,creneau.naissance_max,creneau.nb_mois_mini ".
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
            $creneau->setHeure(html_entity_decode($r[2]));
            $creneau->setLieu(html_entity_decode($r[1]));
            $creneau->setJour($r[3]);
            $creneau->setAge($r[4]);
            $creneau->setCapacite($r[5]);
            $creneau->setNbInscrit($r[6]);
            $creneau->setNaissanceMin($r[7]);
            $creneau->setNaissanceMax($r[8]);
            $creneau->setNbMoisMini($r[9]);
            array_push($creneaux,$creneau);
        }
        return $creneaux;
    }

    public function getById($creneauid)
    {
        //TODO check ID
        $creneauid=htmlentities($creneauid);

        try {
            $stmt=$this->pdo->query("SELECT creneau.id,".             /* 0 */
                                            "creneau.lieu,".          /* 1 */
                                            "creneau.heure,".         /* 2 */
                                            "creneau.jour,".          /* 3 */
                                            "creneau.age,".           /* 4 */
                                            "creneau.pour_fratrie,".  /* 5 */
                                            "creneau.capacite,".      /* 6 */
                                            "creneau.naissance_min,". /* 7 */
                                            "creneau.naissance_max,". /* 8 */
                                            "creneau.nb_mois_mini,".  /* 9 */
                                            "creneau.saison ".        /* 10*/
                                    "FROM creneau ".
                                    "WHERE creneau.id=".$creneauid);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
        }
        $creneau=new Creneau();
        foreach($liste as $r)
        {
            $creneau->setId($r[0]);
            $creneau->setLieu(html_entity_decode($r[1]));
            $creneau->setHeure(html_entity_decode($r[2]));
            $creneau->setJour($r[3]);
            $creneau->setAge($r[4]);
            $creneau->setPourFratrie($r[5]);
            $creneau->setCapacite($r[6]);
            $creneau->setNaissanceMin($r[7]);
            $creneau->setNaissanceMax($r[8]);
            $creneau->setNbMoisMini($r[9]);
            $creneau->setSaison($r[10]);
        }
        return $creneau;
    }

    /**
     * Retourne la liste des creneaux
     */
    function getList($saison) {
        if (($saison=="")||($saison=="current")) { $saison=CURRENT_SAISON;}
        
        //TODO check saison
        $saison=htmlentities($saison);

        try {
            $query="SELECT id,lieu,heure,jour ".
            "FROM creneau ".
            "WHERE saison='".$saison."' ".
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


    
    /**
     * 
     */
    function insert($creneau) {
        
        $ret=$this->doSelect("creneau",array("max(id)+1"),"");
        if (count($ret)!=1) {
            return;
        }
        $id=$ret[0][0];

        $values=array( 
            "id"            => $id,           
            "saison"        => $this->pdo->quote($creneau->getSaison()),
            "lieu"          => $this->pdo->quote($creneau->getLieu()),
            "jour"          => $this->pdo->quote($creneau->getJour()),
            "heure"         => $this->pdo->quote($creneau->getHeure()),
            "age"           => $this->pdo->quote($creneau->getAge()),
            "pour_fratrie"  => intval($creneau->getPourFratrie()),
            "naissance_min" => 'str_to_date('.$this->pdo->quote($creneau->getNaissanceMin()).",'%d/%m/%Y')",
            "naissance_max" => 'str_to_date('.$this->pdo->quote($creneau->getNaissanceMax()).",'%d/%m/%Y')",
            "nb_mois_mini"  => intval($creneau->getNbMoisMini()),
            "capacite"      => intval($creneau->getCapacite())
        );

        $identifiant=$this->doInsert("creneau",$values);
        $creneau->setId($identifiant);
    }

    /**
     * Modifie le creneau 
     */
    public function update($oldcreneau,$newcreneau) {
        
        $values=array();
        if ($oldcreneau->getSaison()!=$newcreneau->getSaison()) {
            array_push($values,"saison=".$this->pdo->quote($newcreneau->getSaison()));
        }
        if ($oldcreneau->getLieu()!=$newcreneau->getLieu()) {
            array_push($values,"lieu=".$this->pdo->quote($newcreneau->getLieu()));
        }
        if ($oldcreneau->getJour()!=$newcreneau->getJour()) {
            array_push($values,"jour=".$this->pdo->quote($newcreneau->getJour()));
        }
        if ($oldcreneau->getHeure()!=$newcreneau->getHeure()) {
            array_push($values,"heure=".$this->pdo->quote($newcreneau->getHeure()));
        }
        if ($oldcreneau->getAge()!=$newcreneau->getAge()) {
            array_push($values,"age=".$this->pdo->quote($newcreneau->getAge()));
        }
        if ($oldcreneau->getPourFratrie()!=$newcreneau->getPourFratrie()) {
            array_push($values,"pour_fratrie=".strval(intval($newcreneau->getPourFratrie())));
        }
        if ($oldcreneau->getNaissanceMin()!=$newcreneau->getNaissanceMin()) {
            array_push($values,"naissance_min=".$this->pdo->quote($newcreneau->getNaissanceMin()));
        }
        if ($oldcreneau->getNaissanceMax()!=$newcreneau->getNaissanceMax()) {
            array_push($values,"naissance_max=".$this->pdo->quote($newcreneau->getNaissanceMax()));
        }
        if ($oldcreneau->getNbMoisMini()!=$newcreneau->getNbMoisMini()) {
            array_push($values,"nb_mois_mini=".strval(intval($newcreneau->getNbMoisMini())));
        }
        if ($oldcreneau->getCapacite()!=$newcreneau->getCapacite()) {
            array_push($values,"capacite=".strval(intval($newcreneau->getCapacite())));
        }

        $this->doUpdate("creneau",$oldcreneau->getId(),$values);


    }


}
?>