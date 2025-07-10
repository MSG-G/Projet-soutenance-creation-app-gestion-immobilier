<template>
  <div class="register-container">
    <h1 class="title">Inscrivez-vous</h1>
    <p class="subtitle">
      pour découvrir les meilleures propriétés chez Dev-Immo.
    </p>

    <form @submit.prevent="register">
      <input
        v-model="fullName"
        type="text"
        placeholder="Nom complet"
        required
      />
      <input
        v-model="email"
        type="email"
        placeholder="Adresse e-mail"
        required
      />
      <input
        v-model="phone"
        type="tel"
        placeholder="Numéro de telephone"
        required
      />
      <input
        v-model="password"
        type="password"
        placeholder="Mot de passe"
        required
      />
      <input
        v-model="confirmPassword"
        type="password"
        placeholder="Confirmez le mot de passe"
        required
      />

      <button type="submit" class="btn">CREER UN COMPTE</button>
    </form>

    <p class="login-link">
      Vous avez déjà un compte?
      <a href="#" @click.prevent="login"></a>
      <router-link to="/login"> Se connecter</router-link>
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fullName: '',
      email: '',
      phone: '',
      password: '',
      confirmPassword: ''
    };
  },
  methods: {
    register() {
      if (this.password !== this.confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        return;
      }
      // Traitement de l'inscription ici (envoi au backend par exemple)
      alert('Inscription réussie !');
    },
    login() {
      // Redirection vers la page de connexion
      alert('Redirection vers la page de connexion');
    }
  }
};
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  text-align: center;
}

.title {
  font-weight: bold;
  font-size: 24px;
}

.subtitle {
  margin-bottom: 20px;
  color: #333;
}

input {
  display: block;
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #0055ff;
  border-radius: 5px;
}

.btn {
  width: 100%;
  padding: 12px;
  background-color: #0055ff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.btn:hover {
  background-color: #0040cc;
}

.login-link {
  margin-top: 15px;
  font-size: 14px;
}

.login-link a {
  color: #0055ff;
  text-decoration: none;
  font-weight: bold;
}

.login-link a:hover {
  text-decoration: underline;
}
.register-container {
  max-width: 500px;
  margin: 50px auto;
  padding: 30px;
  border: 2px solid #3498db;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  height:500px;
}
</style>
