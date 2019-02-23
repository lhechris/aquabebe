<?php
require('fpdf181/fpdf.php');
include_once("config.php");
include_once('daoClass.php');
include_once('api/dto/dtoFacture.php');
include_once("api/utils.php");


class daoFacture extends daoClass {

    public function get($id) {
        $query="select personne.nom,".        /* 0 */
                       "personne.prenom,".    /* 1 */
                       "personne.naissance,". /* 2 */
                       "paiement.payeur,".    /* 3 */
                       "paiement.montant,".    /* 4 */
                       "creneau.lieu,".       /* 5 */
                       "creneau.jour,".       /* 6 */
                       "creneau.heure ".      /* 7 */
                "from personne,paiement,creneau,inscription ".
                "where inscription.id_enfant=personne.id and ".
                "paiement.id=inscription.paiement and ".
                "creneau.id=inscription.id_creneau and ".
                "personne.id=".$id;
        
        trace_debug($query);
        try {
            $stmt=$this->pdo->query($query);
            $liste=$stmt->fetchAll();
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return null;
        }

        $dtofacture=new dtoFacture();
        foreach($liste as $r)
        {
            $dtofacture->setNom($r[0]);
            $dtofacture->setPrenom($r[1]);
            $dtofacture->setNaissance($r[2]);
            $dtofacture->setPayeur($r[3]);
            $dtofacture->setMontant($r[4]);
            $dtofacture->setLieu($r[5]);
            $dtofacture->setJour($r[6]);
            $dtofacture->setHeure($r[7]);
        }

        $this->facture($dtofacture);

    }





    private function facture($fact) {

        //Creer le PDF : portrait, unités en mm et taille A4
        $pdf = new FPDF("P","mm","A4");
        //On cree une page
        $pdf->AddPage();
        //Insert l'image de fond (x,y,w)
        $pdf->Image("../img/aqua_bebe.jpg",-40,5,250);

        $pdf->SetFont('Helvetica','',16);

        //Entete 
        $pdf->Cell(10,5,"",0,1);
        $pdf->Cell(100,5,"",0,0);
        $pdf->SetTextColor(42 ,83 ,150);
        $pdf->MultiCell(80,5,utf8_decode("ATTESTATION D'ADHESION\nSaison ").CURRENT_SAISON,0,"C");
        $pdf->Ln();
        $pdf->Cell(10,33,"",0,1);
        $pdf->Cell(100,5,"",0,0);
        $pdf->MultiCell(80,5,"820, route de Saint Thomas\n31470 Saint Lys",0,"C");
        
        //Texte
        $montant =$fact->getMontant();
        $montant_lettre=chiffre2lettre($montant);


        $txt="Je soussignée Florent Lavail, Président de l'Association Aqua-Bébé,\n".
            "certifie que ".$fact->getPayeur()." a bien réglé le ".
            "montant de la cotisation pour la saison ".CURRENT_SAISON." par chèque.\n".
            "La somme payée est de $montant_lettre euros (".$montant."&euro;) dont vingt euros\n".
            "(20&euro;) d'adhésion à l'association.\n\n\n".
            "Cette cotisation concerne l'enfant ".$fact->getPrenom()." ".$fact->getNom()." né le \n".
            formatDate($fact->getNaissance()).", qui pratique l'activité des bébés nageurs le ".
            $fact->getJour()." ".$fact->getHeure()." à " .$fact->getLieu()."\n".
            "Ce document n'engage pas l'association sur la provision des\n".
            "paiements effectués en plusieurs fois.\n".
            "Fait à St Lys, le ".date('d/m/Y');
        $txtconv=utf8_decode($txt);
        $txtconv = str_replace('&euro;', chr(128), $txtconv);

        $pdf->SetFont('Helvetica','',12);
        $pdf->SetTextColor(0 ,0 ,0);
        $pdf->Ln();
        $pdf->Cell(10,33,"",0,1);
        $pdf->Cell(35,5,"",0,0);
        $pdf->MultiCell(150,5,$txtconv,0,"L");
        

        //genere la page
        $pdf->Output();
        exit(0);
        //echo utf8_decode($txt);
    }
}
?>