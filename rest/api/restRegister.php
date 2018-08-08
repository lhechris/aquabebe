<?php
include_once("log.php");
include_once("config.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestRegister {

    public function __construct($app)
    {

        $app->get('/register/is', function(ServerRequestInterface $request, ResponseInterface $response) {

            $newResponse = $response->write($_SESSION["register"]);
            return $newResponse;
        });

        $app->post('/register', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            $json = $request->getParsedBody();
            if (($json["login"]=="admin") && ($json["pass"]=="admin")) {
                $_SESSION["register"]="oui";
                $newResponse = $response->write("oui");
                return $newResponse;

            } else {
                $newResponse = $response->write("non");
                $_SESSION["register"]="non";
                return $newResponse;
            }
        });
    }
}

function isregister() {
    if ((key_exists("register",$_SESSION)) && ($_SESSION["register"]=="oui")) {
        echo "oui";
    } else {
        echo "non";
        $_SESSION["register"]="oui";
    }
}

function login($data) {
    $json=$data;
    if ((key_exists("login",$json)) && (key_exists("pass",$json)) && ($json["login"]=="admin") && ($json["pass"]=="admin")) {
        $_SESSION["register"]="oui";
        echo "oui";
    }
    else
    {
        $_SESSION["register"]="non";
        echo "non";
    }

}


?>