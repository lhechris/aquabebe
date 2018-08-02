<?php
include_once("log.php");
include_once("dao/daoPersonne.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestEnfant {

    public function __construct($app)
    {

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
            

            $data=array("id"=>$enfant->getId(),
                    "prenom"=>$enfant->getPrenom(),
                    "nom"=>$enfant->getNom(),
                    "naissance"=>$enfant->getNaissance(),
                    "telephone"=>$enfant->getTel(),
                    "telephone2"=>$enfant->getTel2(),
                    "adresse" =>$enfant->getAdresse(),
                    "cp" =>$enfant->getCp(),
                    "commune" =>$enfant->getCommune(),
                    "paiement" => $inscription->getPaiement(),
                    "paiementdate" => $inscription->getPaiementDate(),
                    "datemax" => $inscription->getDateMax(),
                    "vaccins" => $inscription->getVaccins(),                    
                    "preinscriptions"=>$preinscriptions,
                    "parents" => $parents
                    );

            $newResponse = $response->withJson($data);
            return $newResponse;
            
        });



    }

}
?>