<?php

require 'slim/vendor/autoload.php';
require 'api/auth.php';
require 'api/restAdherents.php';
require 'api/restCreneaux.php';
require 'api/restEnfant.php';
require 'api/restInscription.php';

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

// Run app
$app->run();

?>
