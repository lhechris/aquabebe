<?php
		
	define( "_MSG_ERREUR_REQUIRED_VALUE", htmlentities("Ce champ doit �tre renseign� :",null,"utf-8",false));
	define( "_MSG_ERREUR_TEL",	htmlentities("Le num�ro de t�l�phone doit �tre form� uniquement par des chiffres ou des espaces (ex. : )05 34 48 68 97",null,"utf-8",false));
	define( "_MSG_ERREUR_MAIL",	htmlentities("L'adresse Email n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_CP",	htmlentities("Le code postal n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_CRENEAUX_1", htmlentities("Veuillez ne saisir que des chiffres de 1 � 9",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_2", htmlentities("Veuillez indiquer votre cr�neau pr�f�r� par un 1",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_3", htmlentities("Chaque chiffre ne doit �tre utilis� qu'une seule fois",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_4", htmlentities("Les chiffres doivent se suivrent en commen�ant par 1 puis 2...",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_DATE_1", htmlentities("La date doit �tre form� de chifres et de / (ex. : 01/09/2009)",null,"utf-8",false));
	define( "_MSG_ERREUR_DATE_2", htmlentities("La date saisie n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_PAIEMENT", htmlentities("Vous devez choisir un moyen de paiement maintenant..",null, null,false));
	
	define( "_PAIEMENT_PAR_CHEQUE", "<strong>".htmlentities("Je choisis de payer par ch�que.",null,"utf-8",false)."</strong>"
				."<br/>"
				.htmlentities("Apr�s avoir valid� ce formulaire, vous enverrez un ch�que qui devra parvenir � l'association dans les 7&nbsp;jours pour 
                       confirmer l'inscription de ".$_POST['prenom'].". Si vous inscrivez plusieurs enfants en m�me temps ou si vous avez d�j� 
                       des enfants inscrits � l'association, merci de contacter Marie-Paule ",null,"utf-8",false)."
                       (<a href=\"mailto:contact@aquabebe.fr\">contact@aquabebe.fr</a>)"
                       .htmlentities(" pour connaitre le montant de votre cotisation. Sinon envoyer un ch�que de %d� � l'ordre de AQUA-BEBE � ",null,"utf-8",false)
				."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>");
        
	define( "_PAIEMENT_PAR_CB", "<strong>".htmlentities("Je choisis de payer par CB.",null,"utf-8",false)."</strong>"
				."<img src=\"http://www.paypal-france.fr/marchands/qui-est-paypal/img/moyen-paiements-blanc-2.gif\" 
               alt=\"cartes de paiement autoris�es par Paypal\" title=\"Cartes de paiement autoris�es\"/><br/>"
				.htmlentities("En validant ce formulaire, vous serez dirig� vers la page de paiement en ligne. Si vous inscrivez plusieurs enfants, 
                       vous ne pouvez pas choisir actuellement ce mode de paiement. Si vous inscrivez uniquement ".$_POST['prenom'].", 
                       vous devez r�gler %d.",null,"utf-8",false));
							
	define( "_INSCRIPTION_DEJA_ENREGISTREE", htmlentities("L'inscription de cet enfant a d�j� �t� r�alis�e. En cas de doute ou de probl�me sur cette inscription, 
           vous pouvez contacter Sandrine (postmaster@aquabebe.fr).",null,"utf-8",false));
           
	define( "_INSCRIPTION_NON_ENREGISTREE", htmlentities("Une erreur s'est produite lors l'enregistrement de l'inscription. 
            Vous pourrez essayer � nouveau dans quelques instants. Si le probl�me se reproduit, vous pouvez contacter 
            Sandrine (postmaster@aquabebe.fr).",null,"utf-8",false));
	
	define( "_SUJET_CERTIFICAT", htmlentities("Inscription de %s %s => Certificat m�dical re�u [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_CERTIFICAT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous venons d'enregistrer le certificat m�dical de %s qui pourra d�sormais participer aux s�ances du cr�neau qui lui a �t� affect� 
                   � l'inscription.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'�quipe Aqua-B�b�",null,"utf-8",false));define( "_SUJET_PAIEMENT", htmlentities("Inscription de %s %s => Paiement re�u [AQUA-BEBE]",null,"utf-8",false));
    
	define( "_MESSAGE_PAIEMENT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous vous remercions du paiement de votre cotisation pour l'inscription de %s aux s�ances de b�b� nageurs avec Aqua-B�b�. 
                   Vous recevrez sous peu un message indiquant le cr�neau auquel vous pourrez participer.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'�quipe Aqua-B�b�",null,"utf-8",false));
    
	define( "_SUJET_CRENEAU", htmlentities("Inscription de %s %s => Cr�neau valid� [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_CRENEAU", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Nous sommes heureux de vous compter parmis nous. Vous pourrez donc venir avec %s le %s %s.",null,"utf-8",false)."<br/>"
		.htmlentities("Pensez � apporter un certificat m�dical de moins de 3 mois attestant que %s peut bien pratiquer l'activit�. Il est indispensable 
                   pour acc�der au bassin.",null,"utf-8",false)."<br/>"
		.htmlentities("Nous vous rappelons �galement que %s devra porter une couche ou un maillot anti-fuite sp�cial piscine.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'�quipe Aqua-B�b�",null,"utf-8",false));
    
	define( "_SUJET_INSCRIPTION", htmlentities("Inscription de %s %s => Inscription enregistr�e [AQUA-BEBE]",null,"utf-8",false));
  
	define( "_MESSAGE_INSCRIPTION_2", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Vous venez d'inscrire %s depuis notre site web. Cette inscription a bien �tait enregistr�e.",null,"utf-8",false)."<br/>"
		.htmlentities("Vous devriez avoir �t� redirig� vers la page de paiement en ligne et avoir effectu� ce paiement. 
                   Si ce n'est pas le cas, vous pouvez contacter Sandrine (postmaster@aquabebe.fr) 
                   pour pouvoir d�bloquer votre inscription.",null,"utf-8",false)."<br/>"
		.htmlentities("Si le paiement a �t� enregistr�, vous aller recevoir un message le confirmant.",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'�quipe Aqua-B�b�",null,"utf-8",false));
	define( "_MESSAGE_INSCRIPTION_1", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Vous venez de vous inscrire depuis notre site web. Cette inscription a bien �tait enregistr�e. 
                   Elle ne sera valid�e qu'apr�s r�ception du paiement. Un cr�neau vous sera alors attribu�.",null,"utf-8",false)."<br/>"
		.htmlentities("Vous avez 7 jours pour nous faire parvenir par ch�que � l'ordre de ",null,"utf-8",false)."<strong>AQUA-BEBE</strong>"
		.htmlentities("le montant de votre cotisation en l'envoyant � ",null,"utf-8",false)
		."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
		.htmlentities("Pensez � noter le pr�nom et le nom de %s au dos du ch�que. Le montant vous a �t� donn� en fin d'inscription. 
                   En cas de doute vous pouvez joindre Aqua-B�b� (contact@aquabebe.fr ou 09.72.11.66.39).",null,"utf-8",false)."<br/><br/>"
		.htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		.htmlentities("L'�quipe Aqua-B�b�",null,"utf-8",false));
		
	define( "_ENVOI_MESSAGE_OK", htmlentities("Un E-mail vous a �t� envoy�. Si vous ne l'avez pas re�u dans 24h, 
                                             merci de contacter Sandrine (postmaster@aquabebe.fr) afin de v�rifier votre adresse et 
                                             de ne pas bloquer votre inscription.",null,"utf-8",false));
	define( "_ENVOI_MESSAGE_KO","<span class=\"complet\">".htmlentities("L'E-mail n'a pu vous �tre envoy�. Merci de contacter Alice au 06.84.64.87.85 afin de v�rifier votre adresse et de ne pas bloquer votre inscription.",null,"utf-8",false)."</span>");
?>
