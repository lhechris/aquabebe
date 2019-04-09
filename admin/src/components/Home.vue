<template>
<div class="container">
    <div>
      <p>Bienvenue sur la page d'administration</p>
      <coordonnees></coordonnees>
    </div>
</div>
</template>

<script>

import Coordonnees from './Coordonnees';

export default {
  name: 'Home',
  components:{Coordonnees},
  
}
</script>
