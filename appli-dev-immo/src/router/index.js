// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '../stores/user'

// Pages d'authentification
import Login from '../Views/login/login.vue'
import Register from '../Views/login/Register.vue'
import ForgotPassword from '../Views/login/ForgotPassword.vue'
import Contact from '../views/Contact.vue'

// Layouts et dashboards
import AdminLayout from '../Layouts/AdminLayout.vue'
import AgentLayout from '../Layouts/AgentLayout.vue'

// Vues Admin
import TableauBord from '../Views/admin/TableauBord.vue'
import BiensDash from '../Views/admin/BiensDash.vue'
import Utilisateurs from '../Views/admin/Utilisateurs.vue'
import Proprietaires from '../Views/admin/Proprietaires.vue'
import ReservationsAdmin from '../views/admin/Reservations.vue'
import Statistiques from '../Views/admin/Statistiques.vue'
import Rapports from '../Views/admin/Rapports.vue'
import Parametre from '../Views/admin/Parametre.vue'

// Vues Agent
import BiensAgents from '../views/BiensAgents.vue'
import Visites from '../views/Visite.vue'
import ReservationsAgent from '../views/agent/Reservations.vue'

const routes = [
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

  // Routes Admin
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      { path: '', name: 'AdminHome', component: TableauBord },
      { path: 'tableaubord', name: 'TableauBord', component: TableauBord },
      { path: 'proprietaires', name: 'Proprietaires', component: Proprietaires },
      { path: 'biens', name: 'BiensDash', component: BiensDash },
      { path: 'reservations', name: 'ReservationsAdmin', component: ReservationsAdmin },
      { path: 'utilisateurs', name: 'Utilisateurs', component: Utilisateurs },
      { path: 'statistiques', name: 'Statistiques', component: Statistiques },
      { path: 'rapports', name: 'Rapports', component: Rapports },
      { path: 'parametre', name: 'Parametre', component: Parametre },
      { path: 'parametres', redirect: { name: 'Parametre' } }
    ]
  },

  // Routes Agent
  {
    path: '/agent',
    component: AgentLayout,
    children: [
      { path: 'biens', name: 'BiensAgents', component: BiensAgents },
      { path: 'visites', name: 'Visites', component: Visites },
      { path: 'reservations', name: 'ReservationsAgent', component: ReservationsAgent }
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

  if (!user) return next() // Autorise navigation tant que user non défini

  if (to.path.startsWith('/admin') && user.role !== 'admin') {
    return next('/agent/biens')
  }

  if (to.path.startsWith('/agent') && user.role !== 'agent') {
    return next('/admin/tableaubord')
  }

  next()
})

export default router
