<template>
  <header class="header d-flex justify-content-between align-items-center px-4 shadow-sm">
    <!-- Titre dynamique -->
    <h2 class="titre-page m-0">{{ titrepage }}</h2>

    <!-- Gestion types/villes + Infos utilisateur -->
    <div class="info-user d-flex align-items-center gap-3">
            <span v-if="utilisateur" class="user-info">
        {{ utilisateur.nom }} <small class="text-muted">({{ utilisateur.role }})</small>
      </span>
      <span v-else class="text-muted">Invité</span>

      <!-- Déconnexion -->
      <i class="fas fa-sign-out-alt logout-icon"
         data-bs-toggle="tooltip"
         data-bs-placement="bottom"
         title="Déconnexion"
         @click="logout"
         role="button"
      ></i>
    </div>


  </header>
</template>

<script setup>
import { computed, ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useUserStore } from '../stores/user'


const route = useRoute()
const userStore = useUserStore()
const utilisateur = computed(() => userStore.user)

const titres = {
  // admin
  '/admin/tableaubord': 'Tableau de bord',
  '/admin/biens': 'Biens immobiliers',
  '/admin/utilisateurs': 'Utilisateurs',
  '/admin/agentdashadmin': 'Gestion des agents',
  '/admin/statistiques': 'Statistiques',
  '/admin/rapports': 'Rapports',
  '/admin/parametres': 'Paramètres',
  // agent
  '/agent/biens': 'Mes biens',
  '/agent/visites': 'Visites',
  '/agent/reservations': 'Réservations',
}
const titrepage = computed(() => titres[route.path] || 'Bienvenue sur DEV-IMMO')
const logout = () => {
  userStore.logout()
  window.location.href = '/'
}

// Tooltip Bootstrap
onMounted(() => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  tooltipTriggerList.forEach(el => {
    new bootstrap.Tooltip(el)
  })
})

</script>

<style scoped>
.header {
  height: 70px;
  background-color: #fff;
  border-bottom: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  z-index: 100;
}

.titre-page {
  font-size: 20px;
  font-weight: 600;
  color: #2c3e50;
}

.info-user {
  font-size: 14px;
  color: #333;
}

.logout-icon {
  font-size: 18px;
  color: #495057;
  transition: all 0.2s ease;
}

.logout-icon:hover {
  color: #e74c3c;
  transform: scale(1.1) rotate(-5deg);
  transition: transform 0.2s ease, color 0.2s ease;
}

@media (max-width: 768px) {
  .titre-page {
    font-size: 16px;
  }

  .info-user {
    font-size: 12px;
    gap: 1rem;
  }
}
.custom-modal-overlay {
  position: fixed;
  left: 0; top: 0;
  width: 100vw; height: 100vh;
  background: rgba(0,0,0,0.4);
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
}
.custom-modal-content {
  background: #fff;
  border-radius: 10px;
  max-width: 700px;
  width: 100%;
  box-shadow: 0 2px 32px rgba(0,0,0,0.19);
  animation: popin .25s;
}
@keyframes popin {
  from { transform: scale(0.95); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}
</style>
