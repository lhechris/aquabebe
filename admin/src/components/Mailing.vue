<template>
<div class="container">
<div>Email</div>
    <div v-if="reponse==null" class="form-group">
        <div class="row">
            <label class="col-md-2">Destinataires:</label>
            <select class="form-control col-md-6" v-model="creneauid">
                <option v-for="creneau of creneaux" v-bind:key="creneau.id" v-bind:value="creneau.id" >{{creneau.lieu}} - {{ creneau.jour}} - {{creneau.heure}}</option>
            </select>       
        </div>
        <div class="row">
            <label class="col-md-2">Message:</label>
            <textarea class="form-control col-md-8" rows="10"  v-model="texte"></textarea>
        </div>
        <div class="row">
            <input type="file" class="btn col-md-6" text="joindre"/>
            <button type="button" class="btn btn-primary col-md-1" v-on:click="envoyer()">Envoyer</button>
        </div>
    </div>
    <div v-else>
    <p>{{reponse}}</p>
    <button type="button" class="btn btn-primary" v-on:click="reponse=null">Retour</button>

    </div> 
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Email',

  data () {
    return {
      creneaux: {},
      creneauid:-1,
      texte:"",
      reponse:null
    }
  },

  created: function() {
      this.get()
  },
  
    methods:{
        get: function (){
            var api = new restapi();
            var self=this;
            api.getListCreneaux().then(response=>{
                self.creneaux=response;
            });
        },

        envoyer: function() {
            var api = new restapi();
            var data = new FormData();
            data.append("creneau",this.creneauid);
            data.append("text",this.texte);
            var self=this;
            api.postEmailCreneau(data).then(response=>{
                self.reponse=response
            });
        }

    }

}
</script>

