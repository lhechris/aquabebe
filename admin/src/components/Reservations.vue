<template>
<div class="container" >
    <table class="table table-responsive  table-striped row">
        <thead><tr>
            <th>Date</th><th>Prénom</th><th>Nom</th><th>Paiement</th><th>Creneau</th>
        </tr></thead>
        <tbody> 
        <tr v-for="avalide of avalider" v-bind:key="avalide.id">
            <td>{{avalide.paiement_date}}</td>
            <td><router-link class="nav-link" v-bind:to="'/enfant/'+avalide.id">{{avalide.prenom}}</router-link></td>
            <td>{{avalide.nom}}</td>
            <td>{{avalide.paiement}}</td>
            <td>
                    <p v-for="p of avalide.preinscriptions" v-bind:key="p.creneauid">
                    {{p.creneaujour}} {{p.creneauheure}} a {{p.creneaulieu}}
                    </p>
            </td>
            <td><button>Valider un creneau</button></td>
        </tr>
        </tbody>
    </table>
    <div class="row" style="padding:30px 10px 20px 0px">Liste des inscriptions dont les dates sont dépassées</div>
    <table class="table table-responsive  table-striped row">
        <thead><tr>
            <th>Date</th><th>Prénom</th><th>Nom</th><th>Paiement</th><th>Creneau</th>
        </tr></thead>
        <tbody>
        <tr v-for="enf of apayer" v-bind:key="enf.id">
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
      apayer: {},
      avalider:{}
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getReservations().then(response=>{
          self.apayer=response["apayer"];
          self.avalider=response["avalider"];
        })
    }
  }

}
</script>