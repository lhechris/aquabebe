<?php
include_once("log.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoPaiement.php");
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
           
            $daopersonne=new daoPersonne();
            $resp=$daopersonne->getById($args["id"]);
            
            $enfant=$resp["enfant"];

            $preinscriptions=array();
            $inscription=new Inscription();            
            foreach($resp["preinscriptions"] as $preinsc)
            {
                array_push($preinscriptions, array(
                    "creneau" =>$preinsc->getCreneau()->getLieu()." ".$preinsc->getCreneau()->getJour()." ".$preinsc->getCreneau()->getHeure(),
                    "inscriptionid" => $preinsc->getInscription()->getId(),
                    "choix" => $preinsc->getChoix(),
                    "reservation" => $preinsc->getReservation())
                );
                $inscription=$preinsc->getInscription();
            }

            $parents=array();
            foreach($resp["parents"] as $parent)
            {
                array_push($parents, array(
                    "id" => $parent->getId(),
                    "nom" =>$parent->getNom(),
                    "prenom" => $parent->getPrenom(),
                    "telephone" => $parent->getTel())
                );
            }
            
            //Paiement
            $daopaiement=new daoPaiement();
            $paiement=$daopaiement->get($inscription->getPaiement());
            $jpaiement=array();
            if ($paiement!=NULL) {
                $jpaiement=array("payeur"=>$paiement->getPayeur(),
                                 "montant"=>$paiement->getMontant(),
                                 "moyen"=>$paiement->getMoyen(),
                                 "mois"=>$paiement->getMois(),
                                 "remarques"=>$paiement->getRemarques(),
                                 "id" =>$paiement->getId()
                                );
            }



            $data=array("id"=>$enfant->getId(),
                    "prenom"=>$enfant->getPrenom(),
                    "nom"=>$enfant->getNom(),
                    "naissance"=>$enfant->getNaissance(),
                    "telephone"=>$enfant->getTel(),
                    "telephone2"=>$enfant->getTel2(),
                    "adresse" =>$enfant->getAdresse(),
                    "cp" =>$enfant->getCp(),
                    "commune" =>$enfant->getCommune(),
                    "paiement" => $jpaiement,
                    "paiementdate" => $inscription->getPaiementDate(),
                    "datemax" => $inscription->getDateMax(),
                    "vaccins" => $inscription->getVaccins(),                    
                    "preinscriptions"=>$preinscriptions,
                    "parents" => $parents
                    );

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
            }
            $daopers=new daoPersonne();
            $oldenfant = $daopers->getById($enfant->getId());
            $daopers->update($oldenfant["enfant"],$enfant);

            $daopaiement=new daoPaiement();
            $oldpaiement=$daopaiement->get($paiement->getId());
            $daopaiement->update($oldpaiement,$paiement);

            $newResponse = $response->write("Paiement modifié");
            return $newResponse;            
        });



    }

}
?>