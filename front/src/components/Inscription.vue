<template>
<div class="container main" >
<p class="row">
  <form>
    <div v-if="etape==-1">
    <h2>Vous souhaitez vous inscrire?</h2>
    <p><strong>Pour prendre en compte votre inscription il vous est demandé&nbsp;:</strong></p>
    <ul>
      <li>De remplir le formulaire d'inscription en ligne (ou le fomulaire papier à télécharger et nous renvoyer);
      </li>
      <li>De choisir les créneaux désirés dans l'ordre de préférence (<router-link to="/creneaux">voir les créneaux proposés</router-link>)</li>
      <li>De nous faire parvenir, sous une semaine, les documents administratifs signés ainsi que les chèques de cotisation.</li>
    </ul>
    <p><strong>Certificat médical :</strong></p>
    <p>Un certificat médical <strong>de moins de 3 mois </strong>indiquant que votre enfant peut pratiquer cette activité doit être fourni lors du <strong>premier accès </strong>au bassin.</p>
    <p><strong>Vaccinations :</strong></p>
    <p>Votre enfant doit être à jour de ses vaccinations. Une présentation du carnet de santé ou une photocopie des pages de vaccination sera nécessaire pour le <strong>premier accès </strong>au bassin.</p>
    <p><strong>Information sur les créneaux :</strong></p>
    <p>Lors de votre inscription, vous aurez à sélectionner les créneaux par ordre de préférence. Une place vous est automatiquement réservée dans le premier créneau préféré ayant une place libre. Cette affectation vous est réservée pendant 7 jours et sera confirmée lors de la réception du paiement. <br>Vous êtes également en liste d'atente sur les crénaux complets ayant une préférence plus élevée et, si une place se libère, vous serez repositionnés sur celui-ci.</p>
    <p><strong>Information sur les tarifs :</strong></p>
    <p>Si vous avez plusieurs enfants inscrits, le <router-link to="/tarif">tarif est dégressif</router-link>. 
        N'ayant pas automatisé ce système, nous vous proposons de faire l'inscription de chaque enfant indépendamment et 
        de choisir le paiement par chèque. Vous ferez donc un chèque du montant approprié avec le nom de tous les enfants 
        au dos et l'enverrez comme indiqué dans la procédure. <br>En cas de doute sur le montant, vous pouvez nous contacter par 
        E-mail <img src="/images/contact-head.jpg" alt="adresse à recopier"><br>
        Calendrier de l'encaissement des chèques : voir <router-link to="/tarif">ici</router-link>.
    </p> 
    <h2>Inscription : <button class="btn-info" v-on:click="suivantclick">S'INSCRIRE</button></h2>
    <h2>Une question ? Un problème ?</h2>
    <ul>
      <li>Pour toute autre question, vous pouvez nous joindre : <img src="/images/contact-head.jpg" alt="adresse à recopier"></li>
    </ul>
    <p><strong><br>Que ce soit pour l'inscription ou pour toute communication en cours d'année, l'E-mail est la solution que l'association Aqua-Bébé utilise de manière privilégiée.</strong></p>
    </div>
    <div v-if="etape==0">
      <h2>Inscription 2017-2018 </h2>
      <ul>
        <!--<li>Nous sommes complets pour la saison. La page créneaux vous indiquera si des places se libèrent.</li>-->
        <li><strong>Inscription en ligne : <button class="btn-info" v-on:click="suivantclick">DEMARRER</button></strong>
          <br><strong>Créneaux fratrie</strong>: Ces créneaux sont réservés aux fratries. Ne peuvent s'y inscrire que 2 (ou plus) enfants étant frères et/ou soeurs. Dans ce cas il faut être 2 (ou plus) accompagnants dans l'eau (un par enfant).
          <br><strong>Attention, vous devez faire indépendamment l'inscription pour chaque enfant de la fratrie.</strong>
            <br> Note : A la fin de l'inscription, vous recevez un e-mail indiquant que votre inscription a été prise en compte.
        </li>      
        <li>Inscription par courrier : Contactez Aqua-Bébé        
        <!--<li>Inscription par courrier : Imprimez et complétez
            <a href="dossier_inscription_2013-2014.pdf" onclick="javascript:window.open(this.href);return(false);">le formulaire d'inscription</a>
            et renvoyez-le-nous accompagné du règlement complet à l'adresse indiquée.</li>-->            
      </li></ul>
      <h2>Une question ? Un problème ?</h2>
      <ul>
        <li>Pour tout problème technique lors de l'inscription :<br>
          * contactez <img src="/images/contact-head.jpg" alt="adresse à recopier"> et<br>
          * envoyez en parallèle votre dossier d'inscription par la poste avec votre règlement.
        </li>
          <li>Pour toute autre question, vous pouvez nous joindre à : <img src="/images/contact-head.jpg" alt="adresse à recopier"></li>
      </ul>
      <p><strong><br>Que ce soit pour l'inscription ou pour toute communication en cours d'année, l'E-mail est la solution 
                que l'association Aqua-Bébé utilise de manière privilégiée.</strong></p>    
    </div>    
    <div v-if="etape==1">      
      <h2 >etape 1 : Enfant</h2>      
      <div class="row forminscription">
        <div class="col-md-4" >Nom de l'enfant</div>
        <div class="col-md-2"><input name="nomenfant" type="text" v-model="nomenfant"></input></div>
        <div class="col-md-4 avertissement" v-if="nomenfant==''">Veuillez inscrire un nom</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom de l'enfant</div>
        <div class="col-md-2"><input name="prenomenfant" type="text" v-model="prenomenfant"></input></div>
        <div class="col-md-4 avertissement" v-if="prenomenfant==''">Veuillez inscrire un prénom</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Date de naissance</div>
        <div class="col-md-2"><datepicker v-model="naissance" name="naissance"></datepicker></div>
        <div class="col-md-4 avertissement" v-if="naissance==''">Veuillez sélectionner une date</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Sexe</div>
        <div class="col-md-2" align="left"><input type="radio" name="sexe" value="1" v-model="sexe"/>&nbsp;M&nbsp;<input type="radio" name="sexe" value="0" v-model="sexe"/>&nbsp;F</div>
        <div class="col-md-4 avertissement" v-if="sexe==-1">Veuillez sélectionner le sexe de l'enfant</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Votre enfant présente t'il un handicap</div>
        <div class="col-md-2" align="left"><input type="radio" name="handicap" value="1" v-model="handicap"/>&nbsp;Oui&nbsp;<input type="radio" name="handicap" value="0" v-model="handicap"/>&nbsp;Non</div>
        <div class="col-md-4 avertissement" v-if="handicap==-1">Veuillez sélectionner une réponse</div>
      </div>
    </div>
    <div v-if="etape==2">
      <h2>etape 2 : Parents </h2>
      <div class="row forminscription">
        <div class="col-md-4" >Nom du parent 1</div>
        <div class="col-md-2"><input type="text" name="nomparent1" v-model="nomparent1" ></input></div>
        <div class="col-md-4 avertissement" v-if="nomparent1==''">Veuillez inscrire un nom</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom parent 1</div>
        <div class="col-md-2"><input type="text"  name="prenomparent1" v-model="prenomparent1"></input></div>
        <div class="col-md-4 avertissement" v-if="prenomparent1==''">Veuillez inscrire un prénom</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Téléphone 1</div>
        <div class="col-md-2"><input type="text"  name="telparent1" v-model="telparent1"></input></div>
        <div class="col-md-4 avertissement" v-if="telparent1==''">Veuillez inscrire un numéro de téléphone</div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Nom du parent 2</div>
        <div class="col-md-2"><input type="text"  name="nomparent2" v-model="nomparent2"></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Prénom parent 2</div>
        <div class="col-md-2"><input type="text"  name="prenomparent2" v-model="prenomparent2"></input></div>
      </div><div class="row forminscription">
        <div class="col-md-4" >Téléphone 2</div>
        <div class="col-md-2"><input type="text"  name="telparent2" v-model="telparent2"></input></div>
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
  <button v-if="etape>1" class="btn-info" v-on:click="precedentclick">Précédent</button>
  <button v-if="etape>0" class="btn-info" v-on:click="suivantclick">Suivant</button>
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
      etape:-1,
      creneaux:{},
      nomenfant:"",
      prenomenfant:"",
      sexe:-1,
      naissance:"",
      handicap:0,
      nomparent1:"",
      prenomparent1:"",
      telparent1:"",
      nomparent2:"",
      prenomparent2:"",
      telparent2:"",
    }
  },
   methods:{
      suivantclick: function(event) {
        if (this.etape<6) {
          if (! this.check()) { return;}
                    
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
            if (this.check()) {
              this.etape-=1;
            }
        }
      },

      check: function() {
        if (this.etape<1) { return true;}

        if (this.etape==1) {
          if ((this.nomenfant=="") || (this.prenomenfant=="") || (this.naissance=="") || (this.sexe==-1)){ return false;}

        } else if (this.etape==2) {
          if ((this.nomparent1=="") || (this.prenomparent1=="") || (this.telparent1=="") ){ return false;}
        }
        return true;
      }
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
.main {
  text-align:left;
}
.avertissement {
  color:red;
  font-style:italic;
}

</style>