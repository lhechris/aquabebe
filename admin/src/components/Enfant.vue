<template>
<div class="container">
  <p v-if="error!=''">{{error}}</p>
  <p v-else-if="loading==true"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Chargement...</p>
  <div v-else>
    <div class="encadre row col-md-12">
      <div class="encadretitre row col-md-12"><span class="col-md-12">Identité</span></div>
      <div v-if="edit" class="form-group row encadrebody col-md-12">
          <input type="text" class="form-control col-md-1" name="prenom" v-model="enfant.prenom" >
          <input type="text" class="form-control col-md-1" name="nom" v-model="enfant.nom" >
          <input type="text" class="form-control col-md-1" name="naissance" v-model="enfant.naissance" >
          <span class="col-md-1">Téléphone:</span>
          <input type="text" class="form-control col-md-1" name="telephone" v-model="enfant.telephone" >
          <span class="col-md-1">Adresse:</span>
          <input type="text" class="form-control col-md-2" name="adresse" v-model="enfant.adresse" >
          <input type="text" class="form-control col-md-1" name="cp" v-model="enfant.cp" >
          <input type="text" class="form-control col-md-2" name="commune" v-model="enfant.commune" >
      </div>
      <div v-else class="form-group row encadrebody col-md-12">
        <span class="col-md-4">{{enfant.prenom}} {{enfant.nom}} né le {{enfant.naissance}}</span>
        <span class="col-md-2">Téléphone:{{enfant.telephone}}</span>
        <span class="col-md-6">Adresse:{{enfant.adresse}} {{enfant.cp}} {{enfant.commune}}</span>
      </div>
    </div>
    <div class="row encadre col-md-12">
      <div class="row encadretitre col-md-12">
        <span class="col-md-10">Creneau</span><span class="col-md-1">choix</span><span class="col-md-1">Reservation</span>
      </div>
      <div class="row encadrebody col-md-12">       
          <div class="col-md-12 row" v-for="preinscr of enfant.preinscriptions" v-bind:key="preinscr.choix">
                <span class="col-md-10">{{preinscr.creneau}}</span>
                <span class="col-md-1">{{preinscr.choix}}</span>
                <span class="col-md-1" v-if="editreservation"><input name="reservation" type="radio" v-bind:value="preinscr.creneauid" v-model="creneauselected" /></span>  
                <span class="col-md-1" v-else>{{preinscr.reservation}}</span>  
          </div>
      </div>
    </div>
    <div class="row encadre col-md-12">
      <div class="encadretitre row col-md-12"><span class="col-md-4" /><span class="col-md-4">Parents</span><span class="col-md-4" /></div>
      <div class="encadrebody row col-md-12">
        <div v-for="parent of enfant.parents" v-bind:key="parent.id" class="col-md-12 row">
          <span class="col-md-6">{{parent.prenom}}</span>
          <span class="col-md-6">{{parent.nom}}</span>
        </div>
      </div>
    </div>

    <div class="row encadre col-md-12">
      <div class="row encadretitre col-md-12">
        <span class="col-md-2">date max</span><span class="col-md-2">date paiement</span><span class="col-md-2">certificat medical</span><span class="col-md-2">vaccins</span><span class="col-md-2">facture</span>
      </div>
      <div class="row encadrebody col-md-12">
        <span class="col-md-2">{{enfant.datemax}}</span>  
        <span class="col-md-2">{{enfant.paiementdate}}</span>  
        <span class="col-md-2"><button class="btn btn-primary" v-on:click="certificat(enfant.inscriptionid)" v-if="enfant.certificat_medical!=1">Déposer certificat</button><span v-else>Déposé</span></span>
        <span class="col-md-2"><button class="btn btn-primary" v-on:click="vaccins(enfant.inscriptionid)" v-if="enfant.vaccins!=1">Valider vaccins</button><span v-else>Validés</span></span>
        <span class="col-md-2">
          <a class="glyphicon glyphicon-download" target="_blank" v-bind:href="'/rest/facture/'+enfant.id" />
          <button class="btn btn-primary" v-on:click="facture(enfant.inscriptionid)" v-if="enfant.facture_remise!=1">Remettre facture</button><span v-else>Remise</span>
        </span>
      </div>
    </div>
    <div class="row encadre col-md-12">
      <div class="row encadretitre col-md-12" v:if="enfant">
        <span class="col-md-2">payeur</span><span class="col-md-2">montant</span><span class="col-md-2">mois</span><span class="col-md-2">moyen</span><span class="col-md-4">remarques</span>
      </div>
      <div v-if="edit" class="row encadrebody col-md-12 form-group">            
              <span class="col-md-2"><input type="text" class="form-control" name="payeur" v-model="enfant.payeur" ></span>  
              <span class="col-md-2"><input type="text" class="form-control" name="montant" v-model="enfant.montant" ></span>  
              <span class="col-md-2"><input type="text" class="form-control" name="mois" v-model="enfant.mois" ></span>  
              <span class="col-md-2"><input type="text" class="form-control" name="moyen" v-model="enfant.moyen" ></span>  
              <span class="col-md-4"><input type="text" class="form-control" name="remarques" v-model="enfant.remarques"></span>  
      </div>
      <div v-else class="row encadrebody col-md-12">
              <span class="col-md-2">{{enfant.payeur}}</span>  
              <span class="col-md-2">{{enfant.montant}}</span>  
              <span class="col-md-2">{{enfant.mois}}</span>  
              <span class="col-md-2">{{enfant.moyen}}</span>  
              <span class="col-md-4">{{enfant.remarques}}</span>  
      </div>
    </div>
    <div class="row">
        <div v-if="edit" class="col-md-12 row">
          <div class="col-md-4" />
          <button  class="btn btn-primary col-md-1" v-on:click="annuler()" >Annuler</button>
          <div class="col-md-1" />
          <button  class="btn btn-primary col-md-1" v-on:click="sauver()"  >Sauver</button>
          <div class="col-md-4" />
        </div>
        <div v-else class="col-md-12 row">
          <div class="col-md-5" />
          <button  class="btn btn-primary col-md-1" v-on:click="editable(true)">Modifier</button>
          <div class="col-md-5" />
        </div>
    </div>
  </div>
</div>
</template>

<style scoped>
.encadre {
  border: 5px solid rgba(113,183,244,0.8);
  border-radius:10px;
  padding:10px 0px 0em 0px;
  margin:0px 0px 1em 0px;
}
.encadrebody {
  background : linear-gradient( to right,rgba(113,183,244,0.8), rgba(255,128,128,0.3));
  /*border-radius : 10px;*/
  margin:auto;
  padding : 0px;
}
.encadretitre {
  font-weight: bold;
}
</style>


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
      error:''
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
        this.loading=true;
        this.error='';
        api.getEnfant(this.id).then(response=>{
          self.enfant=response;
          self.creneauselected=-1;
          for (let i=0;i<self.enfant.preinscriptions.length;i++) {
            if (self.enfant.preinscriptions[i].reservation==1) {
              self.creneauselected=self.enfant.preinscriptions[i].creneauid;
            }
          }
          self.loading=false;
        }).catch(reason=>{
          self.error=reason.response.data.message;
          self.loading=false;
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
        data.append("telephone",this.enfant.telephone);
        data.append("cp",this.enfant.cp);
        data.append("commune",this.enfant.commune);
        data.append("paiementid",this.enfant.paiementid);
        data.append("payeur",this.enfant.payeur);
        data.append("montant",this.enfant.montant);
        data.append("mois",this.enfant.mois);
        data.append("moyen",this.enfant.moyen);
        data.append("remarques",this.enfant.remarques);
        data.append("creneauselected",this.creneauselected);
        api.postEnfant(data).then(()=> {
          self.get();
        });

      },
      certificat: function(id) {
          var api = new restapi();
          var self=this;
          api.postCertificat(id).then(()=>{
            self.get();
          })
      },

      vaccins:function(id) {
          var api = new restapi();
          var self=this;
          api.postVaccins(id).then(()=>{
            self.get();
          })
      },

      facture:function(id) {
          var api = new restapi();
          var self=this;
          api.postFacture(id).then(()=>{
            self.get();
          })
      },      

  }

}
</script>

