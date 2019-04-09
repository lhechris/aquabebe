<template>
  <div>
      <h2>Inscription {{saison}} </h2>
      <ul>
        <!--<li>Nous sommes complets pour la saison. La page créneaux vous indiquera si des places se libèrent.</li>-->
        <li><strong>Inscription en ligne : <button class="btn-info" v-on:click="$emit('suivant')">DEMARRER</button></strong>
          <br><strong>Créneaux fratrie</strong>: Ces créneaux sont réservés aux fratries. Ne peuvent s'y inscrire que 2 (ou plus) enfants étant frères et/ou soeurs. Dans ce cas il faut être 2 (ou plus) accompagnants dans l'eau (un par enfant).
          <br><strong>Attention, vous devez faire indépendamment l'inscription pour chaque enfant de la fratrie.</strong>
            <br> Note : A la fin de l'inscription, vous recevez un e-mail indiquant que votre inscription a été prise en compte.
        </li>      
        <li>Inscription par courrier : Contactez Aqua-Bébé        
        <!--<li>Inscription par courrier : Imprimez et complétez
            <a href="dossier_inscription_2013-2014.pdf" onclick="javascript:window.open(this.href);return(false);">le formulaire d'inscription</a>
            et renvoyez-le-nous accompagné du règlement complet à l'adresse indiquée.</li>-->            
      </li></ul>
      <h2>Une question ? Un problème ?</h2>
      <ul>
        <li>Pour tout problème technique lors de l'inscription :<br>
          * contactez <img src="/images/contact-head.jpg" alt="adresse à recopier"> et<br>
          * envoyez en parallèle votre dossier d'inscription par la poste avec votre règlement.
        </li>
          <li>Pour toute autre question, vous pouvez nous joindre à : <img src="/images/contact-head.jpg" alt="adresse à recopier"></li>
      </ul>
      <p><strong><br>Que ce soit pour l'inscription ou pour toute communication en cours d'année, l'E-mail est la solution 
                que l'association Aqua-Bébé utilise de manière privilégiée.</strong></p>  
  </div>
</template>

<script>

export default {
  name: 'InscriptionE0' ,
  props:{
    saison:''
  }
}
</script>