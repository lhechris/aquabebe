<?php
include_once('daoClass.php');
include_once('api/dto/dtoAdherent.php');
include_once("config.php");

class daoAdherents extends daoClass {

    /**
     * Retourne la liste des adherents d'une saison
     */
    public function get($saison) {

        if ((strlen($saison)!=9) && (strlen($saison)!=4)){
            trace_error("daoAdherents::get bad saison length expected 9");
            return false;
        }

        $query="select personne.id, ".                      /* 0 */
                       "personne.prenom, ".                 /* 1 */
                       "personne.nom, ".                    /* 2 */
                       "personne.naissance, ".              /* 3 */
                       "creneau.lieu, ".                    /* 4 */
                       "creneau.jour, ".                    /* 5 */
                       "creneau.heure, ".                   /* 6 */
                       "inscription.vaccins, ".             /* 7 */
                       "inscription.certificat_medical, ".  /* 8 */
                       "inscription.facture_remise,".       /* 9 */
                       "inscription.id ".                   /* 10*/
        "from creneau,inscription,personne,preinscription,paiement ".
        "where creneau.id=preinscription.id_creneau ".
          "and inscription.ID_enfant=personne.id ".
          "and creneau.saison='$saison' ".
          "and personne.type='enfant' ".
          "and preinscription.id_inscription=inscription.id ".
          "and preinscription.reservation=1 ".
          "and paiement.id=inscription.paiement ".
        "order by personne.nom,personne.prenom,preinscription.choix";
        trace_debug($query);

        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return array();
        }
        $adherents=array();        
        foreach($liste as $r)
        {
            $adherent=new dtoAdherent();
            $adherent->setId($r[0]);
            $adherent->setPrenom($r[1]);
            $adherent->setNom($r[2]);
            $adherent->setNaissance($r[3]);
            $adherent->setCreneau($r[4]." ".$r[5]." ".$r[6]); 
            $adherent->setVaccins($r[7]);
            $adherent->setCertificat($r[8]);
            $adherent->setFacture($r[9]);
            $adherent->setInscriptionid($r[10]);

            array_push($adherents,$adherent);
        }
        return $adherents;

    }




}


?>