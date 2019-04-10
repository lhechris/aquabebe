<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
include_once('log.php');

function mailvaccins($enfant)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        $from='admin@machris.fr';
        $mail->setFrom($from, 'Aquabebe');
        $mail->addAddress($enfant->getMel(), ''); 

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '[AQUA-BEBE] : Inscription de '.$enfant->getPrenom().' '.$enfant->getNom().' : Vaccination validée';
		
        $mail->Body    = 'Bonjour<br/><br/>'.
                         "Nous venons d'enregistrer la validation du carnet de vaccinations de ".$enfant->getPrenom()." ".
                         "<br/>Cordialement,".
                         "<br/><br/><br/><br/>L'&eacute;quipe Aqua-B&eacute;b&eacute;";
        
		$mail->AltBody = "Bonjour\n\n".
                         "Nous venons d'enregistrer la validation du carnet de vaccinations de ".$enfant->getPrenom()." ".
                         "\nCordialement,".
                         "\n\n\n\nL'équipe Aqua-Bébé";

        trace_mail($from,$enfant->getMel(),$mail->Subject,$mail->Body);
        $mail->send();        

    } catch (Exception $e) {
        trace_error("Erreur lors de l'envoi d'un message:". $e->getMessage());
    }
}

?>