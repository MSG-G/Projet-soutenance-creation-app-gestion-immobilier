<template>
  <footer class="footer bg-dark text-white py-4 mt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 mb-3 mb-md-0">
          <img src="@/assets/logoprojet.jpg" alt="Logo agence" class="footer-logo mb-2" height="40" />
          <p class="mb-0">DEV-IMMO © 2025<br>Votre partenaire immobilier de confiance.</p>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
          <h6 class="fw-bold">Liens utiles</h6>
          <ul class="list-unstyled mb-0">
            <li><router-link to="/public">Accueil</router-link></li>
            <li><router-link to="/public/biens">Biens</router-link></li>
            <li><router-link to="/public/apropos">À propos</router-link></li>
            <li><router-link to="/public/contact">Contact</router-link></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6 class="fw-bold">Contact</h6>
          <p class="mb-1"><i class="bi bi-envelope"></i> contact@dev-immo.com</p>
          <p class="mb-1"><i class="bi bi-telephone"></i> +221 33 000 00 00</p>
          <form class="newsletter-form mt-2">
            <label for="newsletter" class="form-label visually-hidden">Newsletter</label>
            <div class="input-group">
              <input type="email" id="newsletter" class="form-control" placeholder="Votre email" aria-label="Inscription newsletter">
              <button class="btn btn-primary" type="submit">S'inscrire</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
// Footer simple, responsive et réutilisable
</script>

<style scoped>
.footer-logo {
  max-width: 120px;
}
.footer a {
  color: #fff;
  text-decoration: underline;
}
.footer a.router-link-exact-active {
  font-weight: bold;
}
</style>
