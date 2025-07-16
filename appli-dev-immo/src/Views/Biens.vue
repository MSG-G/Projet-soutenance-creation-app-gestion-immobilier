<template>
  <navbar />
  <!-- Hero Section -->
  <section class="hero-section text-center text-white">
    <div class="container">
      <h1 class="display-4 fw-bold">Trouvez la propriété de vos rêves</h1>
      <p class="lead mb-4">Découvrez notre catalogue de biens immobiliers d'exception.</p>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Rechercher par titre, adresse, description..."
            class="form-control form-control-lg shadow-sm"
          />
        </div>
      </div>
    </div>
  </section>

  <!-- Filtres et Tri -->
  <section class="filters-section bg-light py-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          
        </div>
      </div>
      <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <button
          v-for="type in typesDeBien"
          :key="type"
          @click="selectedType = type"
          :class="['btn', selectedType === type ? 'btn-primary' : 'btn-outline-primary']"
        >
          {{ type }}
        </button>
      </div>
      <div class="row justify-content-between align-items-center">
        <div class="col-md-6">
          <p class="text-muted mb-0">{{ filteredBiens.length }} bien(s) trouvé(s)</p>
        </div>
        <div class="col-md-4 col-lg-3">
          <select v-model="sortBy" class="form-select">
            <option value="default">Trier par défaut</option>
            <option value="price_asc">Prix (croissant)</option>
            <option value="price_desc">Prix (décroissant)</option>
            <option value="surface_desc">Surface (décroissant)</option>
          </select>
        </div>
      </div>
    </div>
  </section>

  <!-- Gestion de l'état de chargement et des erreurs -->
  <section v-if="isLoading" class="container py-4 text-center">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Chargement...</span>
    </div>
    <p class="mt-2">Chargement des biens...</p>
  </section>
  <section v-else-if="error" class="container py-4 text-center text-danger">
    <p>Erreur lors du chargement des biens : {{ error }}</p>
  </section>
  <section v-else>
    <section class="container py-4">
      <div v-if="filteredBiens.length > 0" class="row">
        <div class="col-md-4 mb-4" v-for="(bien, index) in filteredBiens" :key="bien.id || index">
          <div class="card h-100 shadow-sm">
            <img
              :src="getBienImage(bien)"
              class="card-img-top"
              alt="Image du bien"
              style="height: 200px; object-fit: cover"
              @error="onImgError"
            />
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-primary">{{ bien.titre }}</h5>
              <p class="card-text text-muted" style="min-height:48px;">{{ bien.description }}</p>
              <ul class="list-unstyled mb-3">
                <li><strong>Prix:</strong> {{ formatPrice(bien.prix) }}</li>
                <li><strong>Surface:</strong> {{ bien.surface ? bien.surface + ' m²' : 'N/A' }}</li>
                <li><strong>Statut:</strong> {{ bien.statut || (bien.disponible ? 'disponible' : 'indisponible') }}</li>
                <li><strong>Adresse:</strong> {{ bien.adresse }}</li>
                <li><strong>Type:</strong> {{ bien.type_bien?.nom }}</li>
              </ul>
              <button @click="openReservationModal(bien)" class="btn btn-outline-primary btn-sm mt-auto">Réserver une visite</button>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center py-5">
        <i class="bi bi-search-heart fs-1 text-muted mb-3"></i>
        <p class="lead">Aucun bien ne correspond à vos critères de recherche.</p>
        <p class="text-muted">Essayez d'ajuster vos filtres ou votre recherche.</p>
      </div>
    </section>

    <!-- Texte remerciement -->
    <section class="banner text-center text-white py-5">
      <div class="container">
        <h2 class="fw-bold mb-3">Merci d’avoir pris le temps de consulter nos offres !</h2>
        <p class="lead fw-semibold">
          Si l’un de nos biens a retenu votre attention ou si vous avez des questions, n’hésitez pas à nous
          <router-link to="/contact" class="lien-blanc">Contacter</router-link>.
          Nous sommes là pour vous accompagner jusqu’à votre futur chez-vous.
        </p>
      </div>
    </section>

    <!-- Footer -->
    <div>
      <pied />
    </div>
  </section>

  <ReservationModal 
    :visible="isModalVisible" 
    :bien="selectedBien" 
    @close="closeReservationModal" 
    @submit="handleReservationSubmit"
  />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ReservationModal from '@/components/ReservationModal.vue';
import Navbar from '@/components/Navbar.vue';
import pied from '@/components/pied.vue';
import { useUserStore } from '@/stores/user';
import { biensApi, reservationsApi } from '@/utils/apiResources'

const searchQuery = ref('')

const biens = ref([])
const isLoading = ref(false)
const error = ref(null)

const fetchBiens = async () => {
  isLoading.value = true;
  error.value = null;
  try {
    const response = await biensApi.list();
    biens.value = response.data.map(bien => ({
      id: bien.id,
      titre: bien.titre || 'Sans titre',
      type_bien: bien.type_bien ? { nom: bien.type_bien.nom || 'Inconnu' } : { nom: 'Inconnu' },
      prix: bien.prix || 0,
      surface: bien.surface || null,
      chambres: bien.chambres || null,
      sdb: bien.sdb || null,
      pieces: bien.pieces || null,
      statut: bien.statut || 'Non spécifié',
      adresse: bien.adresse || bien.ville?.nom || 'Non spécifié',
      description: bien.description || 'Aucune description disponible',
      image_principale: bien.image_principale || null,
      photos_secondaires: Array.isArray(bien.photos)
        ? bien.photos.map(photo => (
            typeof photo === 'string' ? photo : photo.url || null
          )).filter(p => p)
        : []
    }))
  } catch (err) {
    error.value = err.response?.data?.message || 'Une erreur est survenue lors du chargement des biens.'
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchBiens() // Appeler l'API au montage du composant
})

const selectedType = ref('Tous');
const sortBy = ref('default');

const typesDeBien = computed(() => {
  const types = new Set(biens.value.map(b => b.type_bien.nom).filter(Boolean));
  return ['Tous', ...types];
});

const filteredBiens = computed(() => {
  const query = searchQuery.value.toLowerCase();
  let filtered = biens.value;

  // 1. Filtrer par type
  if (selectedType.value !== 'Tous') {
    filtered = filtered.filter(b => b.type_bien.nom === selectedType.value);
  }

  // 2. Filtrer par recherche textuelle
  if (query) {
    filtered = filtered.filter(
      (b) =>
        (b.titre && b.titre.toLowerCase().includes(query)) ||
        (b.description && b.description.toLowerCase().includes(query)) ||
        (b.adresse && b.adresse.toLowerCase().includes(query))
    );
  }

  // 3. Trier
  switch (sortBy.value) {
    case 'price_asc':
      filtered.sort((a, b) => a.prix - b.prix);
      break;
    case 'price_desc':
      filtered.sort((a, b) => b.prix - a.prix);
      break;
    case 'surface_desc':
      filtered.sort((a, b) => (b.surface || 0) - (a.surface || 0));
      break;
  }

  return filtered;
});

const userStore = useUserStore();
const isModalVisible = ref(false);
const selectedBien = ref(null);

const openReservationModal = (bien) => {
  if (!userStore.user) { // On vérifie si l'objet user existe
    // Idéalement, utiliser un composant de dialogue ou de toast plus élégant
    alert('Vous devez être connecté pour réserver une visite. Veuillez vous connecter ou créer un compte.');
    // Optionnel : rediriger vers la page de connexion
    // router.push('/connexion');
    return;
  }

  selectedBien.value = {
    ...bien,
    prix_formate: formatPrice(bien.prix),
    image_url: getBienImage(bien),
    user: {
      nom: userStore.user?.name || '',
      email: userStore.user?.email || '',
      telephone: userStore.user?.phone || ''
    }
  };
  isModalVisible.value = true;
};

function closeReservationModal() {
  isModalVisible.value = false;
  selectedBien.value = null;
}

const handleReservationSubmit = async (reservationData) => {
  try {
    // L'API attend maintenant un objet plus simple
    const payload = {
      bien_id: reservationData.bien_id,
      date_visite: reservationData.date_visite,
      message: reservationData.message,
    };
    await reservationsApi.create(payload);
    alert('Réservation soumise avec succès !');
    isModalVisible.value = false;
  } catch (error) {
    console.error('Erreur lors de la réservation:', error);
    const errorMessage = error.response?.data?.message || 'Une erreur est survenue lors de la soumission de votre réservation.';
    alert(errorMessage);
  }
}

// Fonction utilitaire inspirée de PagePublic.vue
function getBienImage(bien) {
  const imagePath = bien.image_principale || (bien.photos_secondaires && bien.photos_secondaires[0]) || null;
  return getImageUrl(imagePath);
}

function onImgError(event) {
  event.target.src = '/src/assets/placeholder.jpg';
}

function getImageUrl(path) {
  // Cas vide ou null : placeholder
  if (!path || typeof path !== 'string') {
    return '/src/assets/placeholder.jpg';
  }
  // URL absolue
  if (path.startsWith('http')) {
    return path;
  }
  // Chemin backend Laravel (ex: /storage/photos/xxx.jpg)
  if (path.startsWith('/storage')) {
    // Si VITE_API_BASE_URL est défini, on le préfixe
    const base = import.meta.env.VITE_API_BASE_URL || '';
    return base.replace(/\/$/, '') + path;
  }
  // Cas chemin assets locaux (ex: 'studio.jpg' ou '@/assets/studio.jpg')
  if (path.startsWith('@/assets/')) {
    return new URL(path.replace('@/', ''), import.meta.url).href;
  }
  // Cas chemin relatif simple (ex: 'studio.jpg')
  if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
    return new URL(`/src/assets/${path.replace(/^\//, '')}`, import.meta.url).href;
  }
  // Fallback
  return '/src/assets/placeholder.jpg';
}


function formatPrice(prix) {
  if (typeof prix === 'number') {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(prix)
  }
  return prix || 'Prix non spécifié'
}
</script>

<style scoped>
.search-section input {
  padding: 0.75rem 1rem;
  font-size: 1rem;
  border-radius: 8px;
  transition: box-shadow 0.3s ease;
}

.search-section input:focus {
  box-shadow: 0 0 10px rgba(0, 71, 255, 0.2);
}

.banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.banner h2 {
  font-size: 2.2rem;
  font-weight: 700;
}

.banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}

.card-bien {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), 0 1.5px 6px rgba(0, 0, 0, 0.04);
  margin-bottom: 3rem;
  overflow: hidden;
  transition: box-shadow 0.3s ease, transform 0.3s ease;
  padding: 1.5rem;
}

.card-bien:hover {
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.16), 0 3px 12px rgba(0, 0, 0, 0.10);
  transform: translateY(-5px);
}

.img-main {
  border-radius: 14px;
  width: 100%;
  height: 340px;
  object-fit: cover;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
  margin-bottom: 1rem;
  transition: transform 0.3s ease;
}

.img-main:hover {
  transform: scale(1.03);
}

.img-thumbnail {
  border-radius: 8px;
  height: 120px;
  width: 23%;
  object-fit: cover;
  margin-right: 1.5%;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s ease;
}

.img-thumbnail:hover {
  transform: scale(1.10);
  z-index: 2;
}

@media (max-width: 900px) {
  .img-main {
    height: 230px;
    max-height: 40vh;
  }
  .img-thumbnail {
    height: 90px;
    width: 48%;
  }
  .card-bien {
    padding: 1rem;
  }
  .banner h2 {
    font-size: 1.8rem;
  }
  .banner p {
    font-size: 1rem;
  }
}

.bi {
  margin-right: 6px;
}

.lien-blanc {
  color: white;
  text-decoration: none;
  transition: color 0.3s ease;
}

.lien-blanc:hover {
  color: #e0e0e0;
}

.btn-primary {
  background-color: #0047FF;
  border-color: #0047FF;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
  background-color: #0033cc;
  border-color: #0033cc;
  transform: scale(1.05);
}

.hero-section {
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('@/assets/banner-immo.jpg') no-repeat center center;
  background-size: cover;
  padding: 6rem 0;
  margin-top: -1px; /* Pour couvrir la bordure du navbar */
}

.filters-section {
  border-bottom: 1px solid #dee2e6;
}
</style>
