<template>
  <footer class="footer-section">
    <div class="container">
      <div class="footer-grid">
        <!-- Logo et description -->
        <div class="footer-column">
          <img src="@/assets/logoprojet.jpg" alt="Dev Immo Logo" class="footer-logo" />
          <p class="footer-desc">
            Embarquez pour un voyage de découverte avec un aperçu complet.
            Plongez dans notre engagement envers l’excellence.
          </p>
        </div>

        <!-- Liens avec router-link -->
        <div class="footer-column">
          <h4 class="footer-title">Liens Utiles</h4>
          <ul>
            <li><router-link to="/" class="footer-link">Accueil</router-link></li>
            <li><router-link to="/biens" class="footer-link">Biens</router-link></li>
            <li><router-link to="/apropos" class="footer-link">À Propos</router-link></li>
            <li><router-link to="/contact" class="footer-link">Contact</router-link></li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="footer-column">
          <h4 class="footer-title">Entrer en Contact</h4>
          <p><i class="bi bi-geo-alt-fill me-2"></i> Avenue Galandou Diouf</p>
          <p><i class="bi bi-telephone-fill me-2"></i> +221 33 820 67 70</p>
          <p><i class="bi bi-envelope-fill me-2"></i> contact.devimmo@gmail.com</p>
        </div>

        <!-- Newsletter -->
        <div class="footer-column newsletter-column">
      <h4 class="footer-title">Newsletter</h4>
      <input type="email" v-model="email" class="newsletter-input" placeholder="Votre Email" />
      

      <button class="btn-newsletter" @click="envoyerNewsletter"  >
        <i class="bi bi-send-fill me-1"></i> Envoyer
      </button>
    </div>
      </div>
    </div>
  </footer>
</template>

<script>
</script>


<style scoped>
.footer-section {
  background-color: #f9f9f9;
  padding: 40px 20px;
  border-top: 2px solid #007bff;
  font-family: sans-serif;
}

.container {
  max-width: 1100px;
  margin: 0 auto;
}

.footer-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 30px;
}

.footer-title {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 15px;
}

.footer-logo {
  width: 100px;
  margin-bottom: 10px;
}

.footer-desc {
  font-size: 14px;
  color: #333;
}

.footer-link {
  color: #000;
  text-decoration: none;
  font-size: 14px;
  display: block;
  margin-bottom: 8px;
}

.footer-link:hover {
  color: #007bff;
}



.btn-newsletter:hover {
  background-color: #0056b3;
}
i.bi {
  color: #007bff;
  margin-right: 5px;
}
.newsletter-input {
  padding: 8px 12px;
  border-radius: 25px;
  border: 1px solid #ccc;
  width: 100%;
  margin-bottom: 10px;
  font-size: 14px;
}

.btn-newsletter {
  padding: 8px 20px;
  border-radius: 25px;
  background-color: #007bff;
  color: #fff;
  border: none;
  font-size: 14px;
  cursor: pointer;
  width: 100%;
  transition: 0.3s ease;
}

.btn-newsletter:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}



</style>
