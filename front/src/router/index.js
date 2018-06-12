import Vue from 'vue'
import Router from 'vue-router'
import Acces from '@/components/Acces'
import Home from '@/components/Home'
import Creneaux from '@/components/Creneaux'
import Admin from '@/components/Admin'
import Inscription from '@/components/Inscription'
import Tarifs from '@/components/Tarifs'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/Acces',
      name: 'Acces',
      component: Acces
    },
    {
      path: '/tarifs',
      name: 'Tarifs',
      component: Tarifs
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
