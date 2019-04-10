<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
include_once('log.php');

function mailinscription($enfant)
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
        $mail->addAddress($enfant->getMel(), '');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
      
        $mail->addAttachment('./api/uploads/AQUABEBE-Documents-inscription.pdf','AQUABEBE-Documents-inscription.pdf');         // Add attachments		
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '[AQUA-BEBE] : Inscription de '.$enfant->getPrenom().' '.$enfant->getNom().' : Inscription enregistree';
		
        $mail->Body    = 'Bonjour<br/><br/>'.
						"Vous venez de vous inscrire depuis notre site web. Cette pre-inscription a bien &eacute;t&eacute; ".
						"enregistr&eacute;e. Elle ne sera valid&eacute;e qu'apr&egrave;s r&eacute;ception du paiement et apr&egrave;s ".
						"attribution du cr&eacute;neau.".
						"<br/><u>Nous devons recevoir vos ch&egrave;ques dans les 7 jours. </u>".
						"Sans r&eacute;ception de votre paiement ".
						"dans les d&eacute;lais, votre place sera automatiquement lib&eacute;r&eacute;e par le serveur et attribu&eacute;e ".
						"&agrave; la personne suivante. ".
						"<br/><br/>Les ch&egrave;ques doivent &ecirc;tre &eacute;tablis &agrave; l'ordre de l'<strong>Association Aqua-Bebe </strong>et envoy&eacute;s en courrier simple &agrave; <address>AQUA-BEBE<br/>chez Florence Michel-Jerolon<br/>1 rue Berlioz<br/>31880 LA salvetat-Saint-Gilles</address><br/>".
						"Merci de noter le pr&eacute;nom et le nom de ".$enfant->getPrenom()." au dos des ch&egrave;ques. Le montant annuel du paiement  ".
						"(cotisation + adh&eacute;sion) est de 200&euro; (180&euro; + 20&euro;) pour un enfant et 360&euro; (340&euro; + 20&euro;) pour 2 enfants.".
						"Le montant de l'adh&eacute;sion (20&euro;) est &agrave; acquitter via un ch&egrave;que &agrave; part. La cotisation est &agrave; payer en 1 &agrave; 3 ch&egrave;ques. <br/>En cas de doute vous pouvez consulter la page Tarifs et/ou joindre Aqua-Bebe (contact@aquabebe.fr). ".
						"<br/><br/><br/><br/>Alors, &agrave; bient&ocirc;t, les pieds dans l'eau !<br/>L'&eacute;quipe Aqua-B&eacute;b&eacute;";
        
		$mail->AltBody = "Bonjour\n\n".
						"Vous venez de vous inscrire depuis notre site web. Cette pre-inscription a bien été ".
						"enregistrée. Elle ne sera validée qu'après réception du paiement et après ".
						"attribution du créneau.".
						"\nNous devons recevoir vos chèques dans les 7 jours.".
						"Sans réception de votre paiement ".
						"dans les délais, votre place sera automatiquement libérée par le serveur et attribuée ".
						"à la personne suivante. ".
						"\n\nLes chèques doivent être établis à l'ordre de l'Association Aqua-Bebe et envoyés en courrier simple à AQUA-BEBE\nchez Florence Michel-Jerolon\n1 rue Berlioz\n31880 LA salvetat-Saint-Gilles\n".
						"Merci de noter le prénom et le nom de ".$enfant->getPrenom()." au dos des chèques. Le montant annuel du paiement  ".
						"(cotisation + adhésion) est de 200€ (180€ + 20€) pour un enfant et 360€ (340€ + 20€) pour 2 enfants.".
						"Le montant de l'adhésion (20€) est à acquitter via un chèque à part. La cotisation est à payer en 1 à 3 chèques. \nEn cas de doute vous pouvez consulter la page Tarifs et/ou joindre Aqua-Bebe (contact@aquabebe.fr). ".
						"\n\n\n\nAlors, à bientôt, les pieds dans l'eau !\nL'équipe Aqua-Bébé";

        trace_mail($from,$enfant->getMel(),$mail->Subject,$mail->Body);
        $mail->send();

    } catch (Exception $e) {
        trace_error("Erreur lors de l'envoi d'un message:". $e->getMessage());
    }
}

?>