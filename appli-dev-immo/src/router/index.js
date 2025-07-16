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
import Parametre from '../Views/admin/Parametre.vue'

// Vues Agent
import BiensAgents from '../views/agent/BiensDash.vue'

import Visites from '../views/Visite.vue'
import ReservationsAgent from '../views/agent/Reservations.vue'

const routes = [
  {
    path: '/public',
    name: 'PagePublic',
    component: () => import('../views/PagePublic.vue')
  },
  {
    path: '/public/biens',
    name: 'BiensPublic',
    component: () => import('../views/Biens.vue')
  },
  {
    path: '/public/biens/:id',
    name: 'DetailBienPublic',
    component: () => import('../views/client/DetailBien.vue')
  },
  {
    path: '/public/apropos',
    name: 'AproposPublic',
    component: () => import('../views/Apropos.vue')
  },
  {
    path: '/public/contact',
    name: 'ContactPublic',
    component: () => import('../views/Contact.vue')
  },
  {
    path: '/reservations/create',
    name: 'ReservationCreate',
    component: () => import('../components/biens/ModalLocation.vue')
  },
  {
    path: '/',
    redirect: () => {
      const user = JSON.parse(localStorage.getItem('user'))
      if (!user) return '/login' // Redirige vers login si non connecté
      if (user.role === 'admin') return '/admin/tableaubord'
      if (user.role === 'agent') return '/agent/biens'
      if (user.role === 'client') return '/client/dashboard'
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
      { path: 'locataires', name: 'Locataires', component: () => import('@/Views/admin/Locataires.vue') },
      { path: 'biens', name: 'BiensDash', component: BiensDash },
      { path: 'biens-vendus', name: 'BiensVendus', component: () => import('@/Views/admin/BiensVendus.vue') },
      { path: 'contrats', name: 'Contrats', component: () => import('@/Views/admin/Contrats.vue') },
      { path: 'biens-loues', name: 'BiensLoues', component: () => import('@/Views/admin/BiensLoues.vue') },
      { path: 'biens/nouveau', name: 'BienFormAjout', component: () => import('@/Views/admin/BiensFormPage.vue') },
      { path: 'biens/:id/edit', name: 'BienFormEdit', component: () => import('@/Views/admin/BiensFormPage.vue') },
      { path: 'reservations', name: 'ReservationsAdmin', component: ReservationsAdmin },
      { path: 'utilisateurs', name: 'Utilisateurs', component: Utilisateurs },
      { path: 'villes', name: 'AdminVilles', component: () => import('@/Views/admin/Villes.vue') },
      { path: 'types-bien', name: 'AdminTypesBien', component: () => import('@/Views/admin/TypesBien.vue') },
      { path: 'statistiques', name: 'Statistiques', component: Statistiques },
      { path: 'parametre', name: 'Parametre', component: Parametre },
      { path: 'parametres', redirect: { name: 'Parametre' } }
    ]
  },

  // Routes Agent
  {
    path: '/agent',
    component: AgentLayout,
    children: [
      { path: '', redirect: { name: 'BiensAgents' } },
      { path: 'biens', name: 'BiensAgents', component: BiensAgents },
      { path: 'proprietaires', name: 'AgentProprietaires', component: () => import('@/Views/agent/Proprietaires.vue') },
      { path: 'photos', name: 'AgentPhotos', component: () => import('@/Views/agent/Photos.vue') },
      { path: 'reservations', name: 'ReservationsAgent', component: ReservationsAgent },
      { path: 'contrats', name: 'AgentContrats', component: () => import('@/Views/agent/Contrats.vue') },
      { path: 'notifications', name: 'AgentNotifications', component: () => import('@/Views/agent/Notifications.vue') },
      { path: 'messagerie', name: 'AgentMessagerie', component: () => import('@/Views/agent/Messagerie.vue') },
      { path: 'visites', name: 'Visites', component: Visites },
      { path: 'locataires', name: 'AgentLocataires', component: () => import('@/Views/agent/Locataires.vue') },
      { path: 'villes', name: 'AgentVilles', component: () => import('@/Views/agent/Villes.vue') },
      { path: 'types-bien', name: 'AgentTypesBien', component: () => import('@/Views/agent/TypesBien.vue') },
      { path: 'parametre', name: 'AgentParametre', component: () => import('@/Views/agent/Parametre.vue') }
    ]
  },

  // Routes Client
  {
    path: '/client',
    component: () => import('@/Layouts/ClientLayout.vue'),
    children: [
      // { path: '', redirect: { name: 'ClientDashboard' } },
      { path: 'dashboard', name: 'ClientDashboard', component: () => import('@/Views/client/ClientDashboard.vue') },
      { path: 'biens', name: 'ListeBiens', component: () => import('@/Views/client/ListeBiens.vue') },
      { path: 'biens/:id', name: 'DetailBien', component: () => import('@/Views/client/DetailBien.vue') },
      { path: 'reservations', name: 'ReservationsClient', component: () => import('@/Views/client/ReservationsClient.vue') },
      { path: 'reserver', name: 'ReservationForm', component: () => import('@/Views/client/ReservationForm.vue') },
      { path: 'notifications', name: 'NotificationsClient', component: () => import('@/Views/client/NotificationsClient.vue') },
      { path: 'messagerie', name: 'MessagerieClient', component: () => import('@/Views/client/MessagerieClient.vue') }
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
    if (user.role === 'agent') return next('/agent/biens')
    if (user.role === 'client') return next('/client/dashboard')
    return next('/login')
  }

  if (to.path.startsWith('/agent') && user.role !== 'agent') {
    if (user.role === 'admin') return next('/admin/tableaubord')
    if (user.role === 'client') return next('/client/dashboard')
    return next('/login')
  }

  if (to.path.startsWith('/client') && user.role !== 'client') {
    if (user.role === 'admin') return next('/admin/tableaubord')
    if (user.role === 'agent') return next('/agent/biens')
    return next('/login')
  }

  next()
})

export default router
