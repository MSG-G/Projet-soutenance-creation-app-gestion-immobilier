<template>
  <div class="barrehaut">
    <!-- slide de navigation -->
    <SidebarAgents/>

    <!-- les pages -->
    <div class="main-contenu">
      <HeaderDash />

      <!-- Contenu dynamique avec scroll -->
      <div class="page-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import HeaderDash from "../components/HeaderDash.vue"
import SidebarAgents from "../components/SidebarAgents.vue";
</script>

<style scoped>
.barrehaut {
  display: flex;
  height: 100vh;
  overflow: hidden;
}

/* Conteneur principal à droite du sidebar */
.main-contenu {
  display: flex;
  flex-direction: column;
  width: calc(100% - 250px); /* Largeur du sidebar */
  margin-left: 250px;
  height: 100vh;
}

/* Zone de contenu avec scroll */
.page-content {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
  background-color: #f9f9f9;
}
</style>
