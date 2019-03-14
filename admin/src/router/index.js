import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Creneaux from '@/components/Creneaux'
import EditCreneaux from '@/components/EditCreneaux'
import Adherents from '@/components/Adherents'
import Enfant from '@/components/Enfant'
import Mailing from '@/components/Mailing'
import Documentation from '@/components/Documentation'
import Page from '@/components/Page'
import Parametres from '@/components/Parametres'
import Reservations from '@/components/Reservations'

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
      path: '/Reservations',
      name: 'Reservations',
      component: Reservations
    },
    {
      path: '/EditCreneaux',
      name: 'EditCreneaux',
      component: EditCreneaux
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
    {
      path: '/documentation',
      name: 'Documentation',
      component: Documentation
    },
    {
      path: '/pages',
      name: 'Page',
      component: Page
    },
    {
      path: '/Parametres',
      name: 'Parametres',
      component: Parametres
    },
    
  ]
})
