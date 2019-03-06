<template>
<div class="container">
  <form>
    <div class="row"><span class="col-md-12">Ici on gère tout un tas de truc...</span></div>
    <div class="form-group row">
      <label for="saison" class="col-md-4">Saison courante</label>
      <input type="text" v-model="saison" class="form-control col-md-2">
      <button class="btn btn-primary col-md-2" v-on:click="updateSaison()">Modifier</button>
    </div>
  </form>
</div>
</template>

<script>

import {restapi} from '../rest' 

export default {
  name: 'Parametres',

  data () {
    return {
      saison:"",
    }
  },

  created : function() {
    this.get();
  },

   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        this.saison=api.getSaison().then(response=>{
          self.saison=response;
        })
      },

      updateSaison: function() {
        var api = new restapi();
        api.postSaison(this.saison);
      }
  }

}
</script>