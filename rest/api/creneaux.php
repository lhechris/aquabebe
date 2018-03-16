<?php
include_once("log.php");
include_once("dao/daoCreneau.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestCreneaux {

    public function __construct($app)
    {

        $app->get('/creneaux/all', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daocreneaux=new daoCreneau();
            $creneaux=$daocreneaux->getAll();
            $data=array();        
            foreach($creneaux as $creneau)
            {
                if ($creneau->getCapacite()>0) {
                    $t=array("id"=>$creneau->getId(),
                             "name"=>$creneau->getJour()." ".$creneau->getHeure(),
                             "lieu"=>$creneau->getLieu(),
                             "description"=>$creneau->getAge(),
                             "enfants"=>array());                               
                    foreach($creneau->getEnfants() as $enfant)
                    {
                        $e=array("name"=>$enfant->getPrenom(),"age"=>$enfant->getNaissance());
                        array_push($t["enfants"],$e);
                    }
                    array_push($data,$t);
                }

            }
            //$data = file_get_contents("api/creneauxall.json");   
            $newResponse = $response->withJson($data);
            //$newResponse = $response->write($data);
            return $newResponse;
        });

        $app->get('/creneaux/naissance={naissance}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            $creneaux=$daocreneaux->getForNaissance($args['naissance']);
            $data=array();        
            foreach($creneaux as $creneau)
            {
                if ($creneau->getNbInscrit()<$creneau->getCapacite())
                {
                    $t=array("id"=>$creneau->getId(),
                            "name"=>$creneau->getJour()." ".$creneau->getHeure(),
                            "lieu"=>$creneau->getLieu(),
                            "description"=>$creneau->getAge(),
                            "inscrits"=>$creneau->getNbInscrit(),
                            "capacite"=>$creneau->getCapacite()
                        );
                    array_push($data,$t);
                }
            }
            //$data = file_get_contents("api/creneauxall.json");   
            $newResponse = $response->withJson($data);
            return $newResponse;
        });

    }

}
?>