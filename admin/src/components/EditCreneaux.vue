<template>
<div class="container"><div class="row">
  <form>
    <p>Nouveau</p>
    <div class="form-group monform">        
      <label for="saison">Saison:</label>
      <input type="text" class="form-control" v-model="saison" />  
    </div>
      <div class="form-group">
        <label for="lieu">Lieu:</label>
        <select v-model="lieu" class="form-control">
          <option v-for="l in lieux" v-bind:value="l">{{l}}</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">  
        <label>Jour:</label>
        <input type="text" class="form-control" v-model="jour" />  
      </div>
      <div class="form-group col-md-6">  
        <label>Heure:</label>
        <input type="text" class="form-control" v-model="heure" />  
      </div>
    </div>
      <div class="form-group">  
        <label>Capacité:</label>
        <input type="number" class="form-control" v-model="capacite" v-on:click="agechange"/>  
      </div>
      <div class="form-group">  
        <label>Age de</label>
        <input type="number" class="form-control" v-model="agemin" />  
        <select v-model="ageminunit" class="form-control">
          <option values="mois">mois</option>
          <option values="ans">ans</option>
        </select>
        <label>à</label>
        <input type="number" class="form-control" v-model="agemax" />  
        <select v-model="agemaxunit" class="form-control">
          <option values="mois">mois</option>
          <option values="ans">ans</option>
        </select>
        <span>Enfants nés entre {{anneemin}} et {{anneemax}}</span>
    </div>
  </form>
</div></div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'
import moment from 'moment';

export default {
  name: 'EditCreneaux',
  components: {
      MainLayout
  },
  data () {
    return {
      saison: "",
      lieux: ["Villeneuve Tolosane","Saint-Lys"],
      lieu:"Villeneuve Tolosane",
      jour:"",
      heure:"",
      capacite:8,
      agemin:0,
      ageminunit:"mois",
      agemax:5,
      agemaxunit:"mois",
      anneemin:"",
      aneemax:""
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      agechange: function() {
        var ageminmois=this.agemin;
        var agemaxmois=this.agemax;
        if (this.ageminunit=="ans") {
            ageminmois*=12;
        }
        if (this.agemaxunit=="ans") {
            agemaxmois*=12;
        }
        this.anneemin=moment([2017,9,1]).substract(ageminmois,'months');
        this.anneemax=moment([2017,9,1]).substract(agemaxmois,'months');
      },
      get: function (){
        var api = new restapi();
        var self=this;
        api.getSaison().then(response=>{
          self.saison=response;
        })
    }
  }

}
</script>

<style scoped>
.monform {
  background : linear-gradient( to right,rgba(113,183,244,0.8), rgba(255,128,128,0.3));
  border-radius : 10px;
  margin:5px;
  padding : 5px;

}

.mytable {
  background : linear-gradient( to right,rgba(255,128,128,0.8), rgba(255,128,128,0.3));
  border-radius : 10px;
  margin:5px;
  padding : 5px;

}
.selectionner{
  background:linear-gradient( to left,rgba(255,200,200,0.8), rgba(69,128,128,0.3));
}
.border {
    border-color: #182a84;
    border-style: solid;
    border-width: 1px;
    margin-top: 30px;
    background-color: white;
}
.creneaux td {
    width: 115px;
    font-size:0.8em;    
}
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active {
  transition: all 1s;
}
.list-leave-active {
  transition: all 0s;
}
.list-enter {
  opacity: 0;
  transform: translateX(-30px);
}
.list-leave-to  {
  /*opacity: 0;*/
  transform: translateX(30px);
}
/*.flip-list-move {
  transition: transform 1s;
}*/
</style>