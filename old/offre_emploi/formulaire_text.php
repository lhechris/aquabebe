<?php
	
  $prenom = "";
  if (isset($_POST['prenom']))
    {
      $prenom = $_POST['prenom'];
    }
	
	define( "_MSG_ERREUR_REQUIRED_VALUE", htmlentities("Ce champ doit �tre renseign� :",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_TEL",	htmlentities("Le num�ro de t�l�phone doit �tre uniquement compos� de 10 chiffres
											(ex. : 0534486897)",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_TEL_PORTABLE",	htmlentities("Le num�ro de t�l�phone doit commencer par 06 ou 07.",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_MAIL",	htmlentities("L'adresse Email n'est pas valide",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_MAIL_2",	htmlentities("Vous avez d�j� r�pondu � la question. Pour modifier votre choix, 
                                              contactez-nous � l'adresse demenagement@aquabebe.fr",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_MAIL_3",	htmlentities("** D�cision non enregistr�e : Veuillez saisir l'adresse E-mail utilis�e lors de l'inscription. 
                                              En cas de probl�me, vous pouvez contacter demenagement@aquabebe.fr en indiquant les valeurs 
                                              renseign�es dans les champs.",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_CP",	htmlentities("Le code postal n'est pas valide",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_CRENEAUX_1", htmlentities("Veuillez ne saisir que des chiffres de 1 � 9",null,"ISO-8859-1",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_2", htmlentities("Veuillez indiquer votre cr�neau pr�f�r� par un 1",null,"ISO-8859-1",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_3", htmlentities("Chaque chiffre ne doit �tre utilis� qu'une seule fois",null,"ISO-8859-1",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_4", htmlentities("Les chiffres doivent se suivrent en commen�ant par 1 puis 2...",null,"ISO-8859-1",false)."<br/>");
	define( "_MSG_ERREUR_DATE_1", htmlentities("La date doit �tre form� de chifres et de / (ex. : 01/09/2009)",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_DATE_2", htmlentities("La date saisie n'est pas valide",null,"ISO-8859-1",false));
	define( "_MSG_ERREUR_PAIEMENT", htmlentities("Vous devez choisir un moyen de paiement maintenant..",null, null,false));
	
  // Message affich� lors de l'�tape 6 de l'inscription
  // ----------------------------------------------------------------
	define( "_PAIEMENT_PAR_CHEQUE", "<strong>".htmlentities("Je choisis de payer par ch�que.",null,"ISO-8859-1",false)."</strong>"
									."<br/>"
									.htmlentities("
										Apr�s avoir valid� ce formulaire, le paiement int�gral (participation + adh�sion) devra parvenir 
										� l'association dans les 7 jours pour confirmer l'inscription de ".$prenom.". 
										",null,"ISO-8859-1",false)
									."<br/>"."<br/>"
									.htmlentities("
										Le montant annuel du paiement  
                                        (cotisation + adh�sion) est de 200� pour un enfant et 360� pour 2 enfants.
                                        Le montant de l'adh�sion (20�) est � acquitter via un ch�que � part. 
										",null,"ISO-8859-1",false)
									."<br/>"."<br/>"
									.htmlentities("
										Si vous faites une inscription en cours d'ann�e, 
										merci de consulter la page Tarifs pour conna�tre le montant de l'inscription. 
										",null,"ISO-8859-1",false)
									."<br/>"
									.htmlentities("Si besoin, vous pouvez contacter AquaB�b� ",null,"ISO-8859-1",false)
									."(<a href=\"mailto:contact@aquabebe.fr\">contact@aquabebe.fr</a>)"
									.htmlentities(" pour confirmer le montant de votre cotisation. ",null,"ISO-8859-1",false)
									."<br/>"."<br/>"
									.htmlentities("
										Les ch�ques sont � �tablir � l'ordre de AQUA-BEBE et � envoyer � 
										",null,"ISO-8859-1",false)
									  ."<address>AQUA-BEBE<br/>chez Florence LUCIAN<br/>7, chemin du Mescurt<br/>31470 SAIGUEDE</address>"
									//."<address>AQUA-BEBE<br/>chez Marie-Aude Canet-Lhermitte<br/>1 rue Fr�d�ric Mistral<br/>31860 Labarthe-sur-Leze</address>"
									//."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
									//."<address>AQUA-BEBE<br/>chez Emilie Roux<br/>8 rue des alouettes<br/>31470 Saint Lys</address>"
									."<br/>"
									."<strong>".htmlentities("Important : ",null,"ISO-8859-1",false)."</strong>"
									.htmlentities("
										Un des ch�ques doit �tre de 20�, montant correspondant � l'adh�sion annuelle � l'association.   
										Le d�tail des ch�ques � envoyer se trouve sur la page Tarifs.
										",null,"ISO-8859-1",false)  
									."<br/>"."<br/>"                                       
			);

		// Si jamais un jour on se lance dans le paiement via CB.
		// _________________________________________________________
	/* define( "_PAIEMENT_PAR_CB", "<strong>".htmlentities("Paiement par CB non disponible.",null,"ISO-8859-1",false)."</strong>");
// AVANT v1.0 (i.e. pas dans www)
//             utilisation de getMontant() au lieu de %d : 
//              uniquement ".$prenom.", vous devez r�gler ".getMontant()."�.",null,"ISO-8859-1",false));
							
	define( "_INSCRIPTION_DEJA_ENREGISTREE", htmlentities("L'inscription de cet enfant a d�j� �t� r�alis�e. En cas de doute 
                                                        ou de probl�me sur cette inscription, vous pouvez contacter Florent 
                                                        (postmaster@aquabebe.fr).",null,"ISO-8859-1",false));
                                                        
	define( "_INSCRIPTION_NON_ENREGISTREE", htmlentities("Une erreur s'est produite lors l'enregistrement de l'inscription. 
                                                        Vous pourrez essayer � nouveau dans quelques instants. Si le probl�me 
                                                        se reproduit, vous pouvez contacter Florent (postmaster@aquabebe.fr).",
                                                        null,"ISO-8859-1",false));

     // Message  envoy� par e-mail aux parents apr�s validation des vaccins
    // ---------------------------------------------------------------------------------------      
	define( "_SUJET_VACCINS", htmlentities("[AQUA-BEBE] Inscription de %s %s : Vaccinations validees",null,"ISO-8859-1",false));
  
	define( "_MESSAGE_VACCINS", htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
                                .htmlentities("Nous venons d'enregistrer la validation du carnet de vaccinations de %s.",null,"ISO-8859-1",false)
                                ."<br/><br/>"
                                .htmlentities("Cordialement,",null,"ISO-8859-1",false)."<br/><br/>"
                                .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false));
								
      // Message  envoy� par e-mail aux parents apr�s validation du certificat medical 
     // ---------------------------------------------------------------------------------------                
	define( "_SUJET_CERTIFICAT", htmlentities("[AQUA-BEBE] Inscription de %s %s : Certificat medical re�u",null,"ISO-8859-1",false));
  
	define( "_MESSAGE_CERTIFICAT", htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
                                .htmlentities("Nous venons d'enregistrer le certificat m�dical de %s qui pourra d�sormais 
                                                participer aux s�ances du cr�neau qui lui a �t� affect� 
                                                � l'inscription.",null,"ISO-8859-1",false)
                                ."<br/><br/>"
                                .htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"ISO-8859-1",false)."<br/><br/>"
                                .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false));

      // Message  envoy� par e-mail aux parents apr�s r�ception du paiement
     // ---------------------------------------------------------------------------------------      
	define( "_SUJET_PAIEMENT", htmlentities("[AQUA-BEBE] Inscription de %s %s : Paiement re�u",null,"ISO-8859-1",false));
  
	define( "_MESSAGE_PAIEMENT", htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("Nous vous remercions du paiement de votre cotisation pour l'inscription de %s aux 
                                            s�ances de b�b� nageurs avec Aqua-B�b�. Nous allons maintenant v�rifier la disponibilit�
                                            des cr�neaux demand�s. ",null,"ISO-8859-1",false)."<br/>"
                              .htmlentities("Votre inscription sera confirm�e si un cr�neau peut vous �tre attribu�. 
                                            Si aucun cr�neau ne peut vous �tre attribu� lors du d�but des s�ances, nous vous contacterons 
                                            pour aviser avec vous.",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("Les ch�ques seront encaiss�s apr�s la premi�re s�ance si vous confirmez votre inscription.",
                                             null,"ISO-8859-1",false)."<br/>"
                              .htmlentities("Le calendrier d'encaissement des ch�ques est indiqu� sur notre site Web,  
                                              � la rubrique \"Inscrire un enfant\" - paragraphe \"Information sur les tarifs\" ",
                                              null,"ISO-8859-1",false)."<br/><br/>"
							  .htmlentities("Vous avez la possibilit� d'envoyer toutes les pi�ces obligatoires (R�glement Int�rieur et droits
							  � l'image sign�s, certificat m�dical de moins de 3 mois et la pages de vaccination du carnet de sant�) par mail.",null,"ISO-8859-1",false)."<br/><br/>"
							  .htmlentities("A d�faut, nous les apporter � l'une des 2 permanences suivantes : Samedi 06 septembre et le mercredi 10 septembre
							  de 10h00 � 20h00 au forum des associations de Saint Lys (Salle de la Gravette). ",null,"ISO-8859-1",false)."<br/><br/>"
                          .htmlentities("Un carnet de vaccinations � jour et un certificat m�dical de moins de 3 mois attestant que %s peut bien 
                                            pratiquer l'activit� sont indispensables pour acc�der au bassin. ",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("Cordialement,",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false));
							  
     // Message  envoy� par e-mail aux parents apr�s validation du cr�neau
    // ---------------------------------------------------------------------------------------                           
	define( "_SUJET_CRENEAU", htmlentities("[AQUA-BEBE] : Inscription de %s %s => Creneau valid� ",null,"ISO-8859-1",false));
  
	define( "_MESSAGE_CRENEAU", htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("Nous sommes heureux de vous compter parmi nous. Vous pourrez donc venir avec %s le %s %s.",
                                            null,"ISO-8859-1",false)."<br/>"
                              .htmlentities("Vous avez la possibilit� d'envoyer toutes les pi�ces obligatoires (R�glement Int�rieur et droits
							  � l'image sign�s, certificat m�dical de moins de 3 mois et la pages de vaccination du carnet de sant�) par mail.",null,"ISO-8859-1",false)."<br/><br/>"
							  .htmlentities("A d�faut, nous les apporter � l'une des 2 permanences suivantes : Samedi 06 septembre et le mercredi 10 septembre
							  de 10h00 � 20h00 au forum des associations de Saint Lys (Salle de la Gravette). ",null,"ISO-8859-1",false)."<br/><br/>"
                              .htmlentities("Un carnet de vaccinations � jour et un certificat m�dical de moins de 3 mois attestant que %s peut bien 
                                            pratiquer l'activit� sont indispensables pour acc�der au bassin. ",null,"ISO-8859-1",false)."<br/><br/>"
		                      .htmlentities("Nous vous rappelons �galement que %s devra porter une couche ou un maillot anti-fuite 
                                            sp�cial piscine si il/elle n'est pas propre.",null,"ISO-8859-1",false)."<br/><br/>"
		                      .htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"ISO-8859-1",false)."<br/><br/>"
		                      .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false));
     
     // Message apr�s inscription sur le site via le compte admin
    // -------------------------------------------------------------------------	 
	define( "_SUJET_INSCRIPTION", htmlentities("[AQUA-BEBE] : Inscription de %s %s : Inscription enregistree ",null,"ISO-8859-1",false));
  	define( "_MESSAGE_INSCRIPTION_2", htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
                                    .htmlentities("Vous venez d'inscrire %s depuis notre site web. Cette pre-inscription a bien �t� 
                                                    enregistr�e.",null,"ISO-8859-1",false)."<br/>"
                                    .htmlentities("Vous devriez avoir �t� redirig� vers la page de paiement en ligne et avoir 
                                                  effectu� ce paiement. Si ce n'est pas le cas, vous pouvez contacter Florent 
                                                  (postmaster@aquabebe.fr) pour pouvoir d�bloquer votre inscription.",
                                                  null,"ISO-8859-1",false)."<br/>"
                                    .htmlentities("Si le paiement a �t� enregistr�, vous aller recevoir un message le confirmant.",
                                                  null,"ISO-8859-1",false)."<br/><br/>"
		                                .htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"ISO-8859-1",false)."<br/><br/>"
		                                .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false));
                                    
   // Message  envoy� par e-mail aux parents apr�s inscription sur le site
  // ---------------------------------------------------------------------------------------
	define( "_MESSAGE_INSCRIPTION_1", 	htmlentities("Bonjour",null,"ISO-8859-1",false)."<br/><br/>"
		                                .htmlentities("
											Vous venez de vous inscrire depuis notre site web. Cette pre-inscription a bien �t� 
                                            enregistr�e. Elle ne sera valid�e qu'apr�s r�ception du paiement et apr�s 
                                            attribution du cr�neau.
											",null,"ISO-8859-1",false)
										."<br/>"
		                                ."<u>".htmlentities("Nous devons recevoir vos ch�ques dans les 7 jours. ",null,"ISO-8859-1",false)."</u>"
										.htmlentities("
											Sans r�ception de votre paiement 
											dans les d�lais, votre place sera automatiquement lib�r�e par le serveur et attribu�e 
                                            � la personne suivante. 
											",null,"ISO-8859-1",false)
										."<br/>"."<br/>"
										.htmlentities("Les ch�ques doivent �tre �tablis � l'ordre de l'",null,"ISO-8859-1",false)
										."<strong>Association Aqua-Bebe </strong>"
										.htmlentities("et envoy�s � ",null,"ISO-8859-1",false)
										."<address>AQUA-BEBE<br/>chez Florence LUCIAN<br/>7, chemin du Mescurt<br/>31470 SAIGUEDE</address>"
										//."<address>AQUA-BEBE<br/>chez Marie-Aude Canet-Lhermitte<br/>1 rue Fr�d�ric Mistral<br/>31860 Labarthe-sur-Leze</address>"
										//."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
										//."<address>AQUA-BEBE<br/>chez Emilie Roux<br/>8 rue des alouettes<br/>31470 Saint Lys</address>"
										."<br/>"
		                                .htmlentities("
											Merci de noter le pr�nom et le nom de %s au dos des ch�ques. Le montant annuel du paiement  
                                            (cotisation + adh�sion) est de 200� pour un enfant et 360� pour 2 enfants.
                                            Le montant de l'adh�sion (20�) est � acquitter via un ch�que � part. 
											En cas de doute vous pouvez consulter la page Tarifs et/ou joindre Aqua-Bebe (contact@aquabebe.fr). 
											",null,"ISO-8859-1",false)
										."<br/><br/>"
										."<br/><br/>"
		                                .htmlentities("Alors, � bient�t, les pieds dans l'eau !",null,"ISO-8859-1",false)
										."<br/>"
		                                .htmlentities("L'�quipe Aqua-B�b�",null,"ISO-8859-1",false)
										);
		
	define( "_ENVOI_MESSAGE_OK", htmlentities("Un E-mail vous a �t� envoy�. Si vous ne l'avez pas re�u dans 24h, merci de contacter Florent 
                                            (postmaster@aquabebe.fr) afin de v�rifier votre adresse et de ne pas bloquer votre inscription.",
                                            null,"ISO-8859-1",false));
                                            
	define( "_ENVOI_MESSAGE_KO","<span class=\"complet\">".htmlentities("L'E-mail n'a pu vous �tre envoy�. Merci de contacter Florent 
                                                                      (postmaster@aquabebe.fr) afin de v�rifier votre adresse et de ne pas 
                                                                      bloquer votre inscription.",null,"ISO-8859-1",false)."</span>");
?>