<template>
<div class="container">
  <div v-html="msg"></div>  
</div>
</template>

<script>
import {restapi} from '../rest';

export default {
  name: 'Coordonnees',

  data () {
    return {
      msg: 'Site Aqua Bébé'
    }
  },
  created: function() {
      this.get();
  },
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getPage('coordonnees').then(response=>{self.msg=response; })
    }
  }

}
</script>

