<template>
<div class="container" >
<p>
  <form>
    <div v-if="etape==1">      
      <p>etape 1 : Enfant</p>
      <table>
      <tr><td>Nom de l'enfant</td><td><input name="nomenfant" type="text" v-model="nomenfant"></input></td></tr>
      <tr><td>Prénom de l'enfant</td><td><input name="prenomenfant" type="text" v-model="prenomenfant"></input></td></tr>
      <tr><td>Date de naissance</td><td>
          <datepicker v-model="naissance" name="naissance"></datepicker>
      </td></tr>
      <tr><td>Sexe</td><td align="left"><input type="radio" name="sexe" value="1" v-model="sexe"/>&nbsp;M&nbsp;<input type="radio" name="sexe" value="0" v-model="sexe"/>&nbsp;F</td></tr>
      <tr><td>Votre enfant présente t'il un handicap</td><td align="left"><input type="radio" name="handicap" value="0" />&nbsp;Oui&nbsp;<input type="radio" name="handicap" value="1" />&nbsp;Non</td></tr>
      </table>
    </div>
    <div v-if="etape==2">
      <p>etape 2 : Parents </p>
      <table>
      <tr><td>Nom du parent 1</td><td><input type="text" ></input></td></tr>
      <tr><td>Prénom parent 1</td><td><input type="text" ></input></td></tr>
      <tr><td>Téléphone 1</td><td><input type="text" ></input></td></tr>
      <tr><td>Nom du parent 2</td><td><input type="text" ></input></td></tr>
      <tr><td>Prénom parent 2</td><td><input type="text" ></input></td></tr>
      <tr><td>Téléphone 2</td><td><input type="text" ></input></td></tr>
      </table>

    </div>
    <div v-if="etape==3">
      <p>etape 3:  créneaux {{Object.keys(creneaux).length}}</p>  
      <p>Voici les créneaux auxquels vous pouvez inscrire votre enfant. Indiquez votre créneau préféré (1) puis, à défaut, les autres créneaux (2,3...).</p>
      <p>Si aucune autre demande n'a été validée avant que vous n'ayez terminé votre inscription et si votre créneau préféré a des places libres, alors une place sur ce créneau vous est réservée pendant 7 jours.</p>
      <p>Vous avez donc 7 jours au maximum pour nous faire parvenir votre règlement et confirmer votre inscription.</p>
      <p>Si votre créneau préféré comporte uniquement des places en attente de validation de paiement (en jaune), nous attendrons la fin du délai de 7 jours (attente max du paiement par autrui). Si au terme de ce délai, le règlement de l'autre personne ne nous est pas parvenu, vous remonterez dans la liste d'attente et la place pourra éventuellement vous être attribuée. En attendant, une place sur votre 2ème, 3ème... choix est réservée. </p>
      <table>
      <tr v-for="creneau of creneaux">
        <td><input type="text" size="1" v-bind:name="creneau.inputname" /></td>
        <td>{{creneau.name}} - {{creneau.lieu}}</td>
        <td>({{creneau.inscrits}} inscrits sur {{creneau.capacite}})</td>
      </tr>
      </table>
    </div>
    <div v-if="etape==4">
      <p>etape 4:  Autorisations</p>      
    </div>
    <div v-if="etape==5">
      <p>etape 5:  Réglement Intérieur</p>      
    </div>
    <div v-if="etape==6">
      <p>etape 6:  Paiement</p>      
    </div>
  </form>
</p>
  <button class="btn-info" v-on:click="precedentclick">Précédent</button>
  <button class="btn-info" v-on:click="suivantclick">Suivant</button>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'
import DatepickerComponent from 'vuejs-datepicker';

export default {
  name: 'Inscription',
  components: {
      MainLayout,
      datepicker : DatepickerComponent
  },
  data () {
    return {
      etape:1,
      creneaux:{},
      nomenfant:"",
      prenomenfant:"",
      sexe:-1,
      naissance:"2015-02-02",
    }
  },
   methods:{
      suivantclick: function(event) {
        if (this.etape<6) {
          this.etape+=1;
          if (this.etape==3) {
            var api = new restapi();
            var self=this;
            api.getCreneauxForNaissance(this.naissance).then(response=>{
              self.creneaux=response;
              var i;
              for (i in self.creneaux) {
                self.creneaux[i]["inputname"]="creneau_"+self.creneaux[i]["id"];
              }
            })
          }
        }
      },
      precedentclick: function(event) {
        if (this.etape>1) {
            this.etape-=1;
        }
      },
    }

}
</script>

<style>
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

</style>