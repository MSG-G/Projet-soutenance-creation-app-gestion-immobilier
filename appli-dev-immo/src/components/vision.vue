<template>
  <div class="vision-mission-container">
    <div class="vision-box">
      <h2>Notre Vision</h2>
      <p>
        Plongez dans la sélection exquise d'annonces en vedette chez
        <span class="highlight">Dev-Immo</span>.
        Chaque coin respire le confort, chaque détail est conçu avec perfection.
      </p>
      <img src="@/assets/toff2.jpeg" alt="Vision" />
    </div>

    <div class="mission-box">
      <img src="@/assets/image1.jpg" alt="Mission" />
      <h2>Notre Mission</h2>
      <p>
        Notre mission est de réaliser vos rêves immobiliers en vous fournissant des services de premier ordre
        et en mettant à votre disposition notre expertise du marché. Nous croyons fermement qu’une relation
        basée sur la confiance et la transparence est la clé pour atteindre vos objectifs immobiliers.
      </p>
    </div>
  </div>
  <section class="recherche-section">
    <p class="intro-text">NOUS SOMMES LÀ POUR VOUS AIDER</p>
    <h2 class="recherche-title">QU’EST-CE QUE TU CHERCHES?</h2>

    <div class="recherche-grid">
      <div class="recherche-card">
        <i class="bi bi-building"></i>
        <h3>Appartements</h3>
        <p>Commencez vos recherches d’appartement et trouvez l’endroit idéal où poser vos valises,
        que ce soit pour un premier achat ou une nouvelle étape de votre vie.</p>
        <router-link :to="{ path: '/public/biens', hash: '#appartement' }" class="voir-plus">lire plus ></router-link>
      </div>

      <div class="recherche-card">
        <i class="bi bi-house"></i>
        <h3>Maisons</h3>
        <p>
          Trouvez la maison de vos rêves, un véritable chez-vous où chaque moment devient spécial.
          Commencez dès maintenant vos recherches parmi nos nombreuses offres.
        </p>
        <router-link :to="{ path: '/public/biens', hash: '#maison' }" class="voir-plus">lire plus ></router-link>
      </div>

      <div class="recherche-card">
        <i class="bi bi-house-door"></i>
        <h3>Villa</h3>
        <p>
          Découvrez notre sélection de villas d’exception, des lieux uniques où luxe et confort se rencontrent.
          Trouvez la villa qui correspond à vos aspirations et à votre style de vie.
        </p>
        <router-link :to="{ path: '/biens', hash: '#villa' }" class="voir-plus">lire plus ></router-link>
      </div>
    </div>
  </section>
  <section class="vedette-section">
    <div class="vedette-header">
      <h2 class="vedette-title">VEDETTE</h2>
      <p class="vedette-description">
        Découvrez nos biens en vedette, soigneusement sélectionnés pour répondre à toutes vos attentes.
      </p>
    </div>
    <!-- Ici tu peux intégrer le composant vedette ou une liste dynamique -->
  </section>
</template>

<script setup>

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

/* Vision and Mission Container */
.vision-mission-container {
  display: flex;
  gap: 40px;
  justify-content: center;
  align-items: stretch;
  max-width: 1200px;
  margin: 60px auto;
  padding: 0 20px;
  flex-wrap: wrap;
}

.vision-box, .mission-box {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  padding: 40px;
  flex: 1;
  min-width: 300px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  overflow: hidden;
}

.vision-box:hover, .mission-box:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.vision-box::before, .mission-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(90deg, #007bff, #00c4ff);
  transition: width 0.3s ease;
}

.vision-box:hover::before, .mission-box:hover::before {
  width: 100%;
}

.vision-box h2, .mission-box h2 {
  font-size: 2rem;
  color: #007bff;
  margin-bottom: 20px;
  position: relative;
}

.vision-box h2::after, .mission-box h2::after {
  content: '';
  width: 50px;
  height: 3px;
  background: #007bff;
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
}

.vision-box p, .mission-box p {
  font-size: 1.1rem;
  color: #555;
  margin-bottom: 20px;
}

.highlight {
  color: #007bff;
  font-weight: 700;
  transition: color 0.3s ease;
}

.highlight:hover {
  color: #0056b3;
}

.vision-box img, .mission-box img {
  width: 100%;
  max-width: 350px;
  height: auto;
  margin: 20px auto 0;
  border-radius: 12px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.vision-box img:hover, .mission-box img:hover {
  transform: scale(1.05);
}

/* Recherche Section */
.recherche-section {
  text-align: center;
  padding: 80px 20px;
  background: linear-gradient(135deg, #f9fbff, #e6f0ff);
  position: relative;
  overflow: hidden;
}

.intro-text {
  font-size: 1.2rem;
  color: #007bff;
  font-weight: 500;
  letter-spacing: 1px;
  margin-bottom: 10px;
  animation: fadeIn 1s ease-in;
}

.recherche-title {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 40px;
  position: relative;
}

.recherche-title::after {
  content: '';
  width: 80px;
  height: 4px;
  background: #007bff;
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
}

.recherche-grid {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
}

.recherche-card {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  padding: 30px;
  width: 300px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  overflow: hidden;
}

.recherche-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.recherche-card i {
  font-size: 3rem;
  color: #007bff;
  margin-bottom: 15px;
  transition: transform 0.3s ease;
}

.recherche-card:hover i {
  transform: scale(1.2);
}

.recherche-card h3 {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 15px;
}

.recherche-card p {
  font-size: 1rem;
  color: #666;
  margin-bottom: 20px;
}

.voir-plus {
  display: inline-block;
  font-size: 1rem;
  color: #007bff;
  text-decoration: none;
  border-bottom: 2px solid #007bff;
  padding-bottom: 2px;
  transition: all 0.3s ease;
}

.voir-plus:hover {
  color: #0056b3;
  border-color: #0056b3;
  transform: translateX(5px);
}

/* Vedette Section */
.vedette-section {
  padding: 80px 20px;
  max-width: 1200px;
  margin: 0 auto;
  background: #ffffff;
}

.vedette-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 50px;
}

.vedette-title {
  font-size: 2.5rem;
  color: #007bff;
  position: relative;
}

.vedette-title::after {
  content: '';
  width: 60px;
  height: 4px;
  background: #007bff;
  position: absolute;
  bottom: -10px;
  left: 0;
}

.vedette-description {
  font-size: 1.2rem;
  color: #555;
  max-width: 600px;
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.vision-box, .mission-box, .recherche-card {
  animation: fadeIn 1s ease-in;
}

/* Responsive Design */
@media (max-width: 768px) {
  .vision-mission-container {
    flex-direction: column;
    gap: 20px;
    margin: 40px auto;
  }

  .vision-box, .mission-box {
    padding: 20px;
  }

  .vision-box img, .mission-box img {
    max-width: 250px;
  }

  .recherche-section {
    padding: 40px 15px;
  }

  .recherche-title {
    font-size: 2rem;
  }

  .recherche-card {
    width: 100%;
    max-width: 350px;
  }

  .vedette-title {
    font-size: 2rem;
  }
}

@media (max-width: 576px) {
  .vision-box h2, .mission-box h2 {
    font-size: 1.8rem;
  }

  .vision-box p, .mission-box p {
    font-size: 1rem;
  }

  .recherche-title {
    font-size: 1.8rem;
  }

  .intro-text {
    font-size: 1rem;
  }

  .vedette-description {
    font-size: 1rem;
  }
}

/* Button Styling for Future Use */
.btn-custom {
  background: #007bff;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.3s ease;
}

.btn-custom:hover {
  background: #0056b3;
  transform: translateY(-3px);
}
</style>
