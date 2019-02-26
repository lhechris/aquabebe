<?php
include_once("log.php");
include_once("dao/daoSaison.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestSaison {

    public function __construct($app)
    {
        /**
         * METHOD GET 
         */
        $app->get('/saison/current', function(ServerRequestInterface $request, ResponseInterface $response) {           
            $newResponse = $response->write(CURRENT_SAISON);
            return $newResponse;                    
        });


        /**
         * METHOD GET all saison
         */
        $app->get('/saison/all', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daosaison=new daoSaison();
            $ret=$daosaison->getAll();
            $newResponse = $response->withJson($ret);
            return $newResponse;            
        });
    }

}
?>