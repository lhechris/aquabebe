<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
include_once('log.php');

function _mailcreneau($destinataire,$msg,$sujet,$files)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
    /*     $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user@example.com';                 // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    */
        //Recipients
        $from='admin@machris.fr';
        $mail->setFrom($from, 'Aquabebe');
        $mail->addAddress($destinataire, '');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        foreach($files as $fichier) {
            $mail->addAttachment($fichier);         // Add attachments		
        }
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '[AQUA-BEBE] '.$sujet;
		
        $mail->Body    = $msg;

        trace_mail($from,$destinataire,$mail->Subject,$mail->Body);
        $mail->send();

    } catch (Exception $e) {
        trace_error("Erreur lors de l'envoi d'un message:". $e->getMessage());
    }
}


function mailcreneau($destinataires,$msg,$sujet,$files)
{
    foreach($destinataires as $destinataire) {
        _mailcreneau($destinataire,$msg,$sujet,$files);
    }
}


?>