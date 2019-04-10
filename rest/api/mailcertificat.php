<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
include_once('log.php');

function mailcertificat($enfant)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        $from='admin@machris.fr';
        $mail->setFrom($from, 'Aquabebe');
        $mail->addAddress($enfant->getMel(), ''); 

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '[AQUA-BEBE] : Inscription de '.$enfant->getPrenom().' '.$enfant->getNom().' : Certificat reçu';
		
        $mail->Body    = 'Bonjour<br/><br/>'.
                         "Nous venons d'enregistrer le certificat m&eacute;dical de ".$enfant->getPrenom()." ".
                         "qui pourra d&eacute;sormais participer aux s&eacute;ances du cr&eacute;neau qui lui a &eacute;t&eacute; affect&eacute; à l'inscription.<br/>".
                         "<br/><br/><br/><br/>Alors, &agrave; bient&ocirc;t, les pieds dans l'eau !<br/>L'&eacute;quipe Aqua-B&eacute;b&eacute;";
        
		$mail->AltBody = "Bonjour\n\n".
                         "Nous venons d'enregistrer le certificat médical de ".$enfant->getPrenom()." ".
                         "qui pourra désormais participer aux séances du créneau qui lui a été affecté à l'inscription.<br/>".
                         "\n\n\n\nAlors, à bientôt, les pieds dans l'eau !\nL'équipe Aqua-Bébé";

        trace_mail($from,$enfant->getMel(),$mail->Subject,$mail->Body);
        $mail->send();

    } catch (Exception $e) {
        trace_error("Erreur lors de l'envoi d'un message:". $e->getMessage());
    }
}

?>