<template>
<div class="container" >
  <div class="row">    
    <p v-if="Object.keys(creneaux).length==0"> loading...</p>
    <div class="col-md-6">
      <div v-for="lieu of creneaux" v-bind:key="lieu.name"><h2>{{lieu.name}}</h2>
        <div v-for="jour of lieu.jours" v-bind:key="jour.name">
          <h3>{{jour.name}}</h3>
            <table class="mytable">
              <tr v-for="creneau of jour.creneaux" v-on:click="actionclick(creneau.enfants)" v-bind:class="{selectionner:creneau.enfants==enfants}" v-bind:key="creneau.id">          
                <td>{{creneau.heure}}</td>
                <td>{{creneau.description}}</td>
                <td v-if="creneau.iscomplet" class="avertissement">Complet !</td>
                <td><button class="glyphicon glyphicon-th"></button></td>
              </tr>
            </table>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <transition-group name="list" tag="p">      
        <p class="mytable" v-for="enfant of enfants" v-bind:key="enfant.id"><router-link class="nav-link" v-bind:to="'/enfant/'+enfant.id">{{enfant.name}} <span v-if="enfant.age!=''">({{enfant.age}})</span></router-link></p>
      </transition-group>
    </div>

  </div>
  <div class='row'>
  <router-link to="/EditCreneaux">Gerer les creneaux</router-link>
  </div>
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
      enfants:{}
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      actionclick: function(id) {
        /*this.enfants=[]
        for (var i=0;i<id.length;i++)
        {
            this.enfants.push({"n":id[i]["id"],"name":id[i]["name"],"age":id[i]["age"]});
        }*/
        this.enfants=id;
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

<style scoped>
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