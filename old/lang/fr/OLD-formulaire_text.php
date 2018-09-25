<?php
		
	define( "_MSG_ERREUR_REQUIRED_VALUE", htmlentities("Ce champ doit être renseigné :",null,"utf-8",false));
	define( "_MSG_ERREUR_TEL",	htmlentities("Le numéro de téléphone doit être formé uniquement par des chiffres ou des espaces (ex. : )05 34 48 68 97",null,"utf-8",false));
	define( "_MSG_ERREUR_MAIL",	htmlentities("L'adresse Email n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_CP",	htmlentities("Le code postal n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_CRENEAUX_1", htmlentities("Veuillez ne saisir que des chiffres de 1 à 9",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_2", htmlentities("Veuillez indiquer votre créneau préféré par un 1",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_3", htmlentities("Chaque chiffre ne doit être utilisé qu'une seule fois",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_4", htmlentities("Les chiffres doivent se suivrent en commençant par 1 puis 2...",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_DATE_1", htmlentities("La date doit être formé de chifres et de / (ex. : 01/09/2009)",null,"utf-8",false));
	define( "_MSG_ERREUR_DATE_2", htmlentities("La date saisie n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_PAIEMENT", htmlentities("Vous devez choisir un moyen de paiement maintenant..",null, null,false));
	
	define( "_PAIEMENT_PAR_CHEQUE", "<strong>".htmlentities("Je choisis de payer par chèque.",null,"utf-8",false)."</strong>"
				."<br/>"
				.htmlentities("Après avoir validé ce formulaire, vous enverrez un chèque qui devra parvenir à l'association dans les 7&nbsp;jours pour 
                       confirmer l'inscription de ".$_POST['prenom'].". Si vous inscrivez plusieurs enfants en même temps ou si vous avez déjà 
                       des enfants inscrits à l'association, merci de contacter Marie-Paule ",null,"utf-8",false)."
                       (<a href=\"mailto:contact@aquabebe.fr\">contact@aquabebe.fr</a>)"
                       .htmlentities(" pour connaitre le montant de votre cotisation. Sinon envoyer un chèque de %d€ à l'ordre de AQUA-BEBE à ",null,"utf-8",false)
				."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>");
        
	define( "_PAIEMENT_PAR_CB", "<strong>".htmlentities("Je choisis de payer par CB.",null,"utf-8",false)."</strong>"
				."<img src=\"http://www.paypal-france.fr/marchands/qui-est-paypal/img/moyen-paiements-blanc-2.gif\" 
               alt=\"cartes de paiement autorisées par Paypal\" title=\"Cartes de paiement autorisées\"/><br/>"
				.htmlentities("En validant ce formulaire, vous serez dirigé vers la page de paiement en ligne. Si vous inscrivez plusieurs enfants, 
                       vous ne pouvez pas choisir actuellement ce mode de paiement. Si vous inscrivez uniquement ".$_POST['prenom'].", 
                       vous devez régler %d.",null,"utf-8",false));
							
	define( "_INSCRIPTION_DEJA_ENREGISTREE", htmlentities("L'inscription de cet enfant a déjà été réalisée. En cas de doute ou de problème sur cette inscription, 
           vous pouvez contacter Sandrine (postmaster@aquabebe.fr).",null,"utf-8",false));
           
	define( "_INSCRIPTION_NON_ENREGISTREE", htmlentities("Une erreur s'est produite lors l'enregistrement de l'inscription. 
            Vous pourrez essayer à nouveau dans quelques instants. Si le problème se reproduit, vous pouvez contacter 
            Sandrine (postmaster@aquabebe.fr).",null,"utf-8",false));
	
	define( "_SUJET_CERTIFICAT", htmlentities("Inscription de %s %s => Certificat médical reçu [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_CERTIFICAT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous venons d'enregistrer le certificat médical de %s qui pourra désormais participer aux séances du créneau qui lui a été affecté 
                   à l'inscription.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));define( "_SUJET_PAIEMENT", htmlentities("Inscription de %s %s => Paiement reçu [AQUA-BEBE]",null,"utf-8",false));
    
	define( "_MESSAGE_PAIEMENT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous vous remercions du paiement de votre cotisation pour l'inscription de %s aux séances de bébé nageurs avec Aqua-Bébé. 
                   Vous recevrez sous peu un message indiquant le créneau auquel vous pourrez participer.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
    
	define( "_SUJET_CRENEAU", htmlentities("Inscription de %s %s => Créneau validé [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_CRENEAU", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous sommes heureux de vous compter parmis nous. Vous pourrez donc venir avec %s le %s %s.",null,"utf-8",false)."<br/>"
		.htmlentities("Pensez à apporter un certificat médical de moins de 3 mois attestant que %s peut bien pratiquer l'activité. Il est indispensable 
                   pour accéder au bassin.",null,"utf-8",false)."<br/>"
		.htmlentities("Nous vous rappelons également que %s devra porter une couche ou un maillot anti-fuite spécial piscine.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
    
	define( "_SUJET_INSCRIPTION", htmlentities("Inscription de %s %s => Inscription enregistrée [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_INSCRIPTION_2", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Vous venez d'inscrire %s depuis notre site web. Cette inscription a bien était enregistrée.",null,"utf-8",false)."<br/>"
		.htmlentities("Vous devriez avoir été redirigé vers la page de paiement en ligne et avoir effectué ce paiement. 
                   Si ce n'est pas le cas, vous pouvez contacter Sandrine (postmaster@aquabebe.fr) 
                   pour pouvoir débloquer votre inscription.",null,"utf-8",false)."<br/>"
		.htmlentities("Si le paiement a été enregistré, vous aller recevoir un message le confirmant.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
	define( "_MESSAGE_INSCRIPTION_1", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Vous venez de vous inscrire depuis notre site web. Cette inscription a bien était enregistrée. 
                   Elle ne sera validée qu'après réception du paiement. Un créneau vous sera alors attribué.",null,"utf-8",false)."<br/>"
		.htmlentities("Vous avez 7 jours pour nous faire parvenir par chèque à l'ordre de ",null,"utf-8",false)."<strong>AQUA-BEBE</strong>"
		.htmlentities("le montant de votre cotisation en l'envoyant à ",null,"utf-8",false)
		."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
		.htmlentities("Pensez à noter le prénom et le nom de %s au dos du chèque. Le montant vous a été donné en fin d'inscription. 
                   En cas de doute vous pouvez joindre Aqua-Bébé (contact@aquabebe.fr ou 09.72.11.66.39).",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
		
	define( "_ENVOI_MESSAGE_OK", htmlentities("Un E-mail vous a été envoyé. Si vous ne l'avez pas reçu dans 24h, 
                                             merci de contacter Sandrine (postmaster@aquabebe.fr) afin de vérifier votre adresse et 
                                             de ne pas bloquer votre inscription.",null,"utf-8",false));
	define( "_ENVOI_MESSAGE_KO","<span class=\"complet\">".htmlentities("L'E-mail n'a pu vous être envoyé. Merci de contacter Alice au 06.84.64.87.85 afin de vérifier votre adresse et de ne pas bloquer votre inscription.",null,"utf-8",false)."</span>");
?>
