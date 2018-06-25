<?php
include_once("log.php");
include_once("dao/daoInscription.php");
include_once("dao/inscription.php");
include_once("dao/personne.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestInscription {

    public function __construct($app)
    {

        $app->post('/inscription', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daoinscription=new daoInscription();
                   
            $json = $request->getParsedBody();
            trace_info(print_r($json,true));
            $obj=new Inscription();
            $enfant=new Personne();
            foreach($json as $key => $value) {
                $valuesck=htmlentities($value);
                if ($key=="nomenfant") { $enfant->setNom($valuesck);}
                if ($key=="prenomenfant") { $enfant->setPrenom($valuesck);}
                if ($key=="adresse") { $enfant->setAdresse($valuesck);}
                if ($key=="naissance") { $enfant->setNaissance($valuesck);}
            }
            $obj->setEnfant($enfant);
            $daoinscription->insert($obj);

            $newResponse = $response->withJson($json);
            return $newResponse;
        });


    }

}
?>