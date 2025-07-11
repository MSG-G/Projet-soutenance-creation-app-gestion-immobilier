<template>
  <div class="forgot-container">
    <div class="form-box animate__animated animate__fadeInDown">
      <h2 class="text-center mb-3">Mot de passe oublié</h2>

      <div class="info" v-if="message">{{ message }}</div>
      <div class="error" v-if="error">{{ error }}</div>

      <input
        type="email"
        v-model="email"
        placeholder="Entrez votre adresse email"
      />

      <button @click="envoyerLien">Envoyer le lien</button>

      <p class="text-center mt-3">
        <router-link to="/login" class="link-primary">← Retour à la connexion</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ForgotPassword',
  data() {
    return {
      email: '',
      error: '',
      message: ''
    }
  },
  methods: {
    envoyerLien() {
      if (!this.email) {
        this.error = "Veuillez saisir votre adresse email.";
        this.message = '';
        return;
      }

      this.error = '';
      this.message = "Un lien de réinitialisation a été envoyé à votre adresse email.";
      // Ici tu pourras intégrer l'appel à l'API ou Firebase
    }
  }
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

.forgot-container {
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
  padding: 12px;
  margin: 12px 0;
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
  background-color: #0d6efd;
  color: white;
  transition: all 0.3s ease;
}

button:hover {
  transform: translateY(-1px);
  background-color: #0b5ed7;
}

.error {
  color: red;
  text-align: center;
  font-size: 0.9em;
  margin-bottom: 10px;
}

.info {
  color: green;
  text-align: center;
  font-size: 0.9em;
  margin-bottom: 10px;
}

.link-primary {
  color: #0d6efd;
  text-decoration: none;
}

.link-primary:hover {
  text-decoration: underline;
}
</style>
