<template>
<div class="container" >
<p class="row">
  <form>
    <div v-if="etape==1">      
      <h2 >etape 1 : Enfant</h2>      
      <div class="row forminscription">
        <div class="col-md-4" >Nom de l'enfant</div>
        <div class="col-md-2"><input name="nomenfant" type="text" v-model="nomenfant"></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom de l'enfant</div>
        <div class="col-md-2"><input name="prenomenfant" type="text" v-model="prenomenfant"></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Date de naissance</div>
        <div class="col-md-2"><datepicker v-model="naissance" name="naissance"></datepicker></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Sexe</div>
        <div class="col-md-4" align="left"><input type="radio" name="sexe" value="1" v-model="sexe"/>&nbsp;M&nbsp;<input type="radio" name="sexe" value="0" v-model="sexe"/>&nbsp;F</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Votre enfant présente t'il un handicap</div>
        <div class="col-md-4" align="left"><input type="radio" name="handicap" value="0" />&nbsp;Oui&nbsp;<input type="radio" name="handicap" value="1" />&nbsp;Non</div>
      </div>
    </div>
    <div v-if="etape==2">
      <h2>etape 2 : Parents </h2>
      <div class="row forminscription">
        <div class="col-md-4" >Nom du parent 1</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom parent 1</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Téléphone 1</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Nom du parent 2</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom parent 2</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Téléphone 2</div>
        <div class="col-md-2"><input type="text" ></input></div>
      </div>

    </div>
    <div v-if="etape==3">
      <h2>etape 3:  créneaux {{Object.keys(creneaux).length}}</h2>  
      <p>Voici les créneaux auxquels vous pouvez inscrire votre enfant. Indiquez votre créneau préféré (1) puis, à défaut, les autres créneaux (2,3...).</p>
      <p>Si aucune autre demande n'a été validée avant que vous n'ayez terminé votre inscription et si votre créneau préféré a des places libres, alors une place sur ce créneau vous est réservée pendant 7 jours.</p>
      <p>Vous avez donc 7 jours au maximum pour nous faire parvenir votre règlement et confirmer votre inscription.</p>
      <p>Si votre créneau préféré comporte uniquement des places en attente de validation de paiement (en jaune), nous attendrons la fin du délai de 7 jours (attente max du paiement par autrui). Si au terme de ce délai, le règlement de l'autre personne ne nous est pas parvenu, vous remonterez dans la liste d'attente et la place pourra éventuellement vous être attribuée. En attendant, une place sur votre 2ème, 3ème... choix est réservée. </p>
      <div class="row forminscription" v-for="creneau of creneaux">
        <div class="col-md-4"><input type="text" size="1" v-bind:name="creneau.inputname" /></div>
        <div class="col-md-4">{{creneau.name}} - {{creneau.lieu}}</div>
        <div class="col-md-4">({{creneau.inscrits}} inscrits sur {{creneau.capacite}})</div>
      </div>
      </table>
    </div>
    <div v-if="etape==4">
      <h2>etape 4:  Autorisations</h2>      
    </div>
    <div v-if="etape==5">
      <h2>etape 5:  Réglement Intérieur</h2>      
    </div>
    <div v-if="etape==6">
      <h2>etape 6:  Paiement</h2>      
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
      naissance:"",
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

<style scoped>
.forminscription {
  background : linear-gradient( to right,rgba(113,183,244,0.8), rgba(255,128,128,0.3));
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