<?php
include_once('daoClass.php');
include_once('creneau.php');
include_once('personne.php');

class daoCreneau extends daoClass {

    public function getAll()
    {
        try {
            $stmt=$this->pdo->query("select creneau.id,creneau.lieu,creneau.heure,creneau.jour,creneau.age,creneau.capacite,personne.prenom,personne.naissance from creneau,inscription,enfant,personne where creneau.id=inscription.id_creneau and inscription.ID_enfant=enfant.ID_enfant and enfant.ID_personne=personne.id and creneau.saison='2017-2018' and personne.type='enfant' order by creneau.id");
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        $creneaux=array();        
        foreach($liste as $r)
        {
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
            $enfant->setPrenom($r[6]);
            $enfant->setNaissance($r[7]);
            $creneaux[sizeof($creneaux)-1]->addEnfant($enfant);
        }
        return $creneaux;
    }

    public function getForNaissance($naissance)
    {
        try {
            $stmt=$this->pdo->query("SELECT creneau.id,creneau.lieu,creneau.heure,creneau.jour,creneau.age,creneau.capacite,count(*) ".
                                    "FROM creneau,inscription ".
                                    "WHERE creneau.id=inscription.id_creneau ".
                                          "AND inscription.ID_enfant ".
                                          "AND creneau.saison='2017-2018' ".
                                    "GROUP BY (creneau.id) ORDER BY creneau.id");
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        $creneaux=array();        
        foreach($liste as $r)
        {
            $creneau=new Creneau();
            $creneau->setId($r[0]);
            $creneau->setHeure($r[2]);
            $creneau->setlieu($r[1]);
            $creneau->setJour($r[3]);
            $creneau->setAge($r[4]);
            $creneau->setCapacite($r[5]);
            $creneau->setNbInscrit($r[6]);
            array_push($creneaux,$creneau);
        }
        return $creneaux;
    }


}


?>