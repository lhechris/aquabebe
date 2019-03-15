<template>
<div class="container">
<div>Modification des pages</div>
    <div v-if="waiting==true"> Chargement....</div>
    <div v-else>
        <div class="row mt-3">
            <span class="col-md-5"></span>
            <select v-model="page" v-on:change="refresh()" class="col-md-2" >
                <option v-for="p in pages" v-bind:key="p" v-bind:value="p">{{p}}</option>
            </select>
            <span class="col-md-5"></span>
        </div>
        <div class="row mt-3">
            <textarea class="form-control col-md-10" rows="20"  v-model="texte" style="font-size:14px"></textarea>
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
      page:"",
      pages:[]
    }
  },

  created: function() {
      this.get()
  },
  
   methods:{
        get: function (){
            var api = new restapi();
            var self=this;
            api.getListPages().then(response=>{
                self.pages=response;
                self.page=self.pages[0];
                self.refresh();
            })
        },

        refresh: function() {
            var api = new restapi();
            var self=this;
            self.waiting=true;
            api.getPage(this.page).then(response=>{
                self.texte=response;
                self.origtexte=response;
                self.waiting=false;
            })            
        },

        sauver: function() {
            var api = new restapi();
            var data = new FormData();
            data.append("name",this.page);
            data.append("texte",this.texte);
            var self=this;
            api.postPageUpdate(data).then(()=>{
                self.origtexte=self.texte;
            })
        },

        annuler: function() {
            this.texte=this.origtexte;
        },

    }

}
</script>

