<template>
    <header class="header">
        <h2 class="header-titre">{{titrepage}}</h2> <!-- variable qui change automatiquement -->
        <div class="info-user d-flex align-items-center">

      <span>{{ utilisateur.nom }} ({{ utilisateur.role }})</span>

           <!-- Icône de déconnexion avec un tooltip -->
<i class="fas fa-sign-out-alt me-1 ms-2 logout-icon" 
   data-bs-toggle="tooltip" 
   data-bs-placement="bottom" 
   title="Déconnexion"
   @click="logout"
   role="button">
</i>
    </div>
        
    </header>
</template>

<script setup>
    import { computed } from "vue";
import { useRoute } from "vue-router"; // info sur la route actuelle où l'utilisateur est entrain de cliquer

const route =useRoute() // utilisation de useroute pour obtenir l'objet route ki contient plein d'infos comme route.path , name ...

    //associer les routes à un titre de la page à afficher
    const titres = {
        
      //partie admin
    '/admin/tableaubord':'Tableau de bord Administrateur',
    '/admin/biens':'Biens',
    '/admin/utilisateurs':'Gestion des Utilisateurs',
    '/admin/agentdashadmin':'Gestion des agents',
    '/admin/statistiques':'Vu Globale sur les statistiques',
    '/admin/rapports':'Rapports',

    //partie agents
    '/agent/biens':'Mes biens',
    '/agent/visites':'Visites à venir',
    '/agent/reservations':'Réservations',

    }
    

// Simulation d'utilisateur connecté

import { useUserStore } from '../stores/user'

const userStore = useUserStore()
const utilisateur = computed(() => userStore.user)

const logout = () => {
  userStore.logout()
  window.location.href = '/' // retour vers l’accueil ou page login
}
    
    const titrepage = computed(() => titres[route.path] || 'Bienvenue sur application Dev-Immo')


    import { onMounted } from 'vue'

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
  display: flex;
  align-items: center;
  padding-left: 30px;
  background-color: #ffffff;
  position: sticky;
  top: 0;
  z-index: 500;
margin-left: 60px;
justify-content: space-between;
}
.header-titre {

  font-size: 22px;
  font-weight: bold;
  color: black;
}
.logout-icon {
  font-size: 20px;
  color: #333;
  cursor: pointer;
  transition: color 0.2s ease;
}

.logout-icon:hover {
  color: #dc3545; /* rouge au survol */
}


</style>
