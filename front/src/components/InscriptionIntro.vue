<template>
  <div>
    <h2>Vous souhaitez vous inscrire?</h2>
    <p><strong>Pour prendre en compte votre inscription il vous est demandé&nbsp;:</strong></p>
    <ul>
      <li>De remplir le formulaire d'inscription en ligne (ou le fomulaire papier à télécharger et nous renvoyer);
      </li>
      <li>De choisir les créneaux désirés dans l'ordre de préférence (<router-link to="/creneaux">voir les créneaux proposés</router-link>)</li>
      <li>De nous faire parvenir, sous une semaine, les documents administratifs signés ainsi que les chèques de cotisation.</li>
    </ul>
    <p><strong>Certificat médical :</strong></p>
    <p>Un certificat médical <strong>de moins de 3 mois </strong>indiquant que votre enfant peut pratiquer cette activité doit être fourni lors du <strong>premier accès </strong>au bassin.</p>
    <p><strong>Vaccinations :</strong></p>
    <p>Votre enfant doit être à jour de ses vaccinations. Une présentation du carnet de santé ou une photocopie des pages de vaccination sera nécessaire pour le <strong>premier accès </strong>au bassin.</p>
    <p><strong>Information sur les créneaux :</strong></p>
    <p>Lors de votre inscription, vous aurez à sélectionner les créneaux par ordre de préférence. Une place vous est automatiquement réservée dans le premier créneau préféré ayant une place libre. Cette affectation vous est réservée pendant 7 jours et sera confirmée lors de la réception du paiement. <br>Vous êtes également en liste d'atente sur les crénaux complets ayant une préférence plus élevée et, si une place se libère, vous serez repositionnés sur celui-ci.</p>
    <p><strong>Information sur les tarifs :</strong></p>
    <p>Si vous avez plusieurs enfants inscrits, le <router-link to="/tarifs">tarif est dégressif</router-link>. 
        N'ayant pas automatisé ce système, nous vous proposons de faire l'inscription de chaque enfant indépendamment et 
        de choisir le paiement par chèque. Vous ferez donc un chèque du montant approprié avec le nom de tous les enfants 
        au dos et l'enverrez comme indiqué dans la procédure. <br>En cas de doute sur le montant, vous pouvez nous contacter par 
        E-mail <img src="/images/contact-head.jpg" alt="adresse à recopier"><br>
        Calendrier de l'encaissement des chèques : voir <router-link to="/tarifs">ici</router-link>.
    </p> 
    <h2>Inscription : <button class="btn-info" v-on:click="$emit('suivant')">S'INSCRIRE</button></h2>
    <h2>Une question ? Un problème ?</h2>
    <ul>
      <li>Pour toute autre question, vous pouvez nous joindre : <img src="/images/contact-head.jpg" alt="adresse à recopier"></li>
    </ul>
    <p><strong><br>Que ce soit pour l'inscription ou pour toute communication en cours d'année, l'E-mail est la solution que l'association Aqua-Bébé utilise de manière privilégiée.</strong></p>
  </div>
</template>

<script>

export default {
  name: 'InscriptionIntro' 
}
</script>