<?php
include_once("log.php");
include_once("dao/daoCreneau.php");
include_once("mailcreneau.php");
include_once("api/dto/dtoAddcreneau.php");
include_once("api/dto/dtoCreneau.php");
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
                             "enfants"=>array(),
                             "remain" => intval($creneau->getCapacite())-count($creneau->getEnfants())
                            );

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

        $app->get('/creneaux/listwithpreinscrit/{saison}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            $daocreneaux=new daoCreneau();
            $creneaux=$daocreneaux->listWithPreInscrits($args["saison"]);
            //trie par lieu et jour
            $data=array();
            $lieux=array();
            foreach($creneaux as $creneau)
            {
                if ($creneau->getCapacite()>0) {
                    $dtocreneau=new dtoCreneau();
                    $dtocreneau->setId($creneau->getId());
                    $dtocreneau->setJour($creneau->getJour());
                    $dtocreneau->setHeure($creneau->getHeure());
                    $dtocreneau->setAge($creneau->getAge());
                    $dtocreneau->setLieu($creneau->getLieu());
                    $dtocreneau->setPourFratrie($creneau->getPourFratrie());
                    $dtocreneau->setCapacite($creneau->getCapacite());

                    foreach($creneau->getPreinscriptions() as $preinscriptions)
                    {
                        $dtocreneaup=new dtoCreneauPreinscrit();
                        $dtocreneaup->setNom($preinscriptions->getInscription()->getEnfant()->getNom());
                        $dtocreneaup->setPrenom($preinscriptions->getInscription()->getEnfant()->getPrenom());
                        $dtocreneaup->setNaissance($preinscriptions->getInscription()->getEnfant()->getNaissance());
                        $naissance=$preinscriptions->getInscription()->getEnfant()->getNaissance();
                        $dt=DateTime::createFromFormat("Y-m-d",$naissance);
                        if ($dt!==FALSE) {
                            $now=new DateTime();
                            $interv=$now->diff($dt);
                            $dtocreneaup->setAge($interv->m+$interv->y*12);
                        }
                        $dtocreneaup->setId($preinscriptions->getInscription()->getEnfant()->getId());
                        $dtocreneaup->setChoix($preinscriptions->getChoix());
                        $dtocreneaup->setValidation($preinscriptions->getReservation());
                        $dtocreneau->addPreinscrit($dtocreneaup);
                    }
                    $restant=intval($creneau->getCapacite())-count($creneau->getPreinscriptions());
                    $dtocreneau->setRemain($restant);
                    $dtocreneau->setIsComplet($restant<=0);
                    if (!array_key_exists($dtocreneau->getLieu(),$lieux)) {
                        $lieux[$dtocreneau->getLieu()]=array();
                    }
                    if (!array_key_exists($dtocreneau->getJour(),$lieux[$dtocreneau->getLieu()])) {
                        $lieux[$dtocreneau->getLieu()][$dtocreneau->getJour()]=array();
                    }
                    array_push($lieux[$dtocreneau->getLieu()][$dtocreneau->getJour()],$dtocreneau->toArray());
                }
        }

            //result must be a list
            foreach ($lieux as $keyl=>$valuel) {
                $datal=array();
                foreach($valuel as $keyj=>$valuej) {
                    array_push($datal,array("name"=>$keyj,"creneaux"=>$valuej));
                }
                array_push($data,array("name" => $keyl,"jours" => $datal));
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
            $saison=$args["saison"];
            
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
                trace_params("POST creneaux email ",$json,array_keys($json));                

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
                $json = $request->getParsedBody();
                trace_params("add creneaux",$json,array_keys($json));            
                
                $addcreneau = new dtoAddCreneau();
                $addcreneau->fromArray($json);

                $daocreneau = new daoCreneau();

                $newcreneau=convertDtoAddCreneau($addcreneau);
                
                $oldcreneau=$daocreneau->getById($addcreneau->getId());

                if ($oldcreneau->getId()>0) {
                    //Le creneau existe on le modifie
                } else {
                    //le creneau n'existe pas, on verifie par rapport au jour et l'heure
                    $creneaux = $daocreneau->getList($addcreneau->getSaison());
                    $oldcreneau=null;
                    foreach($creneaux as $creneau) {
                        if ($creneau->getLieu()==$addcreneau->getLieu() && 
                            $creneau->getJour()==$addcreneau->getJour() &&
                            $creneau->getHeure()==$addcreneau->getHeure()
                        ) {
                            //Le creneau existe dejà on le modifie
                            $oldcreneau=$creneau;
                            $newcreneau->setId($creneau->getId());
                        }
                    }
                }
                if ($oldcreneau!=null) {
                    $daocreneau->update($oldcreneau,$newcreneau);
                } else {
                    $daocreneau->insert($newcreneau);
                }
            }
        });
    }
}
?>