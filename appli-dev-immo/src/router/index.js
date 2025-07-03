// router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '../stores/user' //pour la redirection
// Importation des pages de views et layouts
import AdminLayout from '../Layouts/AdminLayout.vue'
import TableauBord from '../views/TableauBord.vue'
import AgentDashAdmin from '../views/AgentDashAdmin.vue'
import BiensDash from '../views/BiensDash.vue'
import Utilisateurs from '../views/Utilisateurs.vue'

import AgentLayout from '../Layouts/AgentLayout.vue'
import BiensAgents from '../views/BiensAgents.vue'
import Visites from '../views/Visite.vue'
import Reservations from '../views/Reservations.vue'

const routes = [
  // Redirection dynamique selon le rôle
  {
    path: '/',
    redirect: () => {
      const user = JSON.parse(localStorage.getItem('user'))

      if (!user) return '/agent/biens' // par défaut

      if (user.role === 'admin') return '/admin/tableaubord'
      if (user.role === 'agent') return '/agent/biens'

      return '/agent/biens'
    }
  },

  {
    path: '/admin',
    component: AdminLayout,
    children: [
      { path: 'tableaubord', name: 'TableauBord', component: TableauBord },
      { path: 'agentdashadmin', name: 'AgentDashAdmin', component: AgentDashAdmin },
      { path: 'biens', name: 'BiensDash', component: BiensDash },
      { path: 'utilisateurs', name: 'Utilisateurs', component: Utilisateurs },
      { path: 'statistiques', name: 'Statistiques', component: () => import('../views/Statistiques.vue') },
      { path: 'rapports', name: 'Rapports', component: () => import('../views/Rapports.vue') },
    ]
  },

  {
    path: '/agent',
    component: AgentLayout,
    children: [
      { path: 'biens', name: 'BiensAgents', component: BiensAgents },
      { path: 'visites', name: 'Visites', component: Visites },
      { path: 'reservations', name: 'Reservations', component: Reservations },
    ]
  }
]

// Créer le routeur
const router = createRouter({
  history: createWebHistory(),
  routes
})

//  Ajout de guard après avoir créé le router
router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  const user = userStore.user

  if (!user) return next() // autorise tout si l'utilisateur n'est pas encore défini

  if (to.path.startsWith('/admin') && user.role !== 'admin') {
    return next('/agent/biens')
  }

  if (to.path.startsWith('/agent') && user.role !== 'agent') {
    return next('/admin/tableaubord')
  }

  next()
})

export default router
