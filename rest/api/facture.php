<?php
require('fpdf181/fpdf.php');
include_once("config.php");

function chiffre2lettre($v) 
{
    if ($v<17){ 
        switch ($v){ 
            case 0: return 'Zero'; 
            case 1: return 'Un'; 
            case 2: return 'Deux'; 
            case 3: return 'Trois'; 
            case 4: return 'Quatre'; 
            case 5: return 'Cinq'; 
            case 6: return 'Six'; 
            case 7: return 'Sept'; 
            case 8: return 'Huit'; 
            case 9: return 'Neuf'; 
            case 10: return 'Dix'; 
            case 11: return 'Onze'; 
            case 12: return 'Douze'; 
            case 13: return 'Treize'; 
            case 14: return 'Quatorze'; 
            case 15: return 'Quinze'; 
            case 16: return 'Seize'; 
        } 

    } else if ($v<20){ 
        return 'dix-'.chiffre2lettre($v-10); 

    } else if ($v<100){ 
        if ($v%10==0){ 
            switch ($v){ 
                case 20: return 'Vingt'; 
                case 30: return 'Trente'; 
                case 40: return 'Quarante'; 
                case 50: return 'Cinquante'; 
                case 60: return 'Soixante'; 
                case 70: return 'Soixante-Dix'; 
                case 80: return 'Quatre-Vingt'; 
                case 90: return 'Quatre-Vingt-Dix'; 
            } 

        } elseif (substr($v, -1)==1){ 
            if( ((int)($v/10)*10)<70 ){ 
            return chiffre2lettre((int)($v/10)*10).'-et-un'; 

        } elseif ($v==71) { 
            return 'Soixante et onze'; 

        } elseif ($v==81) { 
            return 'Quatre vingt un'; 

        } elseif ($v==91) { 
            return 'Quatre vingt onze'; 
        } 

        } elseif ($v<70){ 
            return chiffre2lettre($v-$v%10).'-'.chiffre2lettre($v%10); 
        } elseif ($v<80){ 
            return chiffre2lettre(60).'-'.chiffre2lettre($v%20); 
        } else{ 
            return chiffre2lettre(80).'-'.chiffre2lettre($v%20); 
        } 
    } else if ($v==100){ 
        return 'Cent'; 

    } else if ($v%100==0){
        switch ($v){ 
            case 200: return 'Deux-Cents'; 
            case 300: return 'Trois-Cents'; 
            case 400: return 'Quatre-Cents'; 
            case 500: return 'Cinq-Cents'; 
            case 600: return 'Six-Cents'; 
            case 700: return 'Sept-Cents'; 
            case 800: return 'Huit-Cents'; 
            case 900: return 'Neuf-Cents'; 
        } 
     
    
    } else if ($v<200){ 
        return chiffre2lettre(100).' '.chiffre2lettre($v%100); 
    } else if ($v<1000){ 
        return chiffre2lettre((int)($v/100)).' '.chiffre2lettre(100).' '.chiffre2lettre($v%100); 
    } else if ($v==1000){ 
        return 'Mille'; 
    } else if ($v<2000){ 
        return chiffre2lettre(1000).' '.chiffre2lettre($v%1000).' '; 
    } else if ($v<1000000){ 
        return chiffre2lettre((int)($v/1000)).' '.chiffre2lettre(1000).' '.chiffre2lettre($v%1000); 
    } 
    
}




function facture($enfant,$inscription,$paiement,$creneau) {

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
    $montant =$inscription->getPaiement();
    $montant_lettre=chiffre2lettre($montant);


    $txt="Je soussignée Florent Lavail, Président de l'Association Aqua-Bébé,\n".
        "certifie que ".$paiement->getPayeur()." a bien réglé le ".
        "montant de la cotisation pour la saison ".CURRENT_SAISON." par chèque.\n".
        "La somme payée est de $montant_lettre euros (".$montant."&euro;) dont vingt euros\n".
        "(20&euro;) d'adhésion à l'association.\n\n\n".
        "Cette cotisation concerne l'enfant ".$enfant->getPrenom()." ".$enfant->getNom()." né le \n".
        $enfant->getNaissance().", qui pratique l'activité des bébés nageurs le ".
        $creneau->getJour()." ".$creneau->getHeure()." à " .$creneau->getLieu()."\n".
        "Ce document n'engage pas l'association sur la provision des\n".
        "paiements effectués en plusieurs fois.\n".
        "Fait à St Lys, le 20/09/2018";
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
    //echo utf8_decode($txt);
}

?>