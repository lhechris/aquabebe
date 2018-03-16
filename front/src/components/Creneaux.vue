<template>
<div class="container" >
  <p v-if="Object.keys(creneaux).length==0"> loading...</p>
  <td><button class="btn-info" v-on:click="actionclick">{{afficher}}</button></td>
  <table v-for="creneau of creneaux" class="table-responsive">
    <tbody>
    <tr align="center">
      <td >{{creneau.name}}</td>
      <td>{{creneau.lieu}}</td>
      <td>{{creneau.description}}</td>
      <td><span v-if="creneau.iscomplet" class="complet">Complet ! </span></td>
    </tr>
    <transition name="fade">
    <tr align="center" v-if="show">
      <td v-for="enfant of creneau.enfants" class="border">{{enfant.name}} ({{enfant.age}})</td>
    </tr>
    </transition>
    </tbody>
  </table>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Creneaux',
  components: {
      MainLayout
  },
  data () {
    return {
      creneaux: {},
      show:true,
      afficher:"Afficher moins"

    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      actionclick: function(event) {
        if (this.show) {
          this.show=false;
          this.afficher="Afficher plus";
        }
        else{
          this.show=true;
          this.afficher="Afficher moins";
        }
      },
      get: function (){
        var api = new restapi();
        var self=this;
        api.getCreneaux().then(response=>{
          self.creneaux=response;
          var i;
          for (i in self.creneaux) {
            self.creneaux[i]["show"]=false;
          }
        })
    }
  }

}
</script>

<style>
.complet {
  color:red;
}
table {
  background : linear-gradient( to right,rgba(255,128,128,0.8), rgba(255,128,128,0.3));
  border-radius : 10px;
  margin:5px;
  padding : 5px;

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
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

</style>