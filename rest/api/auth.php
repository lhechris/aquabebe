<?php
// Requires: composer require firebase/php-jwt
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use \Tuupola\Middleware\HttpBasicAuthentication;
use Tuupola\Middleware\JwtAuthentication;
include_once("log.php");

// Get your service account's email address and private key from the JSON key file
$service_account_email = "abc-123@a-b-c-123.iam.gserviceaccount.com";
//$private_key = "-----BEGIN PRIVATE KEY-----...";
$key="supersecretkeyyoushouldnotcommittogithub";

function create_custom_token($uid) {
  global $service_account_email, $key;

  $now_seconds = time();
  $payload = array(
    "iss" => $service_account_email,
    "sub" => $service_account_email,
    "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
    "iat" => $now_seconds,
    "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
    "uid" => $uid
  );
  $jwt=JWT::encode( $payload, $key);
  //trace_info("token:".$jwt);
  return $jwt;
}


class RestAuth {
    public function __construct($app)
    {
        //HttpBasicAuthentication to get the token
       /* $app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
            "path" => "/token", 
            "realm" => "Protected",
            "users" => [
                "root" => "toor",
                "somebody" => "password"
            ]
        ]));*/
        
        $app->post("/token", function (ServerRequestInterface $request, ResponseInterface $response) { 
            $token=create_custom_token("10");
            $newResponse = $response->write($token);
            return $newResponse;
        });


        //declare authorized path 
        global $key;
        $app->add(new Tuupola\Middleware\JwtAuthentication([            
            "secret" => $key,
            "path" => "/hello"
        ]));
    }
}

?>