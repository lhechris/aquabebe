<template>
<div class="container" >
  <div class="row">    
    <p v-if="loading"> loading...</p>
    <p v-if="error!=''"> {{error}}</p>
    <div class="col-md-6">
      <div v-for="lieu of creneaux" v-bind:key="lieu.name"><h2>{{lieu.name}}</h2>
        <div v-for="jour of lieu.jours" v-bind:key="jour.name">
          <h3>{{jour.name}}</h3>
            <table class="mytable">
              <tr v-for="creneau of jour.creneaux"  v-bind:class="{selectionner:creneau.enfants==enfants}" v-bind:key="creneau.id">          
                <td>{{creneau.heure}}</td>
                <td>{{creneau.description}}</td>
                <td v-if="creneau.iscomplet" class="avertissement">Complet !</td>
                <td><button class="glyphicon glyphicon-th" v-on:click="actionclick(creneau.enfants)"></button></td>
                <td><button class="glyphicon glyphicon-cog" v-on:click="editclick(creneau.id)"></button></td>
              </tr>
            </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <transition-group name="list" tag="p">      
        <p class="mytable" v-for="enfant of enfants" v-bind:key="enfant.id"><router-link class="nav-link" v-bind:to="'/enfant/'+enfant.id">{{enfant.name}} <span v-if="enfant.age!=''">({{enfant.age}})</span></router-link></p>
      </transition-group>
      <div v-for="lieu of creneaux" v-bind:key="'e'+lieu.name">
        <div v-for="jour of lieu.jours" v-bind:key="'e'+lieu.name+jour.name">
              <div v-for="creneau of jour.creneaux" v-bind:key="'e'+creneau.id">
                <EditCreneaux v-if="editcreneau==creneau.id" v-bind:creneauid="creneau.id"></EditCreneaux>
              </div>
        </div>
      </div>
      <EditCreneaux v-if="editcreneau==0" v-bind:creneauid="0"></EditCreneaux>
    </div>

  </div>
  <div class='row'>
  <button class="btn btn-primary" v-on:click="editcreneau=0">Ajouter un creneau</button>
  </div>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue';
import EditCreneaux from './EditCreneaux';

export default {
  name: 'Creneaux',
  components: {
      MainLayout,
      EditCreneaux
  },
  data () {
    return {
      creneaux: {},
      enfants:{},
      editcreneau:-1,
      error:"",
      loading:false,
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      actionclick: function(enfants) {
        this.enfants=enfants;
        this.editcreneau=-1;
      },
      editclick: function(id) {
        this.enfants={} ;
        this.editcreneau=id;       
      },
      get: function (){
        this.loading=true;
        var api = new restapi();
        var self=this;
        api.getCreneaux().then(response=>{
          self.loading=false;
          self.creneaux=response;
          var i;
          for (i in self.creneaux) {
            self.creneaux[i]["show"]=false;
          }
        }).catch((error) => {
            self.loading=false;
            self.error=error;
          });
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

.edituncreneau-item {
  display: inline-block;
  margin-right: 10px;
}
.edituncreneau-enter-active {
  transition: all 1s;
}
.edituncreneau-leave-active {
  transition: all 0s;
}
.edituncreneau-enter {
  opacity: 0;
  transform: translateX(-30px);
}
.edituncreneau-leave-to  {
  /*opacity: 0;*/
  transform: translateX(30px);
}

</style>