<?php

require 'slim/vendor/autoload.php';
require 'api/auth.php';
require 'api/restAdherents.php';
require 'api/restCreneaux.php';
require 'api/restEnfant.php';
require 'api/restInscription.php';
require 'api/restRegister.php';
require 'api/restDocumentation.php';

include_once('config.php');

session_start();

// Instantiate the app
//$settings = require 'slim/src/settings.php';
$settings= [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => 'slim/templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => 'slim/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];


$app = new \Slim\App($settings);

$creneaux = new RestCreneaux($app);


// Define app routes
$app->get('/hello', function () {
    echo "Hello, I'm Slim";
});

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello " . $args['name']);
});

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/saison', function(ServerRequestInterface $request, ResponseInterface $response) {
    $newResponse = $response->write(CURRENT_SAISON);
    return $newResponse;
});


// Set up dependencies
require 'slim/src/dependencies.php';

// Register middleware
require 'slim/src/middleware.php';

// Register routes
require 'slim/src/routes.php';


new RestAuth($app);
new RestInscription($app);
new RestAdherents($app);
new RestEnfant($app);
new RestRegister($app);
new RestDocumentation($app);


function exception_error_handler($severity, $message, $file, $line) {
    
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    trace_error($file."[".$line."]" );
    trace_error($message);
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");




trace_info("SERVER ".print_r($_SERVER,true));
trace_info("GET  ".print_r($_GET,true));
trace_info("POST ".print_r($_POST,true));
try {
    if ($_SERVER["REQUEST_METHOD"]=="GET") {
        $uri=$_SERVER["REQUEST_URI"];
        $turi=explode("/",$uri);
        trace_info("uri ".print_r($turi,true));
        if ((count($turi)>=2) && ($turi[1]=="rest")) {
            
            if ((count($turi)>=3) && ($turi[2]=="doc")) {
            
                if ((count($turi)>=4) && ($turi[3]=="getfichier")) {
                    
                    if (count($turi)>=5) {
                        getfichier(array_slice($turi,4));
                        exit(0);

                    }
                }
            
            }
        }
    /*} else if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $uri=$_SERVER["REQUEST_URI"];
        $turi=explode("/",$uri);
        trace_info("uri ".print_r($turi,true));
        if ((count($turi)>=2) && ($turi[1]=="rest")) {
            
            if ((count($turi)>=3) && ($turi[2]=="doc")) {
            
                if ((count($turi)>=4) && ($turi[3]=="upload")) {
                    
                    if (count($turi)>=5) {
                        uploadDoc(array_slice($turi,4));
                        exit(0);

                    }
                }
            
            }
        }*/

    }
} catch (Exception $e) {
    trace_info($e->getMessage());
    trace_error($e->getMessage());
}

// Run app
$app->run();


?>
