<template>
  <aside class="sidebar d-flex flex-column justify-content-between">
    <!-- Haut -->
    <div>
      <div class="logo-bar">
        <h1 class="Titre">DEV-IMMO</h1>
      </div>

      <ul class="menuside w-100 ps-0">
        <li :class="{ actif: isActive('/admin/tableaubord') }">
          <router-link to="/admin/tableaubord">
            <img :src="tabIcon" alt="" class="icondash me-2" />
            Tableau de bord
          </router-link>
        </li>

        <li :class="{ actif: isActive('/admin/agentdashadmin') }">
          <router-link to="/admin/agentdashadmin">
            <img :src="agentIcon" alt="" class="icondash me-2" />
          Agents
          </router-link>
        </li>

        <li :class="{ actif: isActive('/admin/biens') }">
          <router-link to="/admin/biens">
            <img :src="bienIcon" alt="" class="icondash me-2" />
            Biens
          </router-link>
        </li>

        <li :class="{ actif: isActive('/admin/utilisateurs') }">
          <router-link to="/admin/utilisateurs">
            <img :src="useIcon" alt="" class="icondash me-2" />
            Utilisateurs
          </router-link>
        </li>

        <li :class="{ actif: isActive('/admin/statistiques') }">
          <router-link to="/admin/statistiques">
            <i class="fas fa-chart-line me-2 icondash "></i>
            statistiques
          </router-link>
        </li>
      </ul>
    </div>

    <!-- Bas : Rapports -->
    <div class="rapport">
      <router-link to="/admin/rapports" :class="{ actif: isActive('/admin/rapports') }">
       <i class="far fa-file-alt me-2 icondash"></i>
       Rapports
      </router-link>
    </div>
  </aside>
</template>

<script setup>

import { useRoute } from 'vue-router'

import tabIcon from '../assets/tab.svg'
import agentIcon from '../assets/agent.svg'
import bienIcon from '../assets/bien.svg'
import useIcon from '../assets/utilisateur.svg'

const route = useRoute()

// Fonction pour détecter si une route est active
const isActive = (path) => route.path === path
</script>

<style scoped>
.sidebar {
  width: 50vh;
  background-color: blue;
  height: 100vh;
  color: white;
  position: fixed;
  z-index: 1000;
}

.Titre {
  margin: 0;
  padding: 20px;
  padding-left:25px;
  font-size: 30px;
}

.logo-bar {
  background-color: #876cff;
  width: 100%;

}

.menuside {
  list-style: none;
  margin: 0;
  padding-left: 0;
}

.menuside li a,
.rapport a {
  padding: 15px 20px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: large;
  color: white;
  text-decoration: none;
  font-size: 25px; 
  
}


.icondash {
  width: 26px;
  height: 26px;
}

.router-link-exact-active,
.actif {
  background-color: #5e4adb;
  
}

.rapport{
  width: 100%;
  padding: 15px 20px;
}
</style>
