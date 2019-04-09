<?php
include_once("log.php");
include_once("dao/daoPages.php");
include_once("utils.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Http\UploadedFile;

class RestPages {

    public function __construct($app)
    {

        $app->get('/pages/name={name}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daopages=new daoPages();
            $page=$daopages->get($args["name"]);

            $newResponse = $response->write($page);
            return $newResponse;

        });

        $app->get('/pages/list', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};
            
            $daopages=new daoPages();
            $pages=$daopages->list();

            $newResponse = $response->withJson($pages);
            return $newResponse;

        });

        $app->post('/pages/update', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("POST page update");
            $data = $request->getParsedBody();
            $daopages=new daoPages();
            if ($page=$daopages->update($data["name"],$data["texte"])==TRUE) {
                $newResponse = $response->write("page sauvee");
            } else {
                $newResponse = $response->write("page non sauvee");
            }
            return $newResponse;

            /*$json = $request->getParsedBody();
            trace_info("POST doc upload");
            trace_info(print_r($json,true));

            $daodocuments=new daoDocuments();
            $documents=$daodocuments->get();
    
            $uploadedFiles = $request->getUploadedFiles();
            $directory=__DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR.'doc';
            if (array_key_exists("files",$uploadedFiles)) {
                foreach($uploadedFiles['files'] as $uploadedFile) {
    
                    //$extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                    //$basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
                    //$filename = sprintf('%s.%0.8s', $basename, $extension);
                    $filename=$uploadedFile->getClientFilename();
                    trace_info($directory . DIRECTORY_SEPARATOR . $filename);
                    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
                    $doc=new Document();
                    $doc->setNom($filename);
                    $doc->setChemin("");
                    $doc->setDescription($json['description']);
                    $doc->updateType();
                    $daodocuments->add($doc);
                }
            }*/
        });
    }
}



?>