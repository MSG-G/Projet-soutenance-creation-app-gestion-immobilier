<template>
  <div class="container py-5">
    <div class="row align-items-center">
      <!-- Chiffres à gauche -->
      <div class="col-md-3 text-start pe-md-5 stat-column stat-left">
        <div
          v-for="(item, index) in leftStats"
          :key="index"
          class="mb-4 stat-item"
        >
          <h3 class="stat-number">{{ animatedValues[index] }}+</h3>

          <p>{{ item.label }}</p>
        </div>
      </div>

      <!-- Texte central -->
      <div class="col-md-6 text-center">
        <h1 class="display-5 fw-bold text-dark mb-3">
          TROUVER LE BIEN IMMOBILIER DE VOS RÊVES
        </h1>
        <p class="mb-4">
          Explorez Des Milliers De Propriétés À Travers Le Pays  <strong class="text-primary">Dev-IMMO</strong> - Votre 
          Destination Immobiliére De Choix
        </p>
        <router-link to="/biens" class="btn btn-primary btn-lg">
          Trouver des propriétés
        </router-link>
      </div>

      <!-- Chiffres à droite -->
      <div class="col-md-3 text-end ps-md-5 stat-column stat-right">
        <div
          v-for="(item, index) in rightStats"
          :key="index + 2"
          class="mb-4 stat-item"
        >
          <h3 class="stat-number">{{ animatedValues[index + 2] }}+</h3>

          <p>{{ item.label }}</p>
        </div>
      </div>
    </div>
  </div>
  <div>
    <!-- ton contenu d'accueil -->
    <Galerie />
  </div>
  <div>
  <!-- Section clients -->
   <client />
  </div>
  <div>
  <!-- vedette -->
   <vedette />
  </div>
  <div>
  <!-- vision -->
   <vision />
  </div>
<div>
  <!-- footer -->
   <pied />
  </div>
  
  
 
</template>

<script setup>
import client from '@/components/client.vue'
import vedette from '@/components/vedette.vue'
import vision from '@/components/vision.vue'
import pied from '@/components/pied.vue'

import { ref, onMounted } from 'vue'
import Galerie from '@/components/Galerie.vue'



const leftStats = [
  { value: 100, label: 'Appartements vendus' },
  { value: 1000, label: 'Clients satisfaits' }
]
const rightStats = [
  { value: 250, label: 'Maisons louées' },
  { value: 1200, label: 'Propriétés répertoriées' }
]

const animatedValues = ref([0, 0, 0, 0])

onMounted(() => {
  const duration = 3000 
  const steps = 100 

  leftStats.concat(rightStats).forEach((stat, index) => {
    const end = stat.value
    const increment = end / steps
    let current = 0
    const interval = setInterval(() => {
      current += increment
      animatedValues.value[index] = Math.min(Math.round(current), end)
      if (current >= end) clearInterval(interval)
    }, duration / steps)
  })
})

</script>

<style scoped>
.stat-column {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.stat-left {
  align-items: flex-start;
  animation: slideLeft 1s ease forwards;
}
.stat-right {
  align-items: flex-end;
  animation: slideRight 1s ease forwards;
}
.stat-item {
  opacity: 0;
  animation: fadeIn 1s ease forwards;
  animation-delay: 0.3s;
}
.stat-number {
  color: #000;
  font-size: 2rem;
  font-weight: bold;
  transform: scale(1.1);
  transition: transform 0.3s ease;
}
.stat-number:hover {
  transform: scale(1.2);
}

@keyframes slideLeft {
  from {
    transform: translateX(-40px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideRight {
  from {
    transform: translateX(40px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }

}
</style>
