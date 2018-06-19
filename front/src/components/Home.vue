<template>
<!--<div v-html="msg"></div>-->
<div class="container">
  <div class="row">    
    <h1>Activité pour les enfants de 3 mois à 3 ans à Villeneuve-Tolosane et jusqu'à 5 ans à Saint-Lys.</h1>
    <p>&nbsp;</p>
      <p class="avertissement">Suite à des travaux plus importants que prévus sur le bassin de Villeneuve-Tolosane, nous sommes obligés d'arrêter la saison sur Villeneuve. Des créneaux de remplacement vont être mis en place sur Saint Lys</p>
      <p>L'association Aqua-Bébé, association de loi 1901 à but non lucratif, offre l'opportunité aux parents d'initier leurs bébés et jeunes enfants au plaisir de l'eau, avec un éveil à la natation.</p><p>Aqua-Bébé vous accueille les Mercredi, Vendredi ou Samedi dans une piscine chauffée à 32-33°C pour le bonheur et le respect de bébé.</p>
      <p>N'hésitez plus ! Venez pratiquer l'activité bébé nageur encadrée et animée par un maitre nageur sauveteur pour découvrir ou redécouvrir en famille les joies et les bienfaits du milieu aquatique. Dans cet environnement propice à l'éveil sensoriel et moteur, bébé et ses parents partageront des moments de tendresse et de complicité dans un lieu adapté et aménagé.</p>
  </div>
  <div class="row">
      <h1>Actualités</h1>
      <p> En Octobre nos MNS ont encadré notre première sensibilisation prévention secourisme. Au programme: donner l'alerte, les techniques de désobstructions, La noyade et la réanimation. Le tout s'est passé dans une bonne ambiance et le temps a même permis de manipuler dehors"</p>
      <p>
        <img src="../assets/prevention/WA0005.jpg" width="200">
        <img src="../assets/prevention/WA0006.jpg" width="200">
        <img src="../assets/prevention/WA0015.jpg" width="200">
      </p>
      <p><img src="../assets/Prevention/WA0009.jpg" width="200"></p>
    </div>
    <div class="row">
      <p>En mars 1997, A la recherche d'une activité aquatique pour leur fille, Sylvie et Jean-Pierre André, ne trouvant aucune structure pour bébé nageur sur Muret, il crée aqua bébé. Jean-Pierre André, maitre-nageur, deviendra donc le premier maître nageur de cette nouvelle association.
    Au premier bassin de Muret au cabinet du rhumathologue Jacques Coudec, de nombreux autres bassins se sont succedés en passant par Plaisance-du-Touch, jusqu'aux bassins de Saint-Lys et Villeneuve-Tolosane de l'association des Amis de l'enfance qui accueille l'association depuis 2011.
    De la poignée d'enfants du départ, c'est désormais 90 enfants chaque année qui trempent petons, ventrous et menottes sous le regard complice de maman ou papa (voir de papy ou mamie).</p>

    <p>Cette, années notre association a 20 ans, et pour fêter cela, l'actuel bureau de l'association a souhaité dans un premier temps remercier les fondateurs et tous les membres bénévoles s'étant investis par le passé, autour d'un repas qui a permis de reprendre contact entre bénévoles et de remettre un petit souvenir aux fondateurs.</p>
    <p>Dans un second temps nous avons organisé une matinée festive pour nos Bébés avec un spectacle de Dimdou et Tonic. Du rire, des étoiles dans les yeux des enfants, de belles sculptures en ballon. Nous avons ensuite pu partager autour d'un verre de l'amitié et  d'un pique nique. Bref une chouette matinée pour les enfants comme pour les parents&nbsp;!</p>
    <p>
      <img src="../assets/20ans/IMGP5335.jpg" width="200">
      <img src="../assets/20ans/IMGP5376.jpg" width="200">
    </p>
    <p>
      <img src="../assets/20ans/IMGP5330.jpg" width="200">
      <img src="../assets/20ans/IMGP5331.jpg" width="200">
      <img src="../assets/20ans/IMGP5386.jpg" width="200">
    </p>
  </div>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Utilisateur',
  components: {
      MainLayout
  },
  data () {
    return {
      msg: 'Site Aqua Bébé'
    }
  },
  created: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        //api.getHome().then(response=>{self.msg=response; })
    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.container{
  text-align:left;
}
</style>
