// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import DashboardAdmin from './views/DashboardAdmin.vue'

const routes = [
  { path: '/dashboard', name: 'DashboardAdmin', component: DashboardAdmin },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
