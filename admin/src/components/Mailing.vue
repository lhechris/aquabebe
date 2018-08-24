<template>
<div class="container">
    <div>Email</div>

    <!--<div id="myModal" class="modal fade hide" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <button class="btn btn-lg btn-info"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Envoi en cours ...</button>
            </div>
            </div>
        </div>
    </div>-->

    <div v-if="reponse==null" class="form-group">
        <div class="row mt-3">
            <label class="col-md-2">Destinataires:</label>
            <select class="form-control col-md-6" v-model="creneauid">
                <option v-for="creneau of creneaux" v-bind:key="creneau.id" v-bind:value="creneau.id" >{{creneau.lieu}} - {{ creneau.jour}} - {{creneau.heure}}</option>
            </select>       
        </div>
        <div class="row mt-3">
            <label class="col-md-2">Sujet:</label>
            <input type="text" class="form-control col-md-8"  v-model="sujet" />
        </div>
        <div class="row mt-3">
            <label class="col-md-2">Message:</label>
            <textarea class="form-control col-md-8" rows="10"  v-model="texte"></textarea>
        </div>
        <div class="row mt-3">
            <UploadFile class="col-md-12" v-model="files" />
        </div>
        <div class="row mt-3">
            <span class="col-md-5"></span>
            <button type="button" class="btn btn-primary col-md-2" v-on:click="envoyer()">Envoyer</button>
            <span class="col-md-5" />
        </div>
    </div>
    <div v-else-if="reponse=='waiting'">
        <button class="btn btn-lg btn-info"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Envoi en cours ...</button>
    </div> 
    <div v-else>
        <p>{{reponse}}</p>
        <button type="button" class="btn btn-primary" v-on:click="reponse=null">Retour</button>
    </div> 
</div>
</template>

<script>

import {restapi} from '../rest' 
import UploadFile from './UploadFile.vue'

export default {
  name: 'Mailing',
  components : {UploadFile},

  data () {
    return {
      creneaux: {},
      creneauid:-1,
      texte:"",
      sujet:"",
      reponse:null,
      files:[]
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
            data.append("texte",this.texte);
            data.append("sujet",this.sujet);
            
            for( var i = 0; i < this.files.length; i++ ){
                let file = this.files[i];
                data.append('files[' + i + ']', file);
            }            
            var self=this;
            this.reponse='waiting';
            //$("#myModal").modal('show');
            api.postEmailCreneau(data).then(response=>{
                self.reponse=response;
                //$("#myModal").modal('hide');
            });
        }

    }

}
</script>

<style>
.glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>