<template>
<div class="container">
  <form>
    <p v-if="creneauid==0">Nouveau creneau</p>
    <p v-else>Creneau {{creneauid}}</p>
    <div class="form-group monform">        
      <label for="saison">Saison:</label>
      <input type="text" class="form-control" v-model="saison" v-on:change="saisonchange"/>  
    </div>
    <div class="form-group monform">
        <label for="lieu">Lieu:</label>
        <select v-model="lieu" class="form-control">
          <option v-for="l in lieux" v-bind:value="l" v-bind:key="l">{{l}}</option>
        </select>
    </div>
    <div class="monform">
      <div class="form-group">  
        <label for="jour">Jour:</label>
        <select v-model="jour" class="form-control">
          <option v-for="j in jours" v-bind:value="j" v-bind:key="j">{{j}}</option> 
        </select>
      </div>
      <div class="form-group">  
        <label for="heure">Heure:</label>
        <input type="text" class="form-control" v-model="heure" />
      </div>
    </div>
    <div class="form-group  monform">  
      <label >Capacité:</label>
      <input class="form-control" type="number" v-model="capacite" />  
    </div>
    <div class="form-group  monform">  
      <div class="row">        
        <label for="agemin" class="col-md-2">Age de</label>
        <input type="number" class="form-control col-md-1" v-model="agemin" v-on:change="agechange" />  
        <select v-model="ageminunit" class="form-control col-md-2" v-on:change="agechange">
          <option values="mois">mois</option>
          <option values="ans">ans</option>
        </select>
        <span class="col-md-2">à</span>
        <input type="number" class="form-control col-md-1" v-model="agemax" v-on:change="agechange"/>  
        <select v-model="agemaxunit" class="form-control col-md-2" v-on:change="agechange">
          <option values="mois">mois</option>
          <option values="ans">ans</option>
        </select>
      </div>        
      <p>Enfants nés entre le {{naissance_max_p}} et le {{naissance_min_p}}</p>
    </div>
    <div class="form-group  monform row">
      <label for="fratrie" class="col-md-3">Fratrie</label>
      <input type="radio" class="form-control col-md-1" v-model="fratrie" name="fratrie" value="0"/><span class="col-md-1">Non</span>
      <input type="radio" class="form-control col-md-1" v-model="fratrie" name="fratrie" value="1"/><span class="col-md-1">Oui</span>
      <label for="nbmoismini" class="col-md-4">Nb Mois mini</label>
      <input type="number" class="form-control col-md-1" v-model="nbmoismini">
    </div>
    <div class="row">
      <button  class="btn btn-primary col-md-1" v-on:click="ajouter()" >Sauver</button>
    </div>
  </form>
</div>
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
  props: ["creneauid"],

  data () {
    return {
      saison: "",
      lieux: ["Villeneuve Tolosane","Saint-Lys"],
      lieu:"Villeneuve Tolosane",
      jours:["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"],
      jour:"",
      heure:"",
      capacite:8,
      agemin:0,
      ageminunit:"mois",
      agemax:5,
      agemaxunit:"mois",
      naissance_min:"",
      naissance_max:"",
      naissance_min_p:"",
      naissance_max_p:"",
      fratrie:0,
      nbmoismini:0,
    }
  },
  created: function() {
      this.get();
  },
  
  methods:{
      saisonchange: function() {
        this.agechange();
      },
      agechange: function() {
        moment.locale("FR");
        var ageminmois=this.agemin;
        var agemaxmois=this.agemax;
        if (this.ageminunit=="ans") {
            ageminmois*=12;
        }
        if (this.agemaxunit=="ans") {
            agemaxmois*=12;
        }
        var annee=parseInt(this.saison.substring(0,4));
        var nmin=moment([annee,8,1]).subtract(ageminmois,'months').endOf('month');
        var nmax=moment([annee,9,1]).subtract(agemaxmois,'months');
        this.naissance_min_p=nmin.format("Do MMM YYYY");
        this.naissance_max_p=nmax.format("Do MMM YYYY");
        this.naissance_min=nmin.format("DD/MM/YYYY");
        this.naissance_max=nmax.format("DD/MM/YYYY");
      },
      get: function (){
        var api = new restapi();
        var self=this;
        if (this.creneauid==0) {
          api.getSaison().then(response=>{
            self.saison=response;
            self.agechange();
          }) 
        
        } else {
          api.getCreneau(this.creneauid).then(response=>{
            self.saison=response.saison;
            self.lieu=response.lieu;
            self.jour=response.jour;
            self.heure=response.heure;
            self.capacite=response.capacite;
            self.fratrie=response.pour_fratrie;
            self.nbmoismini=response.nbmoismini;

            //calculate age min
            var annee=parseInt(this.saison.substring(0,4));
            var nmin=moment([annee,8,1]) ;
            var mmin=moment(response.min,"YYYY-MM-DD");
            self.agemin=nmin.diff(mmin,"month");

            //calculate age max
            var nmax=moment([annee,9,1]) ;
            var mmax=moment(response.max,"YYYY-MM-DD");
            self.agemax=nmax.diff(mmax,"month");

            self.agechange();
          })
        }

      },
      ajouter: function() {
        var api = new restapi();
        var data = new FormData();
        var age = "de "+this.agemin+" "+this.ageminunit+" a "+this.agemax+" "+this.agemaxunit;        
        this.agechange();

        data.append("saison",this.saison);
        data.append("lieu",this.lieu);
        data.append("jour",this.jour);
        data.append("heure",this.heure);
        data.append("capacite",this.capacite);
        data.append("age",age);
        data.append("naissance_min",this.naissance_min);
        data.append("naissance_max",this.naissance_max);
        data.append("pour_fratrie",this.fratrie);
        data.append("nbmoismini",this.nbmoismini);

        api.postNewCreneau(data).then(()=> {
          
        });        
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