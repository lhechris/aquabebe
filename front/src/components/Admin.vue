<template>
<div class="container" >
<p>{{afficher}}</p>
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Admin',
  components: {
      MainLayout
  },
  data () {
    return {
      afficher:"Bidule"

    }
  },
  created: function() {
      this.post()
  },
  
   methods:{
      post: function (){
        var api = new restapi();
        var self=this;
        api.postAdmin().then(response=>{
          self.afficher=response;
          api.getHello();
        })
    }
  }

}
</script>

