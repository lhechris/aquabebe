<?php
include_once("log.php");
include_once("dao/daoAdherents.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestAdherents {

    public function __construct($app)
    {

        $app->get('/adherents/current', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daoadherents=new daoAdherents();
            $adherents=$daoadherents->get(CURRENT_SAISON);
            $data=array();
            foreach($adherents as $adherent)
            {
                array_push($data,$adherent->toArray());
            }                        

            $newResponse = $response->withJson($data);
            return $newResponse;
        });



    }

}
?>