<template>
  <section class="vedette-section">
    <ModalVoirBienPublic :bien="bienSelectionne" v-if="modalVisible" @fermer="modalVisible = false" />
    <div class="vedette-header">
      <h2>Biens en Vedette</h2>
      <p>
        Plongez dans la collection exclusive d'annonces en vedette chez
        <span class="highlight">Dev-Immo</span>. Chaque coin respire le confort — chaque détail est conçu avec perfection.
      </p>
    </div>

    <div class="vedette-cards">
      <div class="vedette-card" v-for="(bien, index) in biens" :key="bien.id || index" @click="ouvrirModal(bien)" style="cursor:pointer;">
        <div class="image-container">
          <img :src="getVedetteImage(bien)" :alt="bien.titre" @error="onImgError" />
          <span class="badge">{{ bien.prix ? bien.prix.toLocaleString() + ' FCFA' : '' }}</span>
        </div>
        <h3>{{ bien.titre }}</h3>
        <p class="ville">📍 {{ bien.ville?.nom || '' }}</p>
        <p class="statut">{{ bien.statut || (bien.disponible ? 'disponible' : 'indisponible') }}</p>
      </div>
    </div>
    <div class="vedette-footer">
      <p>Nous sélectionnons pour vous les meilleures offres du marché.</p>
      <RouterLink to="/biens" class="voir-plus-btn">Voir plus </RouterLink>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { biensApi } from '@/utils/apiResources'
import ModalVoirBienPublic from '@/components/biens/ModalVoirBienPublic.vue'

const biens = ref([])
const BASE_URL = 'http://localhost:8000/storage/'; // À adapter selon ton backend

const modalVisible = ref(false)
const bienSelectionne = ref(null)

function ouvrirModal(bien) {
  bienSelectionne.value = bien
  modalVisible.value = true
}

const getVedetteImage = (bien) => {
  if (bien.photos && bien.photos.length && bien.photos[0].url) {
    return bien.photos[0].url.startsWith('http')
      ? bien.photos[0].url
      : BASE_URL + bien.photos[0].url;
  } else if (bien.image) {
    return bien.image.startsWith('http')
      ? bien.image
      : BASE_URL + bien.image;
  } else {
    return '/images/placeholder.png';
  }
}

const onImgError = (event) => {
  event.target.src = '/images/placeholder.png';
};

onMounted(async () => {
  try {
    const res = await biensApi.list()
    biens.value = res.data
  } catch (e) {
    biens.value = []
  }
})
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
}

.vedette-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
  justify-content: center;
}

.vedette-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  padding: 16px;
  width: 260px;
  text-align: center;
  transition: transform 0.2s;
}
.vedette-card:hover {
  transform: translateY(-8px) scale(1.03);
}
.image-container {
  position: relative;
  height: 160px;
  margin-bottom: 12px;
  overflow: hidden;
  border-radius: 8px;
}
.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.badge {
  position: absolute;
  top: 12px;
  right: 12px;
  background: #007bff;
  color: #fff;
  padding: 6px 14px;
  border-radius: 16px;
  font-size: 1rem;
}
.vedette-footer {
  margin-top: 28px;
  text-align: center;
}
.voir-plus-btn {
  display: inline-block;
  margin-top: 10px;
  background: #007bff;
  color: #fff;
  padding: 8px 24px;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.2s;
}
.voir-plus-btn:hover {
  background: #0056b3;
}
</style>
