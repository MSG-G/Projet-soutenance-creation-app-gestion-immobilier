<template>
  <section class="vedette-section">
    <div class="vedette-header">
      <h2>Biens en Vedette</h2>
      <p>
        Plongez dans la collection exclusive d'annonces en vedette chez
        <span class="highlight">Dev-Immo</span>. Chaque coin respire le confort — chaque détail est conçu avec perfection.
      </p>
    </div>

    <div class="vedette-cards">
      <div class="vedette-card" v-for="(bien, index) in biens" :key="index">
        <div class="image-container">
          <img :src="bien.image" :alt="bien.nom" />
          <span class="badge">{{ bien.prix }}</span>
        </div>
        <h3>{{ bien.nom }}</h3>
        <p class="ville">📍 {{ bien.ville }}</p>
        <p class="statut">disponible</p>
      </div>
    </div>
    <div class="vedette-footer">
  <p>Nous sélectionnons pour vous les meilleures offres du marché.</p>
  <RouterLink to="/biens" class="voir-plus-btn">Voir plus </RouterLink>
</div>
  </section>
</template>

<script setup>

import image1 from '@/assets/image11.jpg'
import image2 from '@/assets/image8.jpg'
import image3 from '@/assets/image9.jpg'
import image4 from '@/assets/image10.jpg'

const biens = [
  { image: image1, nom: 'Classic Apparts', ville: 'Dakar', prix: '800 M' },
  { image: image2, nom: 'Luxieux Apparts', ville: 'Thiès', prix: '800 M' },
  { image: image3, nom: 'Urbain Apparts', ville: 'Saint-Louis', prix: '800 M' },
  { image: image4, nom: 'Modern Apparts', ville: 'Mbour', prix: '800 M' }
]
</script>

<style scoped>
.vedette-section {
  padding: 60px 20px;
  max-width: 1200px;
  margin: auto;
}

.vedette-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 40px;
}

.vedette-header h2 {
  font-size: 2rem;
  font-weight: bold;
}

.vedette-header p {
  max-width: 600px;
  font-size: 1rem;
  text-align: right;
}

.highlight {
  color: #0a59ff;
  font-weight: bold;
}

.vedette-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

.vedette-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  padding: 15px;
  text-align: center;
  transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.3s ease;
  border: 2px solid transparent;
}

.vedette-card:hover {
  transform: translateY(-5px);
   transform: translateY(-10px) scale(1.02);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  border: 2px solid #0a59ff;
}

.image-container {
  position: relative;
  overflow: hidden;
  border-radius: 10px;
}

.image-container img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
   transition: transform 0.4s ease;
}

.badge {
  position: absolute;
  top: 10px;
  left: 10px;
  background: #000;
  color: #fff;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.8rem;
}

.ville {
  margin: 8px 0 4px;
  color: #666;
}

.statut {
  color: #0a59ff;
  font-weight: bold;
}
.image-container:hover img {
  transform: scale(1.05);
}
.vedette-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 30px;
  padding: 0 5px;
  font-size: 0.95rem;
}

.voir-plus-btn {
  background-color: #0a59ff;
  color: #fff;
  padding: 8px 20px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 10px rgba(10, 89, 255, 0.2);
}

.voir-plus-btn:hover {
  background-color: #0047cc;
  transform: scale(1.05);
}


</style>
