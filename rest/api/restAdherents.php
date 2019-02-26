<?php
include_once("log.php");
include_once("dao/daoAdherents.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestAdherents {

    public function __construct($app)
    {

        $app->get('/adherents/{saison}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daoadherents=new daoAdherents();
            $saison=$args["saison"];
            //TODO test saison
            $adherents=$daoadherents->get($saison);
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