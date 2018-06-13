<template>
<div class="container">
  <div class="row">
    <h2>La cotisation (saison 2017-2018)</h2>
    <p>La cotisation est constituée de l'adhésion à l'association pour la période scolaire 2017-2018    et de la participation à l'activité "bébé nageurs". <br>
        L'adhésion est de 20€ et est à acquitter uniquement pour le 1er enfant. La participation à l'activité s'élève à 180€ pour un enfant.<br>
        La cotisation totale s'élève donc à 200€ pour le 1er enfant. <br>
      La participation est dégressive si vous vous inscrivez en cours d'année. Si vous 
        inscrivez plusieurs enfants, une remise sera appliquée sur les tarifs.<br>
      
      Au delà de deux enfants, merci de nous consulter. <br>
    </p>
	</div>
  <div class="row">       
    <h2>Calculer le montant de votre cotisation</h2>

    <div>
    <table class="table-responsive">
    <tbody><tr align="center">
      <th>Vous inscrivez votre enfant</th>
      <th>1 enfant</th>
      <th>2 enfants</th>
    </tr>
    <tr>
      <td>Avant le 15 Octobre</td>
      <td>1 chèque de 180€ (ou 3 x 60€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 340€ (ou 2 x 115€ et 1*110€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Novembre</td>
      <td>1 chèque de 160€ (ou 2 x 50€ et 1*60€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 304€ (ou 2 x 100€ et 1*104€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Décembre</td>
      <td>1 chèque de 140€ (ou 2 x 50€ et 1*40€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 266€ (ou 2 x 90€ et 1*86€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Janvier</td>
      <td>1 chèque de 120€ (ou 3 x 40€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 228€ (ou 3 x 76€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Février</td>
      <td>1 chèque de 100€ (ou 2 x 35€ et 1*30€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 190€ (ou 2 x 65€ et 1*60€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Mars</td>
      <td>1 chèque de 80€ (ou 2 x 40€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 152€ (ou 2 x 76€)<br> + 1 chèque de 20€</td>
    </tr>
    <tr>
      <td>En Avril</td>
      <td>1 chèque de 60€ (ou 2 x 30€)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 114€ (ou 2 x 57€)<br> + 1 chèque de 20€</td>
    </tr>
      <tr><td>En Mai</td>
      <td>1 chèque de 40€ <br>(pas de paiement en plusieurs fois)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 76€ <br>(pas de paiement en plusieurs fois)<br> + 1 chèque de 20€</td>
    </tr>
      <tr><td>En Juin</td>
      <td>1 chèque de 20€ <br>(pas de paiement en plusieurs fois)<br> + 1 chèque de 20€</td>
      <td>1 chèque de 38€ <br>(pas de paiement en plusieurs fois)<br> + 1 chèque de 20€</td>
    </tr>
    </tbody></table>
    </div>
  </div>
  <div>
    <h2>Encaissement des chèques</h2>
    <p>Les chèques seront encaissés après la première séance validée et avec le calendrier suivant :</p>
    <ul><li>adhésion 20€ au 15 octobre</li>
        <li>1er chèque au 15 octobre</li>
        <li>2ème chèque au 15 novembre</li>
        <li>3ème chèque au 15 décembre</li>
    </ul>
  </div>
</div>
</template>

<script>
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Tarifs',
  components: {
      MainLayout
  }

}
</script>

<style scoped>
div{
  text-align:left;
}
table {
  /*background : linear-gradient( to right,rgba(255,128,128,0.8), rgba(255,128,128,0.3));*/
  /*border-radius : 10px;*/
  margin:5px;
  padding : 5px;

}
td {
    border: 2px solid #182a84 ;
    border-radius:10px;
    margin-top: 30px;    
} 
</style>