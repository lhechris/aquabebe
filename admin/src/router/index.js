import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Creneaux from '@/components/Creneaux'
import Adherents from '@/components/Adherents'
import Enfant from '@/components/Enfant'
import Mailing from '@/components/Mailing'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/Adherents',
      name: 'Adherents',
      component: Adherents
    },
    {
      path: '/Creneaux',
      name: 'Creneaux',
      component: Creneaux
    },
    {
      path: '/Enfant/:id',
      name: 'Enfant',
      component: Enfant,
      props:true
    },
    {
      path: '/Mailing',
      name: 'Mailing',
      component: Mailing
    },
    
  ]
})
