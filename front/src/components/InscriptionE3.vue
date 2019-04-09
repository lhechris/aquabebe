<template>
  <div>
      <h2>etape 3:  Choix des créneaux </h2>  
      <p>Voici les créneaux auxquels vous pouvez inscrire votre enfant. Indiquez votre créneau préféré (1) puis, à défaut, les autres créneaux (2,3...).</p>
      <p>Si aucune autre demande n'a été validée avant que vous n'ayez terminé votre inscription et si votre créneau préféré a des places libres, alors une place sur ce créneau vous est réservée pendant 7 jours.</p>
      <p>Vous avez donc 7 jours au maximum pour nous faire parvenir votre règlement et confirmer votre inscription.</p>
      <p>Si votre créneau préféré comporte uniquement des places en attente de validation de paiement (en jaune), nous attendrons la fin du délai de 7 jours (attente max du paiement par autrui). Si au terme de ce délai, le règlement de l'autre personne ne nous est pas parvenu, vous remonterez dans la liste d'attente et la place pourra éventuellement vous être attribuée. En attendant, une place sur votre 2ème, 3ème... choix est réservée. </p>
      <p class="obligatoire" v-if="creneauok==false">Vous devez choisir au moins un creneau (1 dans une des case)</p>
      <div class="row forminscription" v-for="creneau of creneaux" v-bind:key="'creneau'+creneau.id">
        <div class="col-md-4">
          <input type="number" size="1" v-bind:name="creneau.inputname" v-model="creneau.inputval" />
        </div>
        <div class="col-md-4">{{creneau.name}} - {{creneau.lieu}}</div>
        <div class="col-md-4">({{creneau.inscrits}} inscrits sur {{creneau.capacite}})</div>
      </div>
      <div class="row forminscription">
        <div class="col-md-8">Pour valider l'inscription, le paiement intégral doit être parvenu à l'association dans les 7 jours suivant la validation de ce formulaire. Vous pouvez payer en deux ou plusieurs chèques.</div>
        <div class="cold-md-4"><span>Lu et accepté :&nbsp;*&nbsp;</span><span><input name="lu1" value="true" type="checkbox" /></span></div>
      </div>
      <div class="row forminscription">
        <div class="col-md-8">L'adhésion annuelle à l'association (20€) est à régler spécifiquement et uniquement pour le 1er enfant. La cotisation, elle, est calculée en fonction de la date d'inscription et du nombre d'enfants inscrits. Le montant à payer est indiqué dans la page Tarifs.</div>
        <div class="col-md-4">Lu : &nbsp;<input name="lu2" value="true" type="checkbox" /></div>
      </div>
      <div class="row forminscription">
          <div class="col-md-8">L'accès à la piscine n'est possible qu'après présentation du carnet de vaccination
                                    à jour, remise du règlement intérieur signé et remise d'un certificat 
                                    médical de moins de 3 mois attestant qu'il n'y a pas de contre-indication à la pratique de l'activité 
                                    pour l'enfant.</div>
          <div class="cold-md-4"><span>Lu et accepté :&nbsp;*&nbsp;</span><span><input name="lu3" value="true" type="checkbox" /></span></div>
      </div>
  </div>
</template>

<script>

export default {
  name: 'InscriptionE3',
  props : [
    naissance
  ],

  created : function() {
    this.get();
  },

  data () {
    return {
      creneaux :{}
    }
  },

  methods : {
    get:function() {
      var api = new restapi();
      var self=this;
      api.getCreneauxForNaissance(this.naissance).then(response=>{
        self.creneaux=response;
        var i;
        for (i in self.creneaux) {
          self.creneaux[i]["inputname"]="creneau_"+self.creneaux[i]["id"];
          self.creneaux[i]["inputval"]="";
          if (i==0) {self.creneaux[i]["inputval"]=1;} 
        }

    }
  }
}
</script>