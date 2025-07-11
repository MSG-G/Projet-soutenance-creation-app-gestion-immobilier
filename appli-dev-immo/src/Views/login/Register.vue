<template>
  <div class="register-container">
    <div class="form-box animate__animated animate__fadeInDown">
      <h2 class="text-center mb-3">Créer un compte</h2>

      <div class="error" v-if="error">{{ error }}</div>

      <input
        type="text"
        v-model="username"
        placeholder="Nom d'utilisateur"
      />

      <input
        type="email"
        v-model="email"
        placeholder="Adresse email"
      />

      <input
        type="password"
        v-model="password"
        placeholder="Mot de passe"
      />

      <input
        type="password"
        v-model="confirmPassword"
        placeholder="Confirmer le mot de passe"
      />

      <button @click="register">S'inscrire</button>

      <div class="divider">
        <span>ou</span>
      </div>

      <button class="btn-google" @click="connectGoogle">
        <i class="fab fa-google me-2"></i> Continuer avec Google
      </button>

      <button class="btn-facebook" @click="connectFacebook">
        <i class="fab fa-facebook me-2"></i> Continuer avec Facebook
      </button>

      <p class="text-center mt-3">
        Déjà inscrit ?
        <router-link to="/login" class="link-primary">Se connecter</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data() {
    return {
      username: '',
      email: '',
      password: '',
      confirmPassword: '',
      error: ''
    }
  },
  methods: {
    register() {
      if (!this.username || !this.email || !this.password || !this.confirmPassword) {
        this.error = "Veuillez remplir tous les champs.";
        return;
      }

      if (this.password !== this.confirmPassword) {
        this.error = "Les mots de passe ne correspondent pas.";
        return;
      }

      this.error = "";
      alert("Inscription réussie !");
      // Envoie vers API plus tard
    },
    connectGoogle() {
      alert("Connexion avec Google - à implémenter avec Firebase.");
    },
    connectFacebook() {
      alert("Connexion avec Facebook - à implémenter.");
    }
  }
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f4f8;
}

.form-box {
  background-color: white;
  padding: 35px;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 420px;
}

input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border-radius: 6px;
  border: 1.5px solid #ccc;
  transition: all 0.3s ease;
}

input:focus {
  border-color: #0d6efd;
  outline: none;
  box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
}

button {
  width: 100%;
  padding: 12px;
  margin-top: 10px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

button:hover {
  transform: translateY(-1px);
}

button:active {
  transform: scale(0.98);
}

button:not(.btn-google):not(.btn-facebook) {
  background-color: #0d6efd;
  color: white;
}

.btn-google {
  background-color: #fff;
  border: 1.5px solid #ccc;
  color: #444;
}

.btn-google:hover {
  background-color: #f1f1f1;
}

.btn-facebook {
  background-color: #3b5998;
  color: white;
}

.btn-facebook:hover {
  background-color: #2d4373;
}

.divider {
  display: flex;
  align-items: center;
  text-align: center;
  margin: 15px 0;
}

.divider::before,
.divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background-color: #ccc;
}

.divider span {
  margin: 0 10px;
  color: #777;
  font-size: 0.9em;
}

.error {
  color: red;
  text-align: center;
  font-size: 0.9em;
  margin-bottom: 10px;
}
</style>
