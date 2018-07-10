<template>
<div class="container">
<div>Adhérents de la saison 2017 2018</div>
<table>
  <tr><th>prénom</th><th>nom</th><th>naissance</th><th>creneau</th><th>inscription</th><th>choix</th><th>reservation</th></tr>
  <tr v-for="pers of adherents" v-bind:key="pers.id">
    <td>{{pers.prenom}}</td>
    <td>{{pers.nom}}</td>
    <td>{{pers.naissance}}</td>
    <td>{{pers.creneau}}</td>
    <td>{{pers.inscriptionid}}</td>
    <td>{{pers.choix}}</td>
    <td>{{pers.reservation}}</td>
  </tr>
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
      enfants:{}
    }
  },

  created: function() {
      this.get()
  },
  
   methods:{
      actionclick: function(id) {
        this.enfants=id;
      },
      get: function (){
        var api = new restapi();
        var self=this;
        api.getAdherents().then(response=>{
          self.adherents=response;
        })
    }
  }

}
</script>

