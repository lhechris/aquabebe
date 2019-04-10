<template>
<div class="container">
  <form>
    <!--<div class="row"><span class="col-md-12">Ici on gère tout un tas de truc...</span></div>
    <div class="form-group row abform">
      <label for="saison" class="col-md-4">Saison courante</label>
      <input type="text" v-model="saison" class="form-control col-md-1">
      <div class="col-md-2"/>
      <button class="btn btn-primary col-md-1" v-on:click="updateSaison()">Modifier</button>
      <div class="col-md-2"/>
    </div>-->
    <table class="table table-responsive  table-striped">
      <tbody>
        <tr class="abform">
          <td>Saison courante</td>
          <td><input type="text" v-model="saison" v-on:change="saisonsaved=false"></td>
          <td><div v-if="saisonsaved" class="glyphicon glyphicon-ok"></div></td>
          <td><button class="btn btn-primary" v-on:click="updateSaison()">Modifier</button></td>
        </tr>
        <tr class="abform">
          <td>Bloquer l'inscription</td>          
          <td><ToggleButton :value="lockInsc" :sync="true" :labels="{checked: 'Oui', unchecked: 'Non'}" @change="lockInscription" /></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="abform" v-if="lockInsc==true">
          <td>Mot de passe de déblocage</td>          
          <td><input type="text" v-model="passunlockinsc" ></td>
          <td><div v-if="passwdsaved" class="glyphicon glyphicon-ok"></div></td>
          <td><button class="btn btn-primary" v-on:click="updatePassUnlockInsc()">Modifier</button></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
</template>

<script>

import {restapi} from '../rest' 
import { ToggleButton } from 'vue-js-toggle-button'

export default {
  name: 'Parametres',

  components: {ToggleButton},

  data () {
    return {
      saison:"",
      saisonsaved:false,
      lockInsc:false,
      passunlockinsc:"",
      passwdsaved:false,
    }
  },

  created : function() {
    this.get();
  },

   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getSaison().then(response=>{
          self.saison=response;
        }) 
        api.getLockInscription().then(response=>{
          self.lockInsc=response["islock"]=="true";
          self.passunlockinsc=response["passwd"];
        })       
      },

      updateSaison: function() {
        var api = new restapi();
        var self=this;
        api.postSaison(this.saison).then(()=>{
          self.saisonsaved=true;
        });
      },

      lockInscription: function(event) {
        this.lockInsc=event.value;
        var api = new restapi();
        var data = new FormData();        
        data.append("islock",this.lockInsc);
        data.append("passwd",this.passunlockinsc);
        api.postLockInscription(data);
      },

      updatePassUnlockInsc:function() {
        var api = new restapi();
        var self=this;
        var data = new FormData();        
        data.append("islock",this.lockInsc);
        data.append("passwd",this.passunlockinsc);
        api.postLockInscription(data).then(()=>{
          self.passwdsaved=true;
        });
      }
  }

}
</script>