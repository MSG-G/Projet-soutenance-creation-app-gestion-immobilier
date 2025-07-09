<template>
  <div class="contact-container">
    <h2>Contactez-nous</h2>

    <form @submit.prevent="sendMessage">
      <input
        type="text"
        v-model="form.name"
        placeholder="Votre nom"
        required
      />
      <input
        type="email"
        v-model="form.email"
        placeholder="Votre email"
        required
      />
      <textarea
v-model="form.message"
        placeholder="Votre message"
        rows="5"
        required
      ></textarea>

      <button type="submit">Envoyer</button>
    </form>

    <div class="success" v-if="successMessage">{{ successMessage }}</div>
    <div class="error" v-if="errorMessage">{{ errorMessage }}</div>
  </div>
</template>
<script>
export default {
  name: "Contact",
  data() {
    return {
      form: {
        name: "",
        email: "",
        message: "",
      },
      successMessage: "",
      errorMessage: "",
    };
  },
  methods: {
sendMessage() {
      // Exemple de validation simple
      if (!this.form.name || !this.form.email || !this.form.message) {
        this.errorMessage = "Tous les champs sont requis.";
        return;
      }

      // Simulation d'envoi
      this.successMessage = "Message envoyé avec succès !";
      this.errorMessage = "";

      // Réinitialiser le formulaire
      this.form.name = "";
      this.form.email = "";
      this.form.message = "";
    },
  },
};
</script>
<style scoped>
.contact-container {
  max-width: 500px;
  margin: 50px auto;
  padding: 30px;
  border: 2px solid #3498db;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}
h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

input,
textarea {
  width: 100%;
  padding: 10px;
  margin: 12px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 1em;
}

button {
  width: 100%;
  padding: 12px;
  background-color: #3498db;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}

.success {
  color: green;
  margin-top: 10px;
  text-align: center

}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
}
</style>