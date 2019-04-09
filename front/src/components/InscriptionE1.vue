<template>
  <div>
      <h2 >etape 1 : Enfant</h2>
      <div class="row">      
        <div class="form-group forminscription col-md-4">
          <label for="nomenfant">Nom de l'enfant :</label>
          <span class="obligatoire" v-if="nomenfant==''">Champ obligatoire</span>
          <input name="nomenfant" type="text" class="form-control" v-bind:value="nomenfant" v-on:input="$emit('nomenfant',$event.target.value)"/>
        </div>
        <div class="form-group forminscription col-md-4">
          <label for="prenomenfant" >Prénom de l'enfant :</label>
          <span class="obligatoire" v-if="prenomenfant==''">Champ obligatoire</span>
          <input name="prenomenfant" type="text" class="form-control" v-bind:value="prenomenfant" v-on:input="$emit('prenomenfant',$event.target.value)"/>
        </div>
        <div class="form-group forminscription col-md-2" >
          <label for="naissance" >Date de naissance</label>
          <span class="obligatoire" v-if="naissance==''">*</span>
          <input type="date" class="form-control" v-bind:value="naissance" v-on:input="$emit('naissance',$event.target.value)">
        </div>
      </div>
      <div class="row">
        <div class="form-group forminscription col-md-4">
          <label for="adresse" >Adresse</label>
          <span class="obligatoire" v-if="adresse==''">Champ obligatoire</span>
          <textarea name="adresse" class="form-control" v-bind:value="adresse" v-on:input="$emit('adresse',$event.target.value)"/>
        </div>
        <div class="form-group forminscription col-md-3">
          <label for="codepostal" >Code Postal</label>
          <span class="obligatoire" v-if="codepostal==''">Champ obligatoire</span>
          <input name="codepostal" type="text" class="form-control" v-bind:value="codepostal" v-on:input="$emit('codepostal',$event.target.value)" />
        </div>
        <div class="form-group forminscription col-md-3">
          <label for="ville" >Ville</label>
          <span class="obligatoire" v-if="ville==''">Champ obligatoire</span>
          <input name="ville" type="text" class="form-control" v-bind:value="ville" v-on:input="$emit('ville',$event.target.value)"/>
        </div>
      </div>
      <div class="row">
        <div class="form-group forminscription">
          <label for="email" >Email</label>
          <span class="obligatoire" v-if="email==''">Champ obligatoire</span>
          <input name="email" type="email" class="form-control" v-bind:value="email" id="email" v-on:input="$emit('email',$event.target.value)"/>        
        </div>
      </div>
      <div class="row">
        <div class="form-group forminscription">
          <label for="sexe" >Sexe</label>
          <span class="obligatoire" v-if="sexe==-1">Champ obligatoire</span>
          <div>
            <input type="radio" name="sexe" value="1" v-on:input="$emit('sexe',$event.target.value)" v-bind:checked="sexe=='1'"/>&nbsp;M&nbsp;
            <input type="radio" name="sexe" value="0" v-on:input="$emit('sexe',$event.target.value)" v-bind:checked="sexe=='0'"/>&nbsp;F</div>
        </div>
        <div class="form-group forminscription">
          <label for="handicap" >Votre enfant présente t'il un handicap</label>
          <span class="obligatoire" v-if="handicap==-1">Champ obligatoire</span>
          <div>
            <input type="radio" name="handicap" value="1" v-on:input="$emit('handicap',$event.target.value)" v-bind:checked="handicap=='1'"/>&nbsp;Oui&nbsp;
            <input type="radio" name="handicap" value="0" v-on:input="$emit('handicap',$event.target.value)" v-bind:checked="handicap=='0'"/>&nbsp;Non</div>
        </div>
      </div>

  </div>
</template>

<script>

export default {
  name: 'InscriptionE1',
  props : [
    'nomenfant',
    'prenomenfant',
    'naissance',    
    'adresse',
    'codepostal',
    'ville',
    'sexe',
    'email',
    'handicap' 
  ],
  data () {
    return {
      mutnaissance:this.naissance,
      mutnomenfant:this.nomenfant,
    }
  }
}

</script>