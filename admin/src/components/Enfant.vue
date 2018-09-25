<template>
<div class="container">
  <div v-if="loading" >Loading...</div>
  <div v-else>
    <table class="table table-bordered table-hover">
      <tbody>
        <tr v-if="edit" class="form-group ">            
          <td>
            <input type="text" class="form-control" name="prenom" v-model="enfant.prenom" >  
            <input type="text" class="form-control" name="nom" v-model="enfant.nom" >
            <input type="text" class="form-control" name="naissance" v-model="enfant.naissance" >
          </td>
          <td>
            <input type="text" class="form-control" name="telephone" v-model="enfant.telephone" >
          </td>
          <td>
            Adresse : <input type="text" class="form-control" name="adresse" v-model="enfant.adresse" >
            <input type="text" class="form-control" name="cp" v-model="enfant.cp" >
            <input type="text" class="form-control" name="commune" v-model="enfant.commune" >
          </td>
        </tr>
        <tr v-else>
          <td>{{enfant.prenom}} {{enfant.nom}} né le {{enfant.naissance}}</td>
          <td>{{enfant.telephone}}</td>
          <td>Adresse : {{enfant.adresse}} {{enfant.cp}} {{enfant.commune}}</td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-hover">
      <thead>
        <tr><th>creneau</th><th>choix</th><th>reservation</th></tr></thead>
      <tbody>
        <tr v-for="preinscr of enfant.preinscriptions" v-bind:key="preinscr.choix">
            <td>{{preinscr.creneau}}</td>
            <td>{{preinscr.choix}}</td>
            <td v-if="editreservation"><input name="reservation" type="radio" v-bind:value="preinscr.creneauid" v-model="creneauselected" /></td>  
            <td v-else>{{preinscr.reservation}}</td>  
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
        <tr><th>date max</th><th>date paiement</th><th>vaccins</th></tr>
      </thead>
      <tbody>
        <tr>
            <td>{{enfant.datemax}}</td>  
            <td>{{enfant.paiementdate}}</td>  
            <td>{{enfant.vaccins}}</td>  
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-hover" v:if="enfant">
      <thead>
        <tr><th>payeur</th><th>montant</th><th>mois</th><th>moyen</th><th>remarques</th></tr>
      </thead>
      <tbody>
        <tr v-if="edit" class="form-group ">            
            <td><input type="text" class="form-control" name="payeur" v-model="enfant.payeur" ></td>  
            <td><input type="text" class="form-control" name="montant" v-model="enfant.montant" ></td>  
            <td><input type="text" class="form-control" name="mois" v-model="enfant.mois" ></td>  
            <td><input type="text" class="form-control" name="moyen" v-model="enfant.moyen" ></td>  
            <td><input type="text" class="form-control" name="remarques" v-model="enfant.remarques"></td>  
        </tr>
        <tr v-else>
            <td>{{enfant.payeur}}</td>  
            <td>{{enfant.montant}}</td>  
            <td>{{enfant.mois}}</td>  
            <td>{{enfant.moyen}}</td>  
            <td>{{enfant.remarques}}</td>  
        </tr>
      </tbody>
    </table>
    <button  class="btn" v-on:click="annuler()" v-if="edit" >Annuler</button>
    <button  class="btn" v-on:click="sauver()" v-if="edit" >Sauver</button>
    <button  class="btn" v-on:click="editable(true)" v-else>Modifier</button>
  </div>
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
      creneauselected:-1,
      edit:false,
      editreservation:false,
      loading:true,
    }
  },

  created: function() {
      this.loading=true;
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getEnfant(this.id).then(response=>{
          self.enfant=response;
          self.creneauselected=-1;
          for (let i=0;i<self.enfant.preinscriptions.length;i++) {
            if (self.enfant.preinscriptions[i].reservation==1) {
              self.creneauselected=self.enfant.preinscriptions[i].creneauid;
            }
          }
          this.loading=false;
        })
        api.getSaison().then(response=>{
          self.saison=response;
        })
      },

      editable: function(v) {
        this.edit=v;
        this.editreservation=this.creneauselected==-1;
      },

      annuler : function() {
        this.edit=false;        
        this.get();
      },

      sauver: function() {
        this.edit=false;
        this.editreservation=false;
        var api = new restapi();
        var data = new FormData();
        data.append("id",this.enfant.id);
        data.append("nom",this.enfant.nom);
        data.append("prenom",this.enfant.prenom);
        data.append("naissance",this.enfant.naissance);
        data.append("adresse",this.enfant.adresse);
        data.append("cp",this.enfant.cp);
        data.append("commune",this.enfant.commune);
        data.append("paiementid",this.enfant.id);
        data.append("payeur",this.enfant.payeur);
        data.append("montant",this.enfant.montant);
        data.append("mois",this.enfant.mois);
        data.append("moyen",this.enfant.moyen);
        data.append("remarques",this.enfant.remarques);
        data.append("creneauselected",this.creneauselected);
        api.postEnfant(data).then(()=> {
          self.get();
        });

      }

  }

}
</script>