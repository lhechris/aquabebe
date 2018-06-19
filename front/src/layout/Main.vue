<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light container">
  <a class="navbar-brand" href="#"><img class="img-responsive" width="507" height="115" src="../assets/logo_site.gif"></img></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <router-link class="nav-link" to="/">Accueil <span class="sr-only">(current)</span></router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/acces">Accès</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/tarifs">Tarifs</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/creneaux">Créneaux</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/Faq">FAQ</router-link>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Espace Abonné
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <router-link class="dropdown-item" to="/Inscription">Inscrire un enfant</router-link>
          <a class="dropdown-item" href="#">Planning</a>
          <a class="dropdown-item" href="#">Réservé Administration</a>
        </div>
      </li>      
    </ul>
  </div>
</nav>
</template>