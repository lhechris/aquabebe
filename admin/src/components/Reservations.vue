<template>
<div class="container" >
    <p class="row" v-if="waiting==true"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Chargement...</p>
    <table class="table table-responsive  table-striped row">
        <thead><tr>
            <th>Date</th><th>Prénom</th><th>Nom</th><th>Creneau</th><th>Status</th>
        </tr></thead>
        <tbody> 
        <tr v-for="reserv of reservations" v-bind:key="reserv.id">
            <td>{{reserv.datemax}}</td>
            <td><router-link class="nav-link" v-bind:to="'/enfant/'+reserv.id">{{reserv.prenom}}</router-link></td>
            <td>{{reserv.nom}}</td>
            <td>
                    <p v-for="p of reserv.preinscriptions" v-bind:key="p.creneauid">
                    {{p.creneaujour}} {{p.creneauheure}} a {{p.creneaulieu}}
                    </p>
            </td>
            <td>{{reserv.status}}</td>
        </tr>
        </tbody>
    </table>
    <div class="row" style="padding:30px 10px 20px 0px">Liste des inscriptions dont les dates sont dépassées</div>
    <table class="table table-responsive  table-striped row">
        <thead><tr>
            <th>Date</th><th>Prénom</th><th>Nom</th><th>Paiement</th><th>Creneau</th>
        </tr></thead>
        <tbody>
        <tr v-for="enf of depasse" v-bind:key="enf.id">
            <td></td>
            <td><router-link class="nav-link" v-bind:to="'/enfant/'+enf.id">{{enf.prenom}}</router-link></td>
            <td>{{enf.nom}}</td>
            <td>{{enf.paiement_date}}</td>
            <td>
                    <p v-for="p of enf.preinscriptions" v-bind:key="p.creneauid">
                    {{p.creneaujour}} {{p.creneauheure}} a {{p.creneaulieu}}
                    </p>
            </td>
            <td><button>Valider le paiement</button></td>
        </tr>
        </tbody>
    </table>

    <div class="row" style="padding:30px 10px 20px 0px">Liste des Enfants inscrits</div>
    <table class="table table-responsive  table-striped row">
        <thead><tr>
            <th>Date</th><th>Prénom</th><th>Nom</th><th>Paiement</th><th>Creneau</th>
        </tr></thead>
        <tbody>
        <tr v-for="enf of valide" v-bind:key="enf.id">
            <td></td>
            <td><router-link class="nav-link" v-bind:to="'/enfant/'+enf.id">{{enf.prenom}}</router-link></td>
            <td>{{enf.nom}}</td>
            <td>{{enf.paiement_date}}</td>
            <td>
                    <p v-for="p of enf.preinscriptions" v-bind:key="p.creneauid">
                    {{p.creneaujour}} {{p.creneauheure}} a {{p.creneaulieu}}
                    </p>
            </td>
            <td><button>Valider le paiement</button></td>
        </tr>
        </tbody>
    </table>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Reservations',
  components: {
      MainLayout
  },
  data () {
    return {
      reservations: {},
      depasse:{},
      valide:{},
      waiting:true
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        this.waiting=true;
        api.getReservations().then(response=>{
          self.reservations=response[0];
          self.depasse=response[1];
          self.valide=response[2];
          self.waiting=false;
        })
    }
  }

}
</script>