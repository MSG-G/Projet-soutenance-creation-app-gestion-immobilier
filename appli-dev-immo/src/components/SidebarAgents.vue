<template>
  <aside class="sidebar d-flex flex-column justify-content-between">
    <!-- Haut -->
    <div>
      <div class="logo-bar">
        <h1 class="Titre">DEV-IMMO</h1>
      </div>

      <ul class="menuside w-100 ps-0">
        <li :class="{ actif: isActive('/agent/biens') }">
          <router-link to="/agent/biens">
            <img :src="bienIcon" alt="" class="icondash me-2" />
            Mes biens
          </router-link>
        </li>

        <li :class="{ actif: isActive('/agent/reservations') }">
          <router-link to="/agent/reservations">
            <img :src="reservationIcon" alt="" class="icondash me-2" />
         Réservation
          </router-link>
        </li>

        <li :class="{ actif: isActive('/agent/visites') }">
          <router-link to="/agent/visites">
      <i class="fas fa-calendar-check me-2 icondash text-dark  "></i>
            Visites
          </router-link>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script setup>

import { useRoute } from 'vue-router'


import bienIcon from '../assets/bien.svg'
import reservationIcon from '../assets/reservation.svg'


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

.menuside li a{
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
</style>
