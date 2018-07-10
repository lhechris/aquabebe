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
</style>
