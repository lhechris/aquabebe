<template>
<div class="container">
<div>Adhérents de la saison {{saison}}</div>
<table class="table table-responsive  table-striped">
  <thead>
  <tr><th>prénom</th><th>nom</th><th>naissance</th><th>creneau</th><th>inscription</th><th>choix</th><th>reservation</th></tr>
  </thead>
  <tbody>
  <tr v-for="pers of adherents" v-bind:key="pers.id">
    <td>{{pers.prenom}}</td>
    <td>{{pers.nom}}</td>
    <td>{{pers.naissance}}</td>
    <td>{{pers.creneau}}</td>
    <td>{{pers.inscriptionid}}</td>
    <td>{{pers.choix}}</td>
    <td>{{pers.reservation}}</td>
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

