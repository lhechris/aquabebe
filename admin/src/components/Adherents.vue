<template>
<div class="container">
<div>Adhérents de la saison {{saison}}</div>
<table class="table table-responsive  table-striped">
  <thead>
  <tr><th>prénom</th><th>nom</th><th>naissance</th><th>creneau</th><th>montant</th><th>mois paiement</th></tr>
  </thead>
  <tbody>
  <tr v-for="pers of adherents" v-bind:key="pers.id">
    <td><router-link class="nav-link" v-bind:to="'/enfant/'+pers.id">{{pers.prenom}}</router-link></td>
    <td>{{pers.nom}}</td>
    <td>{{pers.naissance}}</td>
    <td>{{pers.creneau}}</td>
    <td>{{pers.paiementmontant}}</td>
    <td>{{pers.paiementmois}}</td>
  </tr>
  </tbody>
</table>
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Adherents',

  data () {
    return {
      adherents: {},
      saison:""
    }
  },

  created: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getAdherents().then(response=>{
          self.adherents=response;
        })
        api.getSaison().then(response=>{
          self.saison=response;
        })
    }
  }

}
</script>

