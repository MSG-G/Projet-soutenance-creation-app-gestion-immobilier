<template>
 ely-diawara/Authentification
  <div class="app">
    <nav v-if="false">
      <router-link to="/login">Connexion</router-link> |
      <router-link to="/register">Inscription</router-link> |
      <router-link to="/forgot-password">Mot de passe oublié</router-link> |
      <router-link to="/contact">Contact</router-link>
      <!-- Tous les liens ici -->
    </nav>

    <main>
      <router-view />
    </main>
  </div>
</template>

  

<script setup>
// rien à importer ici maintenant
</script>

<style scoped>
/* Plus rien ici pour l'instant */
</style>

