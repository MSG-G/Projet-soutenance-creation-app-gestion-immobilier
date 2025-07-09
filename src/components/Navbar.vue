<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid px-5">
      <!-- Logo gauche -->
      <router-link to="/" class="navbar-brand d-flex align-items-center">
        <img src="@/assets/logoprojet.jpg" alt="" height="89" class="me-2" />
        
      </router-link>

      <!-- Toggle menu mobile -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent"
        aria-controls="navbarContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      
      <div class="collapse navbar-collapse" id="navbarContent">
        
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/" class="nav-link">Accueil</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/biens" class="nav-link">Biens</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/apropos" class="nav-link">À propos</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/contact" class="nav-link">Contact</router-link>
          </li>
        </ul>

        
        <div class="d-flex">
          <router-link to="/login" class="btn btn-outline-primary me-2">Connexion</router-link>
          <router-link to="/register" class="btn btn-primary">S'inscrire</router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>

</script>

<style scoped>

</style>
