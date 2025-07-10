// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '../stores/user'

// Pages d'authentification
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import Contact from '../views/Contact.vue'

// Layouts et dashboards
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

      if (!user) return '/login' // Redirige vers login si non connecté

      if (user.role === 'admin') return '/admin/tableaubord'
      if (user.role === 'agent') return '/agent/biens'

      return '/login'
    }
  },

  // Routes d'authentification
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/forgot-password', component: ForgotPassword },
  { path: '/contact', component: Contact },

  // Admin
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

  // Agent
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

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Guard pour la sécurité selon le rôle
router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  const user = userStore.user

  if (!user) return next() // Autorise la navigation tant que l’utilisateur n’est pas défini

  if (to.path.startsWith('/admin') && user.role !== 'admin') {
    return next('/agent/biens')
  }

  if (to.path.startsWith('/agent') && user.role !== 'agent') {
    return next('/admin/tableaubord')
  }

  next()
})

export default router
