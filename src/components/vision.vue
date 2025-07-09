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
        <p> Commencez vos recherches d’appartement et trouvez l’endroit idéal où poser vos valises, 
        que ce soit pour un premier achat ou une nouvelle étape de votre vie.</p>
        <router-link :to="{ path: '/biens', hash: '#appartement' }" class="voir-plus">lire plus ></router-link>
      </div>

      <div class="recherche-card">
        <i class="bi bi-house"></i>
        <h3>Maisons</h3>
<p>
        Trouvez la maison de vos rêves, un véritable chez-vous où chaque moment devient spécial. 
        Commencez dès maintenant vos recherches parmi nos nombreuses offres.
      </p>     
         <router-link :to="{ path: '/biens', hash: '#maison' }" class="voir-plus">lire plus ></router-link>
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
        Plongez dans une sélection exclusive de propriétés de luxe soigneusement choisies pour vous.
      </p>
    </div>

    <div class="vedette-principale">
      <!-- Grande carte -->
      <div class="vedette-card grande">
        <img src="@/assets/image12.jpg" alt="Vedette principale" />
        <span class="badge">À vendre</span>
        <div class="vedette-info">
          <span class="price">375 millions</span>
          <h3>Villa aux Almadies</h3>
        </div>
        <router-link to="/biens" class="voir-plus">Voir plus</router-link>
      </div>
    </div>

    <div class="vedette-ligne">
      <!-- Deux petites cartes côte à côte -->
      <div class="vedette-card petite">
        <img src="@/assets/penthouse mbour.jpg" alt="Maison" />
        <span class="badge">À vendre</span>
        <div class="vedette-info">
          <span class="price">260 millions</span>
          <h3>Penthouse de luxe à Mbour</h3>
        </div>
        <router-link to="/biens" class="voir-plus">Voir plus</router-link>
      </div>
      <div class="vedette-card petite">
        <img src="@/assets/toff2.jpeg" alt="Villa" />
        <span class="badge">À vendre</span>
        <div class="vedette-info">
          <span class="price">65 millions</span>
          <h3>Villa à Saly</h3>
        </div>
        <router-link to="/biens" class="voir-plus">Voir plus</router-link>
      </div>
    </div>
    <div class="vedette-footer">
      <router-link to="/biens" class="btn-bottom">Voir plus</router-link>
    </div>
  </section>
</template>

<script setup>

</script>

<style scoped>
.vision-mission-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 30px;
  flex-wrap: wrap;
  margin: 60px auto;
  max-width: 1100px;
  padding: 0 20px;
}

.vision-box, .mission-box {
  flex: 1 1 45%;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.vision-box img,
.mission-box img {
  width: 100%;
  border-radius: 15px;
  object-fit: cover;
}

h2 {
  font-size: 24px;
  font-weight: bold;
}

p {
  font-size: 16px;
  color: #444;
}

.highlight {
  color: #007BFF;
  font-weight: bold;
}

@media (max-width: 768px) {
  .vision-mission-container {
    flex-direction: column;
    gap: 40px;
  }
}
.recherche-section {
  text-align: center;
  padding: 60px 20px;
  background-color: #f9fbff;
}

.intro-text {
  color: #007bff;
  font-weight: 600;
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.recherche-title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 40px;
}

.recherche-grid {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.recherche-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  padding: 25px;
  max-width: 300px;
  flex: 1;
  min-width: 260px;

  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 360px;
}


.recherche-card i {
  font-size: 30px;
  color: #007bff;
  margin-bottom: 15px;
}

.recherche-card h3 {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 10px;
}

.recherche-card p {
  font-size: 15px;
  color: #555;
}

.voir-plus {
  display: inline-block;
  margin-top: 15px;
  padding: 8px 18px;
  background-color: #007bff;
  color: white;
  border-radius: 25px;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.3s ease;
  margin-top: auto;
  align-self: flex-start;
}

.voir-plus:hover {
  background-color: #0056b3;
}

@media (max-width: 768px) {
  .recherche-grid {
    flex-direction: column;
    align-items: center;
  }
}

.vedette-section {
  padding: 60px 20px;
  background-color: #f9fbff;
 margin: 0 auto;
   max-width: 1200px;
   
}

.vedette-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 30px;
}

.vedette-title {
  font-size: 28px;
  font-weight: bold;
}

.vedette-description {
  max-width: 600px;
  font-size: 16px;
  color: #555;
}

.vedette-principale .vedette-card.grande {
  width: 100%;
  height: 400px;
  position: relative;
  border-radius: 12px;
  overflow: hidden;
}

.vedette-ligne {
  display: flex;
  gap: 20px;
  margin-top: 20px;
}

.vedette-card.petite {
  flex: 1;
  height: 250px;
  position: relative;
  border-radius: 12px;
  overflow: hidden;
}

.vedette-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.vedette-info {
  padding: 15px;
  background: rgba(0, 0, 0, 0.4);
  position: absolute;
  bottom: 0;
  width: 100%;
  color: white;
}

.price {
  color: white !important;
  font-weight: bold;
  font-size: 16px;
}

.badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: white;
  color: #007bff;
  border-radius: 20px;
  padding: 4px 10px;
  font-weight: bold;
  font-size: 13px;
}

.voir-plus {
  margin-top: 10px;
  display: inline-block;
  padding: 6px 18px;
  border-radius: 20px;
  background: white;
  color: #007bff;
  font-weight: bold;
  border: 1px solid #007bff;
  text-decoration: none;
  transition: 0.3s;
}

.voir-plus:hover {
  background-color: #007bff;
  color: white;
}

/* Responsive */
@media (max-width: 768px) {
  .vedette-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .vedette-ligne {
    flex-direction: column;
  }
}
.vedette-footer {
  display: flex;
  justify-content: center;
  margin-top: 40px;
}

.btn-bottom {
  padding: 10px 24px;
  background-color:  rgba(255, 255, 255, 0.842);;
  color: #0056b3;
  font-weight: bold;
  border-radius: 25px;
  text-decoration: none;
  transition: 0.3s;
}

.btn-bottom:hover {
  background-color: #b0c5db;
}




</style>