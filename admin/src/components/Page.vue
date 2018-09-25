<template>
<div class="container">
<div>Modification des pages</div>
    <div v-if="waiting==true"> Chargement....</div>
    <div v-else>
        <div class="row mt-3">
            <label class="col-md-2">Accueil</label>
            <textarea class="form-control col-md-10" rows="20"  v-model="texte"></textarea>
        </div>
        <div class="row mt-3">
            <span class="col-md-4"></span>
            <button type="button" class="btn btn-primary col-md-2" v-on:click="sauver()">Sauver</button>
            <span class="col-md-2" />
            <button type="button" class="btn btn-primary col-md-2" v-on:click="annuler()">Annuler</button>
        </div>
    
    </div>
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Page',

  data () {
    return {
      waiting : true,
      texte: "",
      origtexte:"",
    }
  },

  created: function() {
      this.get()
  },
  
   methods:{
        get: function (){
            var api = new restapi();
            var self=this;
            api.getPage("accueil").then(response=>{
                self.texte=response;
                self.origtexte=response;
                self.waiting=false;
            })
        },

        sauver: function() {
            var api = new restapi();
            var data = new FormData();
            data.append("name","accueil");
            data.append("texte",this.texte);
            self=this;
            api.postPageUpdate(data).then(response=>{
                self.origtexte=self.texte;
            })
        },

        annuler: function() {
            this.texte=this.origtexte;
        }

    }

}
</script>

