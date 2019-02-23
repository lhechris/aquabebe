<template>
<div class="container">
  <div v-html="msg"></div>  
</div>
</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'

export default {
  name: 'Utilisateur',
  props : {
    pname : String
  },
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
  updated: function() {
      this.get()
  },
  
   methods:{
      get: function (){
        var api = new restapi();
        var self=this;
        api.getPage(this.pname).then(response=>{self.msg=response; })
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
