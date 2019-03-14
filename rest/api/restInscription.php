<?php
include_once("log.php");
include_once("dao/daoInscription.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoCreneau.php");
include_once("dao/daoConfig.php");
include_once("dto/dtoReservation.php");

include_once("mailInscription.php");
include_once("utils.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestInscription {

    public function __construct($app)
    {

        $app->post('/inscription', function(ServerRequestInterface $request, ResponseInterface $response) {
            $daoinscription=new daoInscription();
                   
            $json = $request->getParsedBody();
            trace_info("POST inscription");
            trace_info(print_r($json,true));
            $enfant=new Personne();
            $parent1=new Personne();
            $parent2=new Personne();
            $listcreneaux=array();
            foreach($json as $key => $value) {
                $valuesck=htmlentities($value);
                if ($key=="nomenfant") { $enfant->setNom($valuesck);}
                if ($key=="prenomenfant") { $enfant->setPrenom($valuesck);}
                if ($key=="adresse") { $enfant->setAdresse($valuesck);}
                if ($key=="ville") { $enfant->setCommune($valuesck);}
                if ($key=="codepostal") { $enfant->setCp($valuesck);}
                if ($key=="sexe") { $enfant->setSexe($valuesck);}
                if ($key=="handicap") { $enfant->setHandicap($valuesck);}
                if ($key=="email") { $enfant->setMel($valuesck);}
                if ($key=="naissance") { $enfant->setNaissance($valuesck);}
                if ($key=="nomparent1") { $parent1->setNom($valuesck);}
                if ($key=="prenomparent1") { $parent1->setPrenom($valuesck);}
                if ($key=="sexeparent1") { $parent1->setSexe($valuesck);}
                if ($key=="telparent1") { $parent1->setTel($valuesck);}
                if ($key=="nomparent2") { $parent2->setNom($valuesck);}
                if ($key=="prenomparent2") { $parent2->setPrenom($valuesck);}
                if ($key=="sexeparent2") { $parent2->setSexe($valuesck);}
                if ($key=="telparent2") { $parent2->setTel($valuesck);}
                if (substr($key,0,8)=="creneau_") {
                    $creneauid=substr($key,8);
                    if ($creneauid!==FALSE) {$listcreneaux[$creneauid]=$valuesck;}
                }
            }
            //Recupere les creneaux
            $daocreneau=new DaoCreneau();
            $creneaux=$daocreneau->getByNaissance($enfant->getNaissance());

            //Ajoute l'enfant et les parents en base de données
            $daoPersonne = new daoPersonne();
            $ret=$daoPersonne->insert($enfant,$parent1,$parent2);
            if ($ret==false) {
                trace_info("Can't add inscription, error while inserting personne");
                $newResponse = $response->write("Internal error: can't create inscription");
                return $newResponse;
            }


            //Ajoute l'inscriptions
            $inscr=new Inscription();
            $inscr->setEnfant($enfant);

            $inscr->setDateMax(date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+7, date("Y"))));

            if (array_key_exists("diffusionimage",$json)&&($json["diffusionimage"]=="1")) {
                $inscr->setDiffusionImage(1);
            } else {
                $inscr->setDiffusionImage(2);
            }
            $inscr->setDiffusionImageLieu("web");
            $inscr->setDiffusionImageDate(date("Y-m-d"));
            $inscr->setDiffusionImageSignature("oui");

            if (array_key_exists("reglement",$json)&&($json["reglement"]=="true")) {
                $inscr->setReglementInterieurSignature("accepté");
                $inscr->setReglementInterieurLieu("web");
                $inscr->setReglementInterieurDate(date("Y-m-d"));
            } else {
                $inscr->setReglementInterieurSignature("");
                $inscr->setReglementInterieurLieu("");
                $inscr->setReglementInterieurDate(date(""));
            }

            //recupere le creneau principal
            foreach($creneaux as $creneau) {
                if (array_key_exists((string)($creneau->getId()),$listcreneaux))
                {
                    if ($listcreneaux[$creneau->getId()] == "1") {
                        $inscr->setCreneau($creneau);
                    }
                }
            }

            if ($inscr->getCreneau()=="") {
                $newResponse = $response->write("Error: pas de creneau primaire");
                return $newResponse;
            }

            //ajoute l'inscription en base
            $ret=$daoinscription->insert($inscr);
            if ($ret==false) {
                trace_info("Can't add inscription, error while inserting inscription");
                $newResponse = $response->write("Internal error: can't create inscription");
                return $newResponse;
            }

            //Ajoute les preinscriptions
            foreach($creneaux as $creneau) {
                trace_info("creneau:".$creneau->getId()." nbinscrit=".$creneau->getNbInscrit()." capacite=".$creneau->getCapacite()." ".array_key_exists((string)($creneau->getId()),$listcreneaux));
                if (($creneau->getNbInscrit()<$creneau->getCapacite()) && 
                    (array_key_exists((string)($creneau->getId()),$listcreneaux))
                   ) 
                {                           
                    $preinscr=new Preinscription();
                    $preinscr->setCreneau($creneau);
                    $preinscr->setInscription($inscr);
                    $preinscr->setChoix($listcreneaux[$creneau->getId()]);
                    $preinscr->setReservation(0);
                    $daoinscription->insertPreinscription($preinscr);
                    if ($ret==false) {
                        trace_info("Can't add inscription, error while inserting preinscription");
                        $newResponse = $response->write("Internal error: can't create inscription");
                        return $newResponse;
                    }
                }
            }
            $newResponse = $response->write("Inscription ajoutée");
            //$newResponse = $response->withJson($json);

            //envoi le mail
            mailinscription($enfant->getMel());

            return $newResponse;

        });

        /**
         * Lock/Unlock Inscription
         */
        $app->post('/inscription/lock', function(ServerRequestInterface $request, ResponseInterface $response) {
            if (!isregister()){return;};

            $json = $request->getParsedBody();
            $islock=$json["islock"];

            trace_info("POST inscription Lock ".$islock);
            $dao = new daoConfig();
            $conf=$dao->get();
            $conf["blockinscription"]=$islock;
            $dao->save($conf);
            $newResponse = $response->write("Successfull");
            return $newResponse;
        });

        $app->get('/inscription/lock', function(ServerRequestInterface $request, ResponseInterface $response) {
            if (!isregister()){return;};

            $dao = new daoConfig();
            $conf=$dao->get();            
            $newResponse = $response->write($conf["blockinscription"]);
            return $newResponse;
        });

        $app->get('/inscription/reservations', function(ServerRequestInterface $request, ResponseInterface $response) {
            if (!isregister()){return;};

            $dao = new daoInscription();
            $preinscriptions=$dao->getReservations();
            $dtos=array();
            foreach($preinscriptions as $preinscription) {
                $dto=null;
                $insc=$preinscription->getInscription();
                $enf=$insc->getEnfant();
                $cren=$preinscription->getCreneau();
                
                if (array_key_exists($enf->getId(),$dtos)) {
                    $dto=$dtos[$enf->getId()];
                } else {
                    $dto = new dtoReservation();
                    $dto->setNom($enf->getNom());
                    $dto->setPrenom($enf->getPrenom());
                    $dto->setPaiementDate($insc->getPaiementDate());
                    $dto->setAge($enf->getNaissance());
                    $dtos[$enf->getId()]=$dto;
                }

                $dtop = new dtoReservationPreinsc();
                $dtop->setChoix($preinscription->getChoix());
                $dtop->setReservation($preinscription->getReservation());
                $dtop->setCreneauId($cren->getId());
                $dtop->setCreneauLieu($cren->getLieu());
                $dtop->setCreneauJour($cren->getJour());
                $dtop->setCreneauHeure($cren->getHeure());

                if ($insc->getPaiement()==0) {
                    $dtop->setStatus("A Payer");
                
                }else if ($preinscription->getReservation()==0) {
                    $dtop->setStatus("A Valider");
                }else {
                    $dtop->setStatus("Valide");
                }  
                $dto->addPreinscription($dtop);
            }
            
            //Rearrange pour classer en 3
            $valide=array();
            $avalider=array();
            $apayer=array();
            foreach ($dtos as $key=>$dto) {
                $found=false;
                foreach($dto->getPreinscriptions() as $p) {
                    if ($p->getStatus()=="Valide") {
                        array_push($valide,$dto->toArray());
                        $found=true;
                    } else if ($p->getStatus()=="A Payer") {
                        array_push($apayer,$dto->toArray());
                        $found=true;
                    }
                }
                if (! $found) {
                    array_push($avalider,$dto->toArray());
                }            
            }
            $resp=array("apayer" => $apayer, "avalider" => $avalider, "valide" => $valide);
            $newResponse = $response->withJson($resp);
            return $newResponse;
        });


        /**
         * TEST
         */
        $app->get("/inscription/test",function(ServerRequestInterface $request, ResponseInterface $response) {
            if (!isregister()){return;};

            $daoPersonne=new daoPersonne();
            $obj=new Personne();
            $obj->setNom("NomTest");
            $obj->setPrenom("PrenomTest");
            $obj->setAdresse("Adresse Test");
            $obj->setNaissance("2015-06-10");
            $obj->setSexe(1);
            $obj->setHandicap(0);
            $obj->setType('enfant');
            $obj->setCp('31860');
            $obj->setCommune('Labarthe sur leze');
            $obj->setTel("050120364");
            $obj->setTel2("");
            $obj->setMel("lhechris@gmail.com");
            $id=$daoPersonne->insert($obj);

            $newResponse = $response->write("Ok id $id");
            return $newResponse;
        });


    }

}
?>