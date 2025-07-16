<template>
  <div>
    <Navbar />
    <section class="presentation-wrapper">
      <div class="full-width-image-container">
        <img src="@/assets/image7.jpg" alt="Image présentation" class="full-width-image" />
        <div class="blue-alert-box">
          <p>
            Bienvenue chez <strong>DEV-IMMO</strong>, votre partenaire de confiance dans la recherche, la location et la gestion de biens immobiliers.
            Que vous soyez à la recherche de votre futur chez-vous ou d'un investissement rentable, nous sommes là pour vous accompagner à chaque étape.
            Avec notre expertise et notre engagement, nous transformons vos projets immobilier en réalité.
          </p>
        </div>
      </div>
      <div class="full-width-blue-section">
        <div class="bottom-part">
          <div class="text-with-icon">
            <p>
              <i class="bi bi-house-fill icon-purple"></i>
              Notre agence immobilière est dédiée à vous accompagner dans toutes vos démarches liées à l'achat, la vente, la location et la gestion de biens immobiliers au Sénégal.</p><br>
            <p>Forts de nombreuses années d'expérience et d'une connaissance approfondie du marché local, nous mettons un point d'honneur à comprendre vos besoins et à vous offrir des solutions sur mesure, adaptées à vos attentes.
              Notre équipe de professionnels passionnés et réactifs vous guide avec sérieux et transparence, en vous fournissant des conseils précieux à chaque étape de votre projet immobilier.
              Que vous soyez primo-accédant, investisseur ou locataire, nous nous engageons à rendre votre expérience simple, fluide et satisfaisante.<br>
              Notre objectif: faire de vos projets immobiliers une réalité, en toute confiance et sérénité...
            </p>
          </div>
          <img src="@/assets/toff2.jpeg" alt="Image bâtiment" class="bottom-image" />
        </div>
      </div>
    </section>
    <main class="descript text-dark py-5">
      <div class="container">
        <h2 class="text-center text-primary mb-4">
          NOTRE SAVOIR-FAIRE, LA CLÉ DE NOTRE SUCCÈS
        </h2>
        <div class="row">
          <div class="col-md-6">
            <h3 class="fw-bold">Nos avantages</h3>
            <p>
              Spécialisé dans ce domaine de nombreuses années, nous vous offrons une expérience fluide et professionnelle.
            </p>
            <ul>
              <li>Implanté partout dans le Sénégal, nos jeunes agents immobiliers passionnés et motivés seront à votre disposition pour chaque étape.</li>
              <li>Des services sur mesure pour répondre à chaque client.</li>
              <li>Un suivi clair et honnête à chaque étape de votre projet.</li>
              <li>Nous travaillons en étroite collaboration avec les nouvelles technologies pour valoriser vos biens et vous projeter dans cette atmosphère chaleureuse avec la 3D.</li>
            </ul>
          </div>
          <div class="col-md-6">
            <h3 class="fw-bold">Notre philosophie</h3>
            <ul>
              <li>Une relation basée sur la confiance et la transparence est la clé pour atteindre vos objectifs immobiliers.</li>
              <li>Ainsi nous simplifions et sécurisons vos démarches immobilières tout en créant une expérience client unique.</li>
            </ul>
          </div>
        </div>
      </div>
    </main>
    <pied />
  </div>
</template>

<script setup>
import Navbar from '@/components/Navbar.vue'
import pied from '@/components/pied.vue'
</script>

<style scoped>
/* General Reset and Base Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Roboto', sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #f5f5f5;
}

/* Presentation Wrapper */
.presentation-wrapper {
  position: relative;
  min-height: 100vh;
  overflow: hidden;
}

/* Full Width Image Container */
.full-width-image-container {
  position: relative;
  width: 100%;
  height: 80vh;
  overflow: hidden;
}

.full-width-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
  animation: zoomIn 10s infinite alternate;
}

@keyframes zoomIn {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(1.1);
  }
}

.full-width-image-container:hover .full-width-image {
  transform: scale(1.15);
}

/* Blue Alert Box */
.blue-alert-box {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0, 123, 255, 0.9);
  color: white;
  padding: 20px 40px;
  border-radius: 10px;
  max-width: 800px;
  text-align: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  animation: slideUp 1s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(50px) translateX(-50%);
  }
  to {
    opacity: 1;
    transform: translateY(0) translateX(-50%);
  }
}

.blue-alert-box p {
  font-size: 1.2rem;
  line-height: 1.8;
}

.blue-alert-box strong {
  color: #ffd700;
}

/* Full Width Blue Section */
.full-width-blue-section {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  padding: 60px 20px;
  position: relative;
}

.bottom-part {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  flex-wrap: wrap;
  gap: 20px;
}

.text-with-icon {
  flex: 1;
  min-width: 300px;
  font-size: 1.1rem;
}

.text-with-icon p {
  margin-bottom: 20px;
}

.icon-purple {
  color: #6f42c1;
  font-size: 2rem;
  margin-right: 10px;
  transition: transform 0.3s ease;
}

.text-with-icon:hover .icon-purple {
  transform: scale(1.2);
}

.bottom-image {
  max-width: 500px;
  width: 100%;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.bottom-image:hover {
  transform: translateY(-10px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

/* Main Description Section */
.descript {
  background: white;
  padding: 80px 20px;
}

.descript h2 {
  font-size: 2.5rem;
  color: #007bff;
  margin-bottom: 40px;
  position: relative;
}

.descript h2::after {
  content: '';
  width: 100px;
  height: 4px;
  background: #007bff;
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
}

.descript h3 {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 20px;
}

.descript ul {
  list-style: none;
  padding: 0;
}

.descript ul li {
  position: relative;
  padding-left: 30px;
  margin-bottom: 15px;
  font-size: 1.1rem;
  transition: color 0.3s ease;
}

.descript ul li::before {
  content: '\f058';
  font-family: 'Bootstrap Icons';
  position: absolute;
  left: 0;
  color: #007bff;
  font-size: 1.2rem;
}

.descript ul li:hover {
  color: #007bff;
}

/* Responsive Design */
@media (max-width: 768px) {
  .full-width-image-container {
    height: 60vh;
  }

  .blue-alert-box {
    padding: 15px;
    max-width: 90%;
    bottom: 10px;
  }

  .blue-alert-box p {
    font-size: 1rem;
  }

  .bottom-part {
    flex-direction: column;
    align-items: center;
  }

  .bottom-image {
    max-width: 100%;
    margin-top: 20px;
  }

  .descript h2 {
    font-size: 2rem;
  }

  .descript h3 {
    font-size: 1.5rem;
  }
}

@media (max-width: 576px) {
  .full-width-image-container {
    height: 50vh;
  }

  .blue-alert-box {
    padding: 10px;
  }

  .blue-alert-box p {
    font-size: 0.9rem;
  }

  .descript {
    padding: 40px 15px;
  }
}

/* Additional Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.descript .row {
  animation: fadeIn 1s ease-in;
}

/* Button Styling (for potential future buttons) */
.btn-custom {
  background: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.3s ease;
}

.btn-custom:hover {
  background: #0056b3;
  transform: translateY(-2px);
}
</style>
