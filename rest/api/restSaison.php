<?php
include_once("log.php");
include_once("dao/daoSaison.php");
include_once("config.php");
include_once("utils.php");

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
            if (!isregister()){return;};

            $daosaison=new daoSaison();
            $ret=$daosaison->getAll();
            $newResponse = $response->withJson($ret);
            return $newResponse;            
        });

        /**
         * METHOD POST 
         */
        $app->post('/saison/{saison}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("post saison ".$args["saison"]);
            $saison=$args["saison"];
            list($y1,$y2)=sscanf($saison,"%d-%d");
            if (($y1>2000) && ($y1<2100) && ($y2==($y1+1))){
                $hdl=fopen("config.php","w");
                fwrite($hdl,"<?php\ndefine('CURRENT_SAISON','$y1-$y2');\n?>\n");
                fclose($hdl);
                $newResponse =  $response->write("Successfull");
            } else {
                $newResponse =  $response->write("bad saison $saison ($y1) ($y2)");
            }

            return $newResponse;
            

        });


    }

}
?>