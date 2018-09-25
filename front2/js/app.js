
var router = new VueRouter({
    routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
   /* {
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
      path: '/Faq',
      name: 'Faq',
      component: Faq
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
    },*/    
    
  ]
})


var app = new Vue({
    el: '#app',
    router,
  })
