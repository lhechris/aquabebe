<?php
include_once("log.php");
include_once("config.php");
include_once("utils.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestRegister {

    public function __construct($app)
    {

        $app->get('/register/is', function(ServerRequestInterface $request, ResponseInterface $response) {

            trace_info("isregister ".strval(isregister()));
            if (isregister()) {
                $newResponse = $response->write("oui");
            } else {
                $newResponse = $response->write("non");
            }
            return $newResponse;
        });

        $app->post('/register', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            $json = $request->getParsedBody();
            trace_params("register ",$json,array_keys($json));
            
            if (($json["login"]=="admin") && ($json["pass"]=="admin")) {
                trace_info("registration ok");
                $_SESSION["register"]="oui";
                $newResponse = $response->write("oui");
                return $newResponse;

            } else {
                trace_info("registration nok");
                $newResponse = $response->write("non");
                $_SESSION["register"]="non";
                return $newResponse;
            }
        });

        $app->post("/unregister",function(ServerRequestInterface $request, ResponseInterface $response) {

            trace_info("unregister session is ".print_r($_SESSION,true));

            $_SESSION["register"]="non";
            session_destroy();
            $newResponse = $response->write("success");
            trace_info("session after unreg ".print_r($_SESSION,true));
            return $newResponse;
        });

    }
}

?>