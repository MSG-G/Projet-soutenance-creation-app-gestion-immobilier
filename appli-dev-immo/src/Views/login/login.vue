<template>
  <div class="login-page d-flex align-items-center justify-content-center">
    <div class="login-card shadow-lg animated fadeInDown">
      <h2 class="text-center text-primary mb-4">Connexion</h2>
<div class="mb-3">
  <router-link to="/public" class="btn btn-outline-secondary w-100">
    Retour à l'accueil
  </router-link>
</div>
      <transition name="fade">
        <div class="error-msg text-danger text-center" v-if="error">{{ error }}</div>
      </transition>
      <form @submit.prevent="handleLogin">
        <div class="form-group mb-3 position-relative">
          <i class="fas fa-user icon-input"></i>
          <input
            v-model="email"
            type="email"
            class="form-control"
            placeholder="Email"
            required
          />
        </div>
        <div class="form-group mb-3 position-relative">
          <i class="fas fa-lock icon-input"></i>
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Mot de passe"
            required
          />
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 small">
          <router-link to="/forgot-password" class="text-decoration-none text-primary">
            Mot de passe oublié ?
          </router-link>
        </div>
        <button class="btn btn-primary w-100 mb-3" type="submit" :disabled="loading">Se connecter</button>
        <div class="text-center small">
          Vous n'avez pas de compte ?
          <router-link to="/register" class="text-decoration-none fw-semibold text-primary">Créer un compte</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../../stores/user'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)
const router = useRouter()
const userStore = useUserStore()

onMounted(() => {
  // Forcer la remise à zéro des champs même si le navigateur a autofill après un refresh
  email.value = ''
  password.value = ''
})

const handleLogin = async () => {
  error.value = ''
  loading.value = true
  try {
    const user = await userStore.login(email.value, password.value);
    if (user.role === 'admin') {
      router.push('/admin/tableaubord');
    } else if (user.role === 'agent') {
      router.push('/agent/biens');
    } else if (user.role === 'client') {
      router.push('/client/dashboard');
    } else {
      router.push('/public');
    }
  } catch (err) {
    error.value = err;
  } finally {
    // Toujours vider les champs pour plus de sécurité et éviter l'autoremplissage
    email.value = '';
    password.value = '';
    loading.value = false;
  }
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

.login-page {
  height: 100vh;
  background: linear-gradient(to bottom right, #eaf3fa, #f9fbfc);
  padding: 1rem;
}

.login-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 2.5rem;
  width: 100%;
  max-width: 420px;
  transition: all 0.3s ease;
}

.login-card:hover {
  box-shadow: 0 10px 40px rgba(74, 144, 226, 0.3);
  transform: translateY(-4px);
}

input.form-control {
  padding-left: 2.5rem;
  height: 45px;
  border-radius: 10px;
  transition: border 0.3s ease, box-shadow 0.3s ease;
}

input.form-control:focus {
  border-color: #4a90e2;
  box-shadow: 0 0 6px rgba(74, 144, 226, 0.3);
}

.icon-input {
  position: absolute;
  top: 50%;
  left: 0.9rem;
  transform: translateY(-50%);
  color: #999;
}

.error-msg {
  margin-bottom: 1rem;
}

button.btn {
  font-weight: bold;
  padding: 0.6rem;
  border-radius: 12px;
  transition: background 0.3s ease;
}

button.btn:hover {
  background-color: #357abd;
}

/* Animations */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.animated.fadeInDown {
  animation: fadeInDown 0.6s ease;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
