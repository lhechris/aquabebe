<template>
  <div id="app">
    <MainLayout />
    <router-view/>
  </div>
</template>

<script>
import MainLayout from './layout/Main.vue'

export default {
  name: 'app',
  components: {
    MainLayout
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.abform {
  background : linear-gradient( to right,rgba(113,183,244,0.8), rgba(255,128,128,0.3));
  border-radius : 10px;
  margin:5px;
  padding : 5px;

}
</style>
