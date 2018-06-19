<template>
<div class="container">
<h2>QUESTIONS / REPONSES</h2>
<p><strong>Quel est le montant des inscriptions ?</strong></p><p>Le montant des inscriptions peut se consulter : <router-link to="/tarifs">ici</router-link><br/>Pensez &agrave; noter le pr&eacute;nom et le nom de vos enfants au dos des ch&egrave;ques. 
                                      Le montant de l'adh&eacute;sion (20&euro;) est &agrave; acquitter via un ch&egrave;que &agrave; part.</p><br/>
<p><strong>A quelle adresse envoyer les cheques ?</strong></p><p>L'adresse est indiqu&eacute;e durant l'inscription en ligne. 
                                    Elle est rappell&eacute;e dans l'e-mail envoy&eacute; &agrave; la fin de l'inscription.Elle est a envoy&eacute; en courrier simple.</p><br/>
<p><strong>Qui accompagne l'enfant : un parent uniquement ou est-ce possible &agrave; deux parents ?</strong></p><p>Normalement, un seul parent peut accompagner l'enfant dans l'eau. L'autre parent 
                                    peut rester dans le local, en dehors du bassin. Exceptionnellement, quand le 
                                    cr&eacute;neau n'est pas rempli, les 2 parents peuvent aller dans l'eau. C'est pour permettre aux autres parents du groupe qui souhaiteraient aller dans l'eau, qu'il vous est demand&eacute; de pr&eacute;venir le MNS de votre absence <br/>Dans le cas d'une fratrie de 2 enfants, 2 adultes DOIVENT &ecirc;tre pr&eacute;sents dans l'eau.</p><br/>
<p><strong>Est-il possible de visiter les lieux dans la semaine ?</strong></p><p>Il n'est pas possible de visiter les locaux avant la premi&egrave;re s&eacute;ance.  
                                    Celle ci est une s&eacute;ance d'essai. Elle vous permet de vous faire une id&eacute;e des lieux
									et de l'activit&eacute;.</p><br/>
<p><strong>S'agit-il d'une activit&eacute; hebdomadaire, peut-on changer de cr&eacute;neau selon son propre planning ?</strong></p><p>Le cr&eacute;neau est attribu&eacute; pour l'ann&eacute;e. Il n'est pas possible de changer de jour,
									ni d'horaire.</p><br/>
<p><strong>En quoi consistent les activit&eacute;s pour les b&eacute;b&eacute;s de quelques mois ?</strong></p><p>Merci de lire notre <router-link to="/home">page d'accueil </router-link>, et de venir &agrave; la premi&egrave;re s&eacute;ance d'essai afin de vous faire une id&eacute;e, 
                                    de discuter avec le ma&icirc;tre nageur et avec les autres parents.</p><br/>
<p><strong>Comment peut-on faire une s&eacute;ance d'essai ?</strong></p><p>Il vous faut tout d'abord inscrire votre enfant. Pour ceci, il vous faut aller <router-link to="/inscription">ici</router-link> puis cliquer sur "S'INSCRIRE" situ&eacute; en bas de la page. Ensuite, il vous suffit de suivre les &eacute;tapes du formulaire 
									pour r&eacute;aliser la pr&eacute;-inscription.<br/>Apr&egrave;s r&eacute;ception et traitement de votre r&egrave;glement, nous vous indiquerons si le cr&eacute;neau souhait&eacute; a pu vous &ecirc;tre attribu&eacute; 
									ou si vous &ecirc;tes en liste d'attente.<br/>Lors de la s&eacute;ance d'essai, vous &ecirc;tes accueillis par un membre du Conseil d'Administration de l'association afin de vous 
									pr&eacute;senter le fonctionnement d'Aqua-B&eacute;b&eacute; 
									et pour r&eacute;gler les questions administratives.<br/><br/>Bien qu'il soit pr&eacute;f&eacute;rable de nous faire parvenir les documents d'inscription par mail, surtout n'oubliez pas, &agrave; d&eacute;faut, de venir avec :<br/>- le carnet de sant&eacute; de votre enfant pour que nous v&eacute;rifions les vaccins, <br/>- le certificat m&eacute;dical autorisant l'activit&eacute; de b&eacute;b&eacute; nageur, et<br/>- le r&egrave;glement int&eacute;rieur sign&eacute;.<br/>Sans ces documents, nous ne pourrons vous laisser acc&eacute;der au bassin. <br/>Si vous d&eacute;cidez de ne pas continuer l'activit&eacute; &agrave; l'issue de la s&eacute;ance d'essai, vos ch&egrave;ques vous seront restitu&eacute;s. </p><br/>
<p><strong>Puis-je avoir une facture ?</strong></p><p>Sur votre demande, une facture peut vous &ecirc;tre adress&eacute;e une fois l'adh&eacute;sion de votre enfant devenue p&eacute;r&eacute;ne, apr&egrave;s la seconde s&eacute;ance.</p><br/>
<p><strong>Pourquoi tous les cr&eacute;neaux n'ont-ils pas le m&ecirc;me nombre de places</strong></p><p>La piscine du centre de Saint-Lys est grande et peut accueillir jusqu'&agrave; 8 enfants et adultes.La piscine du centre Bouscairol est plus petite. Avec des petits (moins de 18 mois) elle peut accueillir jusqu' &agrave; 5 enfants et leur accompagnant. Avec des plus grands elle ne peut accueillir que 4 enfants et parents.</p><br/>

</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Faq',
  components: {
      MainLayout
  }

}
</script>
