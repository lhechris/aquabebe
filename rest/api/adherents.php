<?php
include_once("log.php");
include_once("dao/daoPersonne.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestAdherents {

    public function __construct($app)
    {

        $app->get('/adherents/current', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daopersonne=new daoPersonne();
            $personnes=$daopersonne->get(CURRENT_SAISON);
            $data=array();
            foreach($personnes as $t)
            {
                $personne=$t["enfant"];
                $preinscription=$t["preinscription"];
                
                $t=array("id"=>$personne->getId(),
                        "prenom"=>$personne->getPrenom(),
                        "nom"=>$personne->getNom(),
                        "naissance"=>$personne->getNaissance(),
                        "creneau" =>$preinscription->getCreneau()->getLieu()." ".$preinscription->getCreneau()->getJour()." ".$preinscription->getCreneau()->getHeure(),
                        "inscriptionid" => $preinscription->getInscription()->getId(),
                        "choix" => $preinscription->getChoix(),
                        "reservation" => $preinscription->getReservation()
                       );
                array_push($data,$t);
            }                        

            $newResponse = $response->withJson($data);
            return $newResponse;
        });



    }

}
?>