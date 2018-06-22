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
            $lieu=array(); 
            $jour=array();
            foreach($creneaux as $creneau)
            {
                if ($creneau->getCapacite()>0) {
                    $t=array("id"=>$creneau->getId(),
                             "jour"=>$creneau->getJour(),
                             "heure"=>$creneau->getHeure(),
                             "description"=>$creneau->getAge(),
                             "enfants"=>array());                               
                    foreach($creneau->getEnfants() as $enfant)
                    {
                        $e=array("name"=>$enfant->getPrenom(),"age"=>$enfant->getNaissance(),"id"=>$enfant->getId());
                        array_push($t["enfants"],$e);
                    }

                    if (!((array_key_exists("name",$lieu))&&($lieu["name"]==$creneau->getLieu())))
                    {
                        if (sizeof($lieu)!=0) {
                            if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour);}
                            array_push($data,$lieu);
                        }                        
                        $lieu=array("name"=>$creneau->getLieu(),"jours"=>array());
                        $jour=array();
                    }
                    if (!((array_key_exists("name",$jour))&&($jour["name"]==$creneau->getJour())))
                    {
                        if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour); }
                        $jour=array("name"=>$creneau->getJour(),"creneaux"=>array());
                    }
                    array_push($jour["creneaux"],$t);
                }
            }
            if (sizeof($lieu)!=0) {
                if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour);}
                array_push($data,$lieu);
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
                            "capacite"=>$creneau->getCapacite(),
                            "min" =>$creneau->getNaissanceMin(),
                            "max" =>$creneau->getNaissanceMax(),
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