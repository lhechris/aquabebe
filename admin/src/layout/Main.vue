<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light container">
  <a class="navbar-brand" href="#"><!--<img class="img-responsive" width="507" height="115" src="../assets/logo_site.gif" />--></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <router-link class="nav-link" to="/">Accueil </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/adherents">Adhérents</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/creneaux">Créneaux</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/mailing">Mailing</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/documentation">Documentation</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/pages">Pages</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/parametres">Parametres</router-link>
      </li>
    </ul>
  </div>
</nav>
</template>