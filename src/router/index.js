import { createRouter, createWebHistory } from 'vue-router'
//impotation des pages de views
import Home from '../views/Home.vue'
import Biens from '../views/Biens.vue'
import Apropos from '../views/Apropos.vue'

const routes = [
  
 //chemin des pages
  { path: '/', component: Home },
  { path: '/biens', component: Biens },
  { path: '/apropos', component: Apropos },

]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      }
    }
    return { top: 0 }
  }
})

export default router
