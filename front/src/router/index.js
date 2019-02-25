import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Creneaux from '@/components/Creneaux'
import Admin from '@/components/Admin'
import Inscription from '@/components/Inscription'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      props : {pname:"accueil"}
    },
    {
      path: '/page/:pname',
      name: 'Page',
      component: Home,
      props : true
    },    
    {
      path: '/Creneaux',
      name: 'Creneaux',
      component: Creneaux
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/inscription',
      name: 'inscription',
      component: Inscription
    },
    
    
  ]
})
