<template>
  <div class="forgot-password-container">
    <h2>Mot de passe oublié?</h2>
    <p>
      Veuillez saisir votre email de connexion afin de recevoir le lien de réinitialisation de votre mot de passe.
    </p>

    <form @submit.prevent="sendResetLink">
      <label for="email">Email de connexion</label>
      <input
        type="email"
        id="email"
        v-model="email"
        placeholder="Saisir votre email"
        required
      />

      <button type="submit" class="btn">Recevoir le lien</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: ''
    };
  },
  methods: {
    sendResetLink() {
      if (!this.email) {
        alert("Veuillez entrer votre email.");
        return;
      }
      // Simuler l'envoi du lien de réinitialisation
      alert(`Lien de réinitialisation envoyé à ${this.email}`);
    }
  }
};
</script>

<style scoped>
.forgot-password-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  text-align: center;
}

h2 {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 10px;
}

p {
  font-size: 14px;
  margin-bottom: 20px;
  color: #333;
}

label {
  display: block;
  text-align: left;
  margin-bottom: 5px;
  font-weight: 500;
}

input {
  width: 50%;
  padding: 12px;
  border: 2px solid #0055ff;
  border-radius: 50px;
  margin-bottom: 15px;
  outline: none;
  margin-right: 50%;
  margin-top: 15px;
}

.btn {
  width: 50%;
  padding: 12px;
  background-color: #0055ff;
  color: white;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 15px;
}

.btn:hover {
  background-color: #0040cc;
}
.forgot-password-container {
  max-width: 500px;
  margin: 50px auto;
  padding: 30px;
  border: 2px solid #3498db;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  height:300px;
}
</style>
