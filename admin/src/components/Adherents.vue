<template>
<div class="container">
<div><label>Adhérents de la saison</label>
  <select v-model="saison" v-on:change="changeSaison">
     <option v-for="s in saisons" v-bind:key="s" v-bind:value="s">{{s}}</option>
  </select>
</div>
<p v-if="error!=''">{{error}}</p>
<table v-else class="table table-responsive  table-striped">
  <thead>
  <tr><th>prénom</th><th>nom</th><th>naissance</th><th>creneau</th><th>Certificat</th><th>Vaccins</th><th>Facture</th></tr>
  </thead>
  <tbody>
  <tr v-for="pers of adherents" v-bind:key="pers.id">
    <td><router-link class="nav-link" v-bind:to="'/enfant/'+pers.id">{{pers.prenom}}</router-link></td>
    <td>{{pers.nom}}</td>
    <td>{{pers.naissance}}</td>
    <td>{{pers.creneau}}</td>
    <td><button class="btn btn-primary" v-on:click="certificat(pers.inscriptionid)" v-if="pers.certificat!=1">Déposer certificat</button><span v-else>Déposé</span></td>
    <td><button class="btn btn-primary" v-on:click="vaccins(pers.inscriptionid)" v-if="pers.vaccins!=1">Valider vaccins</button><span v-else>Validés</span></td>
    <td>
      <a class="glyphicon glyphicon-download" target="_blank" v-bind:href="'http://localhost/rest/facture/'+pers.id" />
      <button class="btn btn-primary" v-on:click="facture(pers.inscriptionid)" v-if="pers.facture!=1">Remettre facture</button>
      <span v-else>Remise</span>
    </td>
  </tr>
  </tbody>
</table>
<p v-if="waiting==true"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Chargement...</p>
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Adherents',

  data () {
    return {
      adherents: {},
      saisons: ["2014-2015","2015-2016","2016-2017","2017-2018","2018-2019"],
      saison:"",
      waiting:true,
      error:""
    }
  },

  created: function() {
        var api = new restapi();
        var self=this;
        api.getSaison().then(response=>{
          self.saison=response;
        });
        api.getAllSaison().then(response=>{
          self.saisons=response;
          self.get();
        });

  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        this.waiting=true;
        this.error="";
        api.getAdherents(this.saison).then(response=>{
          self.adherents=response;         
          self.waiting=false;
        }).catch(reason => {
          self.error=reason.response.data.message;
          self.waiting=false;
        })
    },

    certificat: function(id) {
        var api = new restapi();
        var self=this;
        api.postCertificat(id).then(response=>{
          self.get();
        })
    },

    vaccins:function(id) {
        var api = new restapi();
        var self=this;
        api.postVaccins(id).then(response=>{
          self.get();
        })
    },

    facture:function(id) {
        var api = new restapi();
        var self=this;
        api.postFacture(id).then(response=>{
          self.get();
        })
    },

    changeSaison:function() {
      this.get();
    }

  }

}
</script>

