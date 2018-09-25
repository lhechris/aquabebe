<?php
include_once("log.php");
include_once("dao/daoDocuments.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Http\UploadedFile;

class RestDocumentation {

    public function __construct($app)
    {

        $app->get('/doc/get', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daodocuments=new daoDocuments();
            $documents=$daodocuments->get();
            $data=array();

            foreach($documents as $doc) {
                array_push($data,$doc->toArray());
            }
            $newResponse = $response->withJson($data);
            return $newResponse;

        });

        $app->post('/doc/upload', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            $json = $request->getParsedBody();
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
            }
        });

        $app->post('/doc/update', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $data = $request->getParsedBody();
            trace_info("POST doc update");
            trace_info(print_r($data,true));
            if (array_key_exists("docs",$data)) {
                $dao=new daoDocuments();
                $dao->update(json_decode($data["docs"],true));
            }
        });


    }
}

function getfichier($args) {
    $daodocuments=new daoDocuments();
    $ret=$daodocuments->getfichier($args[0]);
    if ($ret!=null) {
        $doc=$ret[0];
        $data=$ret[1];

        //header('Content-Disposition: attachment; filename="'.$doc->getNom().'"');
        header("Content-Type:".$doc->getType());
        header("Content-Length:".strlen($data));
        echo($data);
    }
}



?>