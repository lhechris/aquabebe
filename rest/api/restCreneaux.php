<?php
include_once("log.php");
include_once("dao/daoCreneau.php");
include_once("mailcreneau.php");
include_once("api/dto/dtoAddcreneau.php");
include_once("config.php");
include_once("utils.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Http\UploadedFile;

class foo {
    private $a;
    public $b = 1;
    public $c;
    private $d;
    static $e;
    function __construct() {
        $this->a="blabla";
    }
}

class RestCreneaux {

    public function __construct($app)
    {

        $app->get('/creneaux/all/{saison}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            $creneaux=$daocreneaux->getAll($args["saison"]);
            $data=array();
            $lieu=array(); 
            $jour=array();
            foreach($creneaux as $creneau)
            {
                if ($creneau->getCapacite()>0) {
                    $t=array("id"=>$creneau->getId(),
                             "jour"=>$creneau->getJour(),
                             "heure"=>$creneau->getHeure(),
                             "description"=>$creneau->getAge(),
                             "enfants"=>array());                               
                    foreach($creneau->getEnfants() as $enfant)
                    {
                        $e=array("name"=>$enfant->getPrenom(),"age"=>$enfant->getNaissance(),"id"=>$enfant->getId());
                        array_push($t["enfants"],$e);
                    }

                    if (!((array_key_exists("name",$lieu))&&($lieu["name"]==$creneau->getLieu())))
                    {
                        if (sizeof($lieu)!=0) {
                            if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour);}
                            array_push($data,$lieu);
                        }                        
                        $lieu=array("name"=>$creneau->getLieu(),"jours"=>array());
                        $jour=array();
                    }
                    if (!((array_key_exists("name",$jour))&&($jour["name"]==$creneau->getJour())))
                    {
                        if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour); }
                        $jour=array("name"=>$creneau->getJour(),"creneaux"=>array());
                    }
                    array_push($jour["creneaux"],$t);
                }
            }
            if (sizeof($lieu)!=0) {
                if (sizeof($jour)!=0) {array_push($lieu["jours"],$jour);}
                array_push($data,$lieu);
            }                        

            //$data = file_get_contents("api/creneauxall.json");   
            $newResponse = $response->withJson($data);
            //$newResponse = $response->write($data);
            return $newResponse;
        });

        $app->get('/creneaux/naissance={naissance}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            $creneaux=$daocreneaux->getByNaissance($args['naissance']);
            $data=array();        
            foreach($creneaux as $creneau)
            {
                if ($creneau->getNbInscrit()<$creneau->getCapacite())
                {
                    $t=array("id"=>$creneau->getId(),
                            "name"=>$creneau->getJour()." ".$creneau->getHeure(),
                            "lieu"=>$creneau->getLieu(),
                            "description"=>$creneau->getAge(),
                            "inscrits"=>$creneau->getNbInscrit(),
                            "capacite"=>$creneau->getCapacite(),
                            "min" =>$creneau->getNaissanceMin(),
                            "max" =>$creneau->getNaissanceMax(),
                        );
                    array_push($data,$t);
                }
            }
            //$data = file_get_contents("api/creneauxall.json");   
            $newResponse = $response->withJson($data);
            return $newResponse;
        });

        $app->get('/creneaux/id={id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            $creneau=$daocreneaux->getById($args['id']);
            $data=array("id"=>$creneau->getId(),
                    "jour"=>$creneau->getJour(),
                    "heure"=>$creneau->getHeure(),
                    "lieu"=>$creneau->getLieu(),
                    "age"=>$creneau->getAge(),
                    "capacite"=>$creneau->getCapacite(),
                    "min" =>$creneau->getNaissanceMin(),
                    "max" =>$creneau->getNaissanceMax(),
                    "saison" =>$creneau->getSaison(),
                    "pour_fratrie" =>$creneau->getPourFratrie(),
                    "nbmoismini" =>$creneau->getNbMoisMini()
                );
            //$data = file_get_contents("api/creneauxall.json");   
            $newResponse = $response->withJson($data);
            return $newResponse;
        });

        $app->get("/creneaux/list/{saison}",function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            //TODO check saison
            $saison=htmlentities($args["saison"]);
            
            $creneaux=$daocreneaux->getList($saison);
            $data=array();

            foreach($creneaux as $creneau) {
                array_push($data,$creneau->toArray());
            }
            $newResponse = $response->withJson($data);
            return $newResponse;
        });

        /**
         * METHOD POST enfant
         */        
        $app->post('/creneaux/mail', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (isregister()) {
                $json = $request->getParsedBody();
                trace_info("POST creneaux email");
                trace_info(print_r($json,true));

                $uploadedFiles = $request->getUploadedFiles();
                $directory=__DIR__ . DIRECTORY_SEPARATOR . 'uploads';
                if (array_key_exists("files",$uploadedFiles)) {
                    foreach($uploadedFiles['files'] as $uploadedFile) {

                        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
                        $filename = sprintf('%s.%0.8s', $basename, $extension);
                        trace_info($directory . DIRECTORY_SEPARATOR . $filename);
                        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
                    }
                }

                //recherche tous les emails d'un creneau
                $daocreneaux=new daoCreneau();
                $emails=$creneaux=$daocreneaux->getEmails($json["creneau"]);

                mailcreneau($emails,$json['texte'],$json['sujet'],array());

                //$newResponse = $response->write("Pas encore implementé");
                $newResponse = $response->withJson($emails);


                return $newResponse; 
            } 
        });
        $app->post('/creneaux/add', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (isregister()) {
                trace_info("add crenaux");            
                $json = $request->getParsedBody();
                trace_info(print_r($json,true));
                $addcreneau = new addCreneau();
                $addcreneau->fromArray($json);

                $daocreneaux = new $daoCreneaux();

                $creneaux = $daocreneaux->getList(CURRENT_SAISON);
                $toupdate=False;
                foreach($creneaux as $creneau) {
                    if ($creneau->getLieu()==$addcreneau->getLieu() && 
                        $creneau->getJour()==$addcreneau->getJour() &&
                        $creneau->getHeure()==$addcreneau->getHeure()
                    ) {
                        //Le creneau existe dejà on le modifie
                        $toupdate=True;
                    }
                }
                if ($toupdate) {
                    $daocreneaux->update($addcreneau);
                } else {
                    $daocreneaux->add($addcreneau);
                }
            }
        });
    }
}
?>