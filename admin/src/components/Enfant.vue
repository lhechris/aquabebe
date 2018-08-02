<template>
<div class="container">
<div>{{enfant.prenom}} {{enfant.nom}} né le {{enfant.naissance}}</div>
<div>{{enfant.telephone}}</div>
<div>Adresse : {{enfant.adresse}} {{enfant.cp}} {{enfant.commune}}</div>
<table class="table table-bordered table-hover">
  <thead>
    <tr><th>creneau</th><th>choix</th><th>reservation</th></tr></thead>
  <tbody>
    <tr v-for="preinscr of enfant.preinscriptions" v-bind:key="preinscr.creneau">
        <td>{{preinscr.creneau}}</td>
        <td>{{preinscr.choix}}</td>
        <td>{{preinscr.reservation}}</td>  
    </tr>
  </tbody>
</table>
<table class="table table-bordered table-hover">
  <thead><tr><th colspan="2">Parents</th></tr></thead>
  <tbody>
    <tr v-for="parent of enfant.parents" v-bind:key="parent.id">
      <td>{{parent.prenom}}</td>
      <td>{{parent.nom}}</td>
    </tr>
  </tbody>
</table >
<table class="table table-bordered table-hover">
  <thead>
    <tr><th>date max</th><th>paiement</th><th>date paiement</th><th>vaccins</th></tr>
  </thead>
  <tbody>
    <tr>
        <td>{{enfant.datemax}}</td>  
        <td>{{enfant.paiement}}</td>  
        <td>{{enfant.paiementdate}}</td>  
        <td>{{enfant.vaccins}}</td>  
    </tr>
  </tbody>
</table>
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Enfant',
  props:['id'],

  data () {
    return {
      enfant: {},
    }
  },

  created: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getEnfant(this.id).then(response=>{
          self.enfant=response;
        })
        api.getSaison().then(response=>{
          self.saison=response;
        })
    }
  }

}
</script>