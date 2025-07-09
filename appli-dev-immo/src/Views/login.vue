<template>
  <div class="login-container">
    <h2>Connexion</h2>

    <div class="error" v-if="error">{{ error }}</div>

    <!-- Champ utilisateur -->
    <input
      type="text"
      v-model="username"
      placeholder="Nom d'utilisateur"
    />
<!-- Champ mot de passe -->
    <input
      type="password"
      v-model="password"
      placeholder="Mot de passe"
    />

    <!-- Case à cocher sur la même ligne -->
    <div class="remember-line">
      <input type="checkbox" id="remember" v-model="rememberMe" />
      <label for="remember">Se souvenir de moi</label>
      <router-link to="/forgot-password" class="conn">Mot de passe oublié</router-link> |
    </div>
<!-- Bouton -->
    <button @click="login">Se connecter</button>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
      rememberMe: false,
      error: "",
    };
  },
mounted() {
    const savedUser = localStorage.getItem("rememberedUser");
    if (savedUser) {
      this.username = savedUser;
      this.rememberMe = true;
    }
  },
  methods: {
    login() {
      if (!this.username || !this.password) {
        this.error = "Tous les champs sont obligatoires.";
      } else {
        this.error = "";

        // Stockage si la case est cochée
        if (this.rememberMe) {
          localStorage.setItem("rememberedUser", this.username);
        } else {
localStorage.removeItem("rememberedUser");
        }

        alert("Connexion réussie !");
        // Ici, tu peux rediriger ou appeler ton API
      }
    },
  },
};
</script>
<style scoped>
.login-container {
  max-width: 380px;
  margin: 80px auto;
  padding: 30px;
  border: 2px solid #3498db;
  border-radius: 12px;
  background: color #007bff;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  margin: 12px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
}
button {
  width: 50%;
  padding: 10px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 10px;
  margin-left: 25%;
}
button:hover {
  background-color: #2980b9;
}

.error {
  color: red;
  text-align: center;
  font-size: 0.9em;
  margin-bottom: 10px;
}

.remember-line {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.9em;
  margin-top: 5px;
}
.conn {
margin-left: 20%;
}
</style>