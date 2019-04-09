<?php
include_once("log.php");
include_once("dao/daoPersonne.php");
include_once("dao/daoEnfant.php");
include_once("dao/daoPaiement.php");
include_once("dao/daoInscription.php");
include_once("dao/daoEnfant.php");
include_once("dao/daoFacture.php");
include_once("config.php");
include_once("dto/dtoPostEnfant.php");
include_once("transformer/transformerEnfant.php");
include_once("utils.php");

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestEnfant {

    public function __construct($app)
    {

        /**
         * METHOD GET enfant
         */
        $app->get('/enfant/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {           

            if (!isregister()){return;};

            $daoenfant=new daoEnfant();
            $enfant=$daoenfant->get($args["id"]);
            $data=$enfant->toArray();
            $newResponse = $response->withJson($data);
            return $newResponse;
            
        });


        /**
         * METHOD POST enfant
         */
        $app->post('/enfant/profile', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            if (!isregister()){return;};

            $json = $request->getParsedBody();
            trace_params("POST enfant profile",$json,array("id"));
            $creneauselected=-1;

            //Read inputs
            $dtopostenfant=new dtoPostEnfant();
            $dtopostenfant->fromArray($json);

            //convert DTO 
            $enfant=convertDtoPostEnfantToPersonne($dtopostenfant);
            $paiement=convertDtoPostEnfantToPaiement($dtopostenfant);
            $creneauselected=$dtopostenfant->getCreneauSelected();

            //Store
            trace_info("store ".$enfant->getId());
            $daopers=new daoPersonne();
            $oldenfant = $daopers->getById($dtopostenfant->getId());
            $daopers->update($oldenfant["enfant"],$enfant);
            
            if (($paiement->getMontant()!=null)&&(strtolower($paiement->getMontant())!="null")) {
                $daopaiement=new daoPaiement();
                $oldpaiement=$daopaiement->get($paiement->getId());
                if ($oldpaiement==null) {
                    $daopaiement->insert($paiement);
                    //Ajoute ce paiement a toute les preinscription
                    $preinscs=$oldenfant["preinscriptions"];
                    foreach($preinscs as $preinsc) {
                        trace_debug("reservation=".$preinsc->getReservation()." id=".$preinsc->getInscription()->getId()." ");

                        $inscr=$preinsc->getInscription();
                        $inscr->setPaiement($paiement->getId());
                        $daoinscription=new daoInscription();
                        //Ajoute le paiement
                        $daoinscription->addPaiement($inscr);

                        //Cree la reservation
                        //$inscr->setCreneauid($creneauselected);
                        //$daoinscription->updateCreneau($inscr);                        
                    }
                } else {
                    $daopaiement->update($oldpaiement,$paiement);                
                }
            }
            $newResponse = $response->write("Paiement modifié");
            return $newResponse;            
        });

        /**
         * METHOD POST enfant
         */
        $app->post('/enfant/creneau', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
           
            if (!isregister()){return;};

            $json = $request->getParsedBody();
            trace_params("POST Valider creneau enfant",$json,array("id","creneau"));
            //TODO recupere l'inscription en bdd pour savoir si elle existe
            $inscr=new Inscription();
            $inscr->setId($json["id"]);
            $inscr->setCreneauid($json["creneau"]);
            $dao=new daoInscription();
            $dao->updateCreneau($inscr);

            $newResponse = $response->write("Creneau validé");
            return $newResponse;            
        });



        /**
         * METHOD POST certificat
         */
        $app->post('/enfant/certificat/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("POST certificat/".$args["id"]);

            $daoinscr=new daoInscription();
            $inscr = $daoinscr->get($args["id"]);
            $daoinscr->updateCertificat($inscr);
        });
        $app->post('/enfant/vaccins/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("POST vaccins/".$args["id"]);

            $daoinscr=new daoInscription();
            $inscr = $daoinscr->get($args["id"]);
            $daoinscr->updateVaccins($inscr);
        });
        $app->post('/enfant/facture/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("POST facture/".$args["id"]);

            $daoinscr=new daoInscription();
            $inscr = $daoinscr->get($args["id"]);
            $daoinscr->updateFacture($inscr);
        });

        $app->get('/enfant/facture/{id}', function(ServerRequestInterface $request, ResponseInterface $response,$args) {
            if (!isregister()){return;};

            trace_info("GET facture/".$args["id"]);

            $daofacture=new daoFacture();
            $ret = $daofacture->get($args["id"]);
            
            //$newResponse = $response->write($ret);
            /*$data=$ret->toArray();
            $newResponse = $response->withJson($data);
            return $newResponse;  */          

        });
    }

}
?>