<?php
include_once("log.php");
include_once("dao/daoInscription.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoCreneau.php");
include_once("dao/inscription.php");
include_once("dao/personne.php");

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
            //Ajoute les inscriptions et preinscriptions
            foreach($creneaux as $creneau) {
                trace_info("creneau:".$creneau->getId()." nbinscrit=".$creneau->getNbInscrit()." capacite=".$creneau->getCapacite()." ".array_key_exists((string)($creneau->getId()),$listcreneaux));
                if (($creneau->getNbInscrit()<$creneau->getCapacite()) && 
                    (array_key_exists((string)($creneau->getId()),$listcreneaux))
                   ) 
                {
                    $inscr=new Inscription();
                    $inscr->setEnfant($enfant);
                    $inscr->setCreneau($creneau);
                    $ret=$daoinscription->insert($inscr);
                    if ($ret==false) {
                        trace_info("Can't add inscription, error while inserting inscription");
                        $newResponse = $response->write("Internal error: can't create inscription");
                        return $newResponse;
                    }
                            
                    $preinscr=new Preinscription();
                    $preinscr->setCreneau($creneau);
                    $preinscr->setInscription($inscr);
                    $preinscr->setChoix($listcreneaux[$creneau->getId()]);
                    $daoinscription->insert($preinscr);
                    if ($ret==false) {
                        trace_info("Can't add inscription, error while inserting preinscription");
                        $newResponse = $response->write("Internal error: can't create inscription");
                        return $newResponse;
                    }
                            
                }
                else
                {
                    $newResponse = $response->write("Les creneaux de correspondent pas");
                    return $newResponse;
                }
            }
            $newResponse = $response->write("Inscription ajoutée");
            //$newResponse = $response->withJson($json);
            return $newResponse;

        });

        $app->get("/inscription/test",function(ServerRequestInterface $request, ResponseInterface $response) {
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