<?php
	
  $prenom = "";
  if (isset($_POST['prenom']))
    {
      $prenom = $_POST['prenom'];
    }
	
	define( "_MSG_ERREUR_REQUIRED_VALUE", htmlentities("Ce champ doit être renseigné :",null,"utf-8",false));
	define( "_MSG_ERREUR_TEL",	htmlentities("Le numéro de téléphone doit être uniquement composé de 10 chiffres
											(ex. : 0534486897)",null,"utf-8",false));
	define( "_MSG_ERREUR_TEL_PORTABLE",	htmlentities("Le numéro de téléphone doit commencer par 06 ou 07.",null,"utf-8",false));
	define( "_MSG_ERREUR_MAIL",	htmlentities("L'adresse Email n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_MAIL_2",	htmlentities("Vous avez déjà répondu à la question. Pour modifier votre choix, 
                                              contactez-nous à l'adresse demenagement@aquabebe.fr",null,"utf-8",false));
	define( "_MSG_ERREUR_MAIL_3",	htmlentities("** Décision non enregistrée : Veuillez saisir l'adresse E-mail utilisée lors de l'inscription. 
                                              En cas de problème, vous pouvez contacter demenagement@aquabebe.fr en indiquant les valeurs 
                                              renseignées dans les champs.",null,"utf-8",false));
	define( "_MSG_ERREUR_CP",	htmlentities("Le code postal n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_CRENEAUX_1", htmlentities("Veuillez ne saisir que des chiffres de 1 à 9",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_2", htmlentities("Veuillez indiquer votre créneau préféré par un 1",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_3", htmlentities("Chaque chiffre ne doit être utilisé qu'une seule fois",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_CRENEAUX_4", htmlentities("Les chiffres doivent se suivrent en commençant par 1 puis 2...",null,"utf-8",false)."<br/>");
	define( "_MSG_ERREUR_DATE_1", htmlentities("La date doit être formé de chifres et de / (ex. : 01/09/2009)",null,"utf-8",false));
	define( "_MSG_ERREUR_DATE_2", htmlentities("La date saisie n'est pas valide",null,"utf-8",false));
	define( "_MSG_ERREUR_PAIEMENT", htmlentities("Vous devez choisir un moyen de paiement maintenant..",null, null,false));
	
  // Message affiché lors de l'étape 6 de l'inscription
  // ----------------------------------------------------------------
	define( "_PAIEMENT_PAR_CHEQUE", "<strong>".htmlentities("Je choisis de payer par chèque.",null,"utf-8",false)."</strong>"
									."<br/>"
									.htmlentities("
										Après avoir validé ce formulaire, le paiement intégral (participation + adhésion) devra parvenir 
										à l'association dans les 7 jours pour confirmer l'inscription de ".$prenom.". 
										",null,"utf-8",false)
									."<br/>"."<br/>"
									."
										Le montant annuel du paiement  
                                        (cotisation + adhésion) est 200€(180€ + 20€) pour un enfant et 360€ (340€ + 20€) pour 2 enfants.
                                        <p class=\"avertissement\">Le montant de l'adhésion de 20€ est à acquitter via un chèque à part.</p>
										"
									."<br/>"."<br/>"
									.htmlentities("
										Si vous faites une inscription en cours d'année, 
										merci de consulter la page Tarifs pour connaître le montant de l'inscription. 
										",null,"utf-8",false)
									."<br/>"
									.htmlentities("Si besoin, vous pouvez contacter AquaBébé ",null,"utf-8",false)
									."(<a href=\"mailto:contact@aquabebe.fr\">contact@aquabebe.fr</a>)"
									.htmlentities(" pour confirmer le montant de votre cotisation. ",null,"utf-8",false)
									."<br/>"."<br/>"
									.htmlentities("
										Les chèques sont à établir à l'ordre de AQUA-BEBE et à envoyer à 
										",null,"utf-8",false)
									  ."<address>AQUA-BEBE<br/>chez Florence Michel-Jerolon<br/>1 rue Berlioz<br/>31880 La Salvetat-Saint-Gilles</address>"
									//."<address>AQUA-BEBE<br/>chez Marie-Aude Canet-Lhermitte<br/>1 rue Frédéric Mistral<br/>31860 Labarthe-sur-Leze</address>"
									//."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
									//."<address>AQUA-BEBE<br/>chez Emilie Roux<br/>8 rue des alouettes<br/>31470 Saint Lys</address>"
									."<br/>"
									."<strong>".htmlentities("Important : ",null,"utf-8",false)."</strong>"
									.htmlentities("
										Un des chèques doit être de 20€, montant correspondant à l'adhésion annuelle à l'association.   
										Le détail des chèques à envoyer se trouve sur la page Tarifs.
										",null,"utf-8",false)  
									."<br/>"."<br/>"                                       
			);

		// Si jamais un jour on se lance dans le paiement via CB.
		// _________________________________________________________
	 define( "_PAIEMENT_PAR_CB", "<strong>".htmlentities("Paiement par CB non disponible.",null,"utf-8",false)."</strong>");
// AVANT v1.0 (i.e. pas dans www)
//             utilisation de getMontant() au lieu de %d : 
//              uniquement ".$prenom.", vous devez régler ".getMontant().".",null,"utf-8",false));
							
	define( "_INSCRIPTION_DEJA_ENREGISTREE", htmlentities("L'inscription de cet enfant a déjà été réalisée. En cas de doute 
                                                        ou de problème sur cette inscription, vous pouvez contacter Florent 
                                                        (postmaster@aquabebe.fr).",null,"utf-8",false));
                                                        
	define( "_INSCRIPTION_NON_ENREGISTREE", htmlentities("Une erreur s'est produite lors l'enregistrement de l'inscription. 
                                                        Vous pourrez essayer à nouveau dans quelques instants. Si le problème 
                                                        se reproduit, vous pouvez contacter Florent (postmaster@aquabebe.fr).",
                                                        null,"utf-8",false));

     // Message  envoyé par e-mail aux parents après validation des vaccins
    // ---------------------------------------------------------------------------------------      
	define( "_SUJET_VACCINS", htmlentities("[AQUA-BEBE] Inscription de %s %s : Vaccinations valideés",null,"utf-8",false));
  
	define( "_MESSAGE_VACCINS", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
                                .htmlentities("Nous venons d'enregistrer la validation du carnet de vaccinations de %s.",null,"utf-8",false)
                                ."<br/><br/>"
                                .htmlentities("Cordialement,",null,"utf-8",false)."<br/><br/>"
                                .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
								
      // Message  envoyé par e-mail aux parents après validation du certificat medical 
     // ---------------------------------------------------------------------------------------                
	define( "_SUJET_CERTIFICAT", htmlentities("[AQUA-BEBE] Inscription de %s %s : Certificat medical reçu",null,"utf-8",false));
  
	define( "_MESSAGE_CERTIFICAT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
                                .htmlentities("Nous venons d'enregistrer le certificat médical de %s qui pourra désormais 
                                                participer aux séances du créneau qui lui a été affecté 
                                                à l'inscription.",null,"utf-8",false)
                                ."<br/><br/>"
                                .htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
                                .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));

      // Message  envoyé par e-mail aux parents après réception du paiement
     // ---------------------------------------------------------------------------------------      
	define( "_SUJET_PAIEMENT", htmlentities("[AQUA-BEBE] Inscription de %s %s : Paiement reçu",null,"utf-8",false));
  
	define( "_MESSAGE_PAIEMENT", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("Nous vous remercions du paiement de votre cotisation pour l'inscription de %s aux 
                                            séances de bébé nageurs ou d'initiation à la nage avec Aqua-Bébé. Nous allons maintenant vérifier la disponibilité
                                            des créneaux demandés. ",null,"utf-8",false)."<br/>"
                              .htmlentities("Votre inscription sera confirmée si un créneau peut vous être attribué. 
                                            Si aucun créneau ne peut vous être attribué lors du début des séances, nous vous contacterons 
                                            pour aviser avec vous.",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("Les chèques seront encaissés après la première séance si vous confirmez votre inscription.",
                                             null,"utf-8",false)."<br/>"
                              .htmlentities("Le calendrier d'encaissement des chèques est indiqué sur notre site Web,  
                                              à la rubrique \"Inscrire un enfant\" - paragraphe \"Information sur les tarifs\" ",
                                              null,"utf-8",false)."<br/><br/>"
							  .htmlentities("Vous avez la possibilité d'envoyer toutes les pièces obligatoires (Règlement Intérieur et droits
							  à l'image signés, certificat médical de moins de 3 mois et la pages de vaccination du carnet de santé) par mail (à l'adresse contact@aquabebe.fr).",null,"utf-8",false)."<br/><br/>"
							  .htmlentities("A défaut, nous les apporter au forum des associations de Saint-Lys (le 8 septembre 2018).
								",null,"utf-8",false)."<br/><br/>"
                          .htmlentities("Un carnet de vaccinations à jour et un certificat médical de moins de 3 mois attestant que %s peut bien 
                                            pratiquer l'activité sont indispensables pour accéder au bassin. ",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("Cordialement,",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
							  
     // Message  envoyé par e-mail aux parents après validation du créneau
    // ---------------------------------------------------------------------------------------                           
	define( "_SUJET_CRENEAU", htmlentities("[AQUA-BEBE] : Inscription de %s %s => Creneau validé ",null,"utf-8",false));
  
	define( "_MESSAGE_CRENEAU", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("Nous sommes heureux de vous compter parmi nous. Vous pourrez donc venir avec %s le %s %s à %s.",
                                            null,"utf-8",false)."<br/>"
								.htmlentities("Si votre enfant est inscrit sur un créneau initiation à la natation, les créneaux sont de 30 min avec 20 min effectives dans l'eau. Les groupes sont constitués de 4 enfants et les parents reste en bord de bassin.",
                                            null,"utf-8",false)."<br/>"			
                              .htmlentities("Vous avez la possibilité d'envoyer toutes les pièces obligatoires (Règlement Intérieur et droits
							  à l'image signés, certificat médical de moins de 3 mois et la pages de vaccination du carnet de santé) par mail (à l'adresse contact@aquabebe.fr).",null,"utf-8",false)."<br/><br/>"
							  .htmlentities("A défaut, nous les apporter au forum des associations de Saint-Lys (le 8 septembre 2018.",null,"utf-8",false)."<br/><br/>"
                              .htmlentities("Un carnet de vaccinations à jour et un certificat médical de moins de 3 mois attestant que %s peut bien 
                                            pratiquer l'activité sont indispensables pour accéder au bassin. ",null,"utf-8",false)."<br/><br/>"
		                      .htmlentities("Nous vous rappelons également que %s devra porter une couche ou un maillot anti-fuite 
                                            spécial piscine si il/elle n'est pas propre.",null,"utf-8",false)."<br/><br/>"
		                      .htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		                      .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
     
     // Message après inscription sur le site via le compte admin
    // -------------------------------------------------------------------------	 
	define( "_SUJET_INSCRIPTION", htmlentities("[AQUA-BEBE] : Inscription de %s %s : Inscription enregistree ",null,"utf-8",false));
  	define( "_MESSAGE_INSCRIPTION_2", htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
                                    .htmlentities("Vous venez d'inscrire %s depuis notre site web. Cette pre-inscription a bien été 
                                                    enregistrée.",null,"utf-8",false)."<br/>"
                                    .htmlentities("Vous devriez avoir été redirigé vers la page de paiement en ligne et avoir 
                                                  effectué ce paiement. Si ce n'est pas le cas, vous pouvez contacter Florent 
                                                  (postmaster@aquabebe.fr) pour pouvoir débloquer votre inscription.",
                                                  null,"utf-8",false)."<br/>"
                                    .htmlentities("Si le paiement a été enregistré, vous aller recevoir un message le confirmant.",
                                                  null,"utf-8",false)."<br/><br/>"
		                                .htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)."<br/><br/>"
		                                .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false));
                                    
   // Message  envoyé par e-mail aux parents après inscription sur le site
  // ---------------------------------------------------------------------------------------
	define( "_MESSAGE_INSCRIPTION_1", 	htmlentities("Bonjour",null,"utf-8",false)."<br/><br/>"
		                                .htmlentities("
											Vous venez de vous inscrire depuis notre site web. Cette pre-inscription a bien été 
                                            enregistrée. Elle ne sera validée qu'après réception du paiement et après 
                                            attribution du créneau.
											",null,"utf-8",false)
										."<br/>"
		                                ."<u>".htmlentities("Nous devons recevoir vos chèques dans les 7 jours. ",null,"utf-8",false)."</u>"
										.htmlentities("
											Sans réception de votre paiement 
											dans les délais, votre place sera automatiquement libérée par le serveur et attribuée 
                                            à la personne suivante. 
											",null,"utf-8",false)
										."<br/>"."<br/>"
										.htmlentities("Les chèques doivent être établis à l'ordre de l'",null,"utf-8",false)
										."<strong>Association Aqua-Bebe </strong>"
										.htmlentities("et envoyés en courrier simple à ",null,"utf-8",false)
										."<address>AQUA-BEBE<br/>chez Florence Michel-Jerolon<br/>1 rue Berlioz<br/>31880 LA salvetat-Saint-Gilles</address>"
										//."<address>AQUA-BEBE<br/>chez Marie-Aude Canet-Lhermitte<br/>1 rue Frédéric Mistral<br/>31860 Labarthe-sur-Leze</address>"
										//."<address>AQUA-BEBE<br/>chez Jordane Berthou-Sarda<br/>115 rue Reguelongue<br/>31100 Toulouse</address>"
										//."<address>AQUA-BEBE<br/>chez Emilie Roux<br/>8 rue des alouettes<br/>31470 Saint Lys</address>"
										."<br/>"
		                                .htmlentities("
											Merci de noter le prénom et le nom de %s au dos des chèques. Le montant annuel du paiement  
                                            (cotisation + adhésion) est de 200€ (180€ + 20€) pour un enfant et 360€ (340€ + 20€) pour 2 enfants.
											Le montant de l'adhésion (20€) est à acquitter via un chèque à part. La cotisation est à payer en 1 à 3 chèques. ",null,"utf-8",false)
											."<br/>"	
											.htmlentities("En cas de doute vous pouvez consulter la page Tarifs et/ou joindre Aqua-Bebe (contact@aquabebe.fr). 
											",null,"utf-8",false)
										."<br/><br/>"
										."<br/><br/>"
		                                .htmlentities("Alors, à bientôt, les pieds dans l'eau !",null,"utf-8",false)
										."<br/>"
		                                .htmlentities("L'équipe Aqua-Bébé",null,"utf-8",false)
										);
		
	define( "_ENVOI_MESSAGE_OK", htmlentities("Un E-mail vous a été envoyé. Si vous ne l'avez pas reçu dans 24h, merci de contacter Marie-Aude 
                                            (postmaster@aquabebe.fr) afin de vérifier votre adresse et de ne pas bloquer votre inscription.",
                                            null,"utf-8",false));
                                            
	define( "_ENVOI_MESSAGE_KO","<span class=\"complet\">".htmlentities("L'E-mail n'a pu vous être envoyé. Merci de contacter Marie-Aude 
                                                                      (postmaster@aquabebe.fr) afin de vérifier votre adresse et de ne pas 
                                                                      bloquer votre inscription.",null,"utf-8",false)."</span>");
?>
