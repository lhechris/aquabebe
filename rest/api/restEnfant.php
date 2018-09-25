<?php
include_once("log.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoEnfant.php");
include_once("dao/daoPaiement.php");
include_once("dao/daoInscription.php");
include_once("dao/daoEnfant.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestEnfant {

    public function __construct($app)
    {
        /**
         * METHOD GET enfant
         */
        $app->get('/enfant/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {           
            $daoenfant=new daoEnfant();
            $enfant=$daoenfant->get($args["id"]);
            $data=$enfant->toArray();
            $newResponse = $response->withJson($data);
            return $newResponse;
            
        });


        /**
         * METHOD POST enfant
         */
        $app->post('/enfant', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            $json = $request->getParsedBody();
            trace_info("POST enfant");
            trace_info(print_r($json,true));
            $paiement=new Paiement();
            $enfant=new Personne();
            $creneauselected=-1;

            foreach($json as $key => $value) {
                //$valuesck=htmlentities($value);
                $valuesck=$value;
                if ($key=="id") { $enfant->setId($valuesck);}
                if ($key=="prenom") { $enfant->setPrenom($valuesck);}
                if ($key=="nom") { $enfant->setNom($valuesck);}
                if ($key=="naissance") { $enfant->setNaissance($valuesck);}
                if ($key=="adresse") { $enfant->setAdresse($valuesck);}
                if ($key=="commune") { $enfant->setCommune($valuesck);}
                if ($key=="cp") { $enfant->setCp($valuesck);}

                if ($key=="paiementid") { $paiement->setId($valuesck);}
                if ($key=="payeur") { $paiement->setPayeur($valuesck);}
                if ($key=="montant") { $paiement->setMontant($valuesck);}
                if ($key=="moyen") { $paiement->setMoyen($valuesck);}
                if ($key=="mois") { $paiement->setMois($valuesck);}
                if ($key=="remarques") { $paiement->setRemarques($valuesck);}

                if ($key=="creneauselected") { $creneauselected=$valuesck;}

            }
            $daopers=new daoPersonne();
            $oldenfant = $daopers->getById($enfant->getId());
            $daopers->update($oldenfant["enfant"],$enfant);

            $daopaiement=new daoPaiement();
            $oldpaiement=$daopaiement->get($paiement->getId());
            if ($oldpaiement==null) {
                $daopaiement->insert($paiement);
                //Ajoute ce paiement a l'inscription
                $preinscs=$oldenfant["preinscriptions"];
                //recherche l'inscription qui va bien
                foreach($preinscs as $preinsc) {
                    trace_debug("reservation=".$preinsc->getReservation()." id=".$preinsc->getInscription()->getId()." ");
                    if (($preinsc->getReservation()==1) || ($preinsc->getCreneau()->getId()==$creneauselected)) {

                        $inscr=$preinsc->getInscription();
                        $inscr->setPaiement($paiement->getId());
                        $daoinscription=new daoInscription();
                        //Ajoute le paiement
                        $daoinscription->addPaiement($inscr);

                        //Cree la reservation
                        $inscr->setCreneauid($creneauselected);
                        $daoinscription->updateCreneau($inscr);
                        
                    }
                }
            } else {
                $daopaiement->update($oldpaiement,$paiement);                
            }

            $newResponse = $response->write("Paiement modifié");
            return $newResponse;            
        });



    }

}
?>