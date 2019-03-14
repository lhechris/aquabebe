<template>
<div class="container" >
  <p v-if="waiting==true"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Chargement...</p>
  <div class="row">    
    <div class="col-md-9" >
      <div v-for="lieu of creneaux" v-bind:key="lieu.name"><h2>{{lieu.name}}</h2>
        <div v-for="jour of lieu.jours" v-bind:key="jour" >
          <h3 >{{jour.name}}</h3>
          <div class="row">
          <table class="mytable col-md-12">
            <tr v-for="creneau of jour.creneaux" v-on:click="actionclick(creneau.enfants)" v-bind:class="{selectionner:creneau.enfants==enfants}" v-bind:key="'creneau'+creneau.id">
              <td>{{creneau.heure}}</td>
              <td>{{creneau.description}}</td>
              <td>
                <span v-if="creneau.remain==0" class="avertissement">Complet!</span>
                <span v-else>{{creneau.remain}} places restante</span>
              </td>
              <td><button class="glyphicon glyphicon-th"></button></td>
            </tr>
          </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <transition-group name="list" tag="p">
        <p class="mytable" v-for="enfant of enfants" v-bind:key="enfant.id">{{enfant.name}}</p>
      </transition-group>
    </div>

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
      enfants:{},
      waiting:true
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
        this.waiting=true;
        var self=this;
        api.getCreneaux().then(response=>{
          self.creneaux=response;
          self.waiting=false;
          var i;
          for (i in self.creneaux) {
            self.creneaux[i]["show"]=false;
          }
        }).catch(()=>{self.waiting=false;})
    }
  }

}
</script>

<style scoped>
.mytable {
  background : linear-gradient( to right,rgba(255, 200, 200, 0.8), rgba(255,128,128,0.3));
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