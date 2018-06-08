<template>
  <div id="app">
    <main-layout></main-layout>    
    <router-view/>    
    <main-footer></main-footer>
  </div>
</template>

<script>
import MainLayout from './layout/Main.vue'
import MainFooter from './components/footer.vue'

export default {
  name: 'App',
  components: { MainLayout,MainFooter}
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
</style>
