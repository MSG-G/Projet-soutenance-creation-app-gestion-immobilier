<template>
  <aside class="sidebar d-flex flex-column justify-content-between">
    <!-- Haut: Logo + Menu -->
    <div>
      <div class="logo-bar">
          <router-link to="/admin" class="logo-link">
            <h1 class="titre">DEV-IMMO</h1>
          </router-link>
      </div>

      <ul class="menuside">
        <!-- Menu dynamique avec boucle -->
        <li v-for="item in menuItems" :key="item.path" :class="{ actif: isActive(item.path) }">
          <router-link :to="item.path" class="menu-link" exact>
            <component :is="item.icon" class="icondash" />
            <span class="link-text">{{ item.label }}</span>
          </router-link>
        </li>
      </ul>
    </div>

    <!-- Bas : Paramètres -->
    <div class="rapport">
      <router-link to="/admin/parametres" class="menu-link" :class="{ actif: isActive('/admin/parametres') }" exact>
        <Settings class="icondash" />
        <span class="link-text">Paramètres</span>
      </router-link>
    </div>
  </aside>
</template>

<script setup>
import { useRoute } from 'vue-router'
import {
  Grid, Users, Home, User, BarChart2, FileText,
  FileSignature, Calendar, MessageCircle, Bell, Settings, MapPin, Layers
} from 'lucide-vue-next'

const route = useRoute()
const isActive = (path) => route.path === path

const menuItems = [
  { path: '/admin/biens', label: 'Biens immobiliers', icon: Home },
  
  { path: '/admin/contrats', label: 'Contrats', icon: FileText },
  { path: '/admin/proprietaires', label: 'Propriétaires', icon: User },
  { path: '/admin/locataires', label: 'Locataires', icon: Users },
  { path: '/admin/reservations', label: 'Reservations', icon: Calendar },
  { path: '/admin/utilisateurs', label: 'Utilisateurs', icon: User },
  { path: '/admin/villes', label: 'Villes', icon: MapPin },
  { path: '/admin/types-bien', label: 'Types de bien', icon: Layers },
  { path: '/admin/statistiques', label: 'Statistiques', icon: BarChart2 },
  
]
</script>
<style scoped>
.sidebar {
  width: 260px;
  background: linear-gradient(to bottom, #290ce6, #483d8b);
  height: 100vh;
  color: white;
  position: fixed;
  z-index: 1000;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: width 0.3s ease-in-out;
}
.logo-bar {
  background-color: #5c50e7;
  padding: 20px;
  text-align: center;
  user-select: none;
}
.titre {
  margin: 0;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  color: white;
}
.menuside {
  list-style: none;
  margin: 0;
  padding: 0;
}
.menuside li {
  width: 100%;
  transition: background 0.3s ease;
}
.menu-link {
  padding: 14px 24px;
  display: flex;
  align-items: center;
  gap: 12px;
  color: #ffffff;
  text-decoration: none;
  font-size: 17px;
  font-weight: 500;
  position: relative;
  transition: background-color 0.3s ease, padding-left 0.3s ease;
  user-select: none;
}
.menu-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  padding-left: 30px;
}
.menu-link .link-text {
  transition: transform 0.3s ease, opacity 0.3s ease;
}
.menu-link:hover .link-text {
  transform: translateX(3px);
  opacity: 0.95;
}
.icondash {
  width: 22px;
  height: 22px;
  transition: transform 0.3s ease, color 0.3s ease;
  color: white;
}
.menu-link:hover .icondash {
  transform: scale(1.15) rotate(-2deg);
  color: #aab6fe;
}
.actif .menu-link,
.menu-link.router-link-exact-active {
  background-color: rgba(255, 255, 255, 0.15);
  font-weight: 600;
  border-left: 4px solid #ffffff;
}
.rapport {
  padding: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.15);
}
.rapport .menu-link {
  font-weight: 500;
  padding-left: 24px;
}
@media (max-width: 768px) {
  .sidebar {
    width: 70px;
  }
  .titre {
    font-size: 0;
  }
  .menuside li .link-text,
  .rapport .link-text {
    display: none;
  }
  .menu-link {
    justify-content: center;
    padding: 14px 0;
  }
}
.logo-link {
  text-decoration: none;
  color: inherit;
  display: inline-block;
  width: 100%;
}
.logo-link:hover .titre {
  color: #dcdcff;
  transform: scale(1.03);
}
</style>