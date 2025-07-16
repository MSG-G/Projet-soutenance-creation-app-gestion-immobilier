<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <router-link class="navbar-brand d-flex align-items-center" to="/">
        <img src="@/assets/logoprojet.jpg" alt="Dev Immo Logo" class="logo-navbar me-2" />
        <span class="fw-bold text-primary">DEV-IMMO</span>
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="/public">Accueil</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/public/biens">Biens</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/public/apropos">À propos</router-link>
          </li>
          
        </ul>
        <div class="d-flex ms-2">
          <!-- Si l'utilisateur n'est pas connecté -->
          <router-link v-if="!userStore.user" to="/login" class="btn btn-outline-primary ms-2">Connexion</router-link>

          <!-- Si l'utilisateur est connecté -->
          <div v-else class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ userStore.user.name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><router-link class="dropdown-item" to="/admin/tableaubord">Tableau de bord</router-link></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#" @click.prevent="logout">Se déconnecter</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useUserStore } from '@/stores/user';
import { useRouter } from 'vue-router';

const userStore = useUserStore();
const router = useRouter();

const logout = () => {
  userStore.logout();
  router.push('/');
};
</script>

<style scoped>
.logo-navbar {
  height: 40px;
  border-radius: 6px;
}
.navbar {
  font-size: 1.1rem;
  letter-spacing: 0.5px;
}
.nav-link {
  color: #333;
  margin-right: 12px;
  transition: color 0.15s;
}
.nav-link.router-link-exact-active,
.nav-link:hover {
  color: #007bff;
  font-weight: bold;
}
</style>
