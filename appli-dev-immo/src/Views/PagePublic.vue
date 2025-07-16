<template>
  <div>
    <Navbar />
    <HomeSection />
    <AproposSection />
    <Galerie />
    <Vedette />
    <vision />
    <client />

    <!-- Liste des biens -->
    <section class="public-biens-section py-5">
      <div class="container">
        <h2 class="text-center mb-4">Nos biens disponibles</h2>

        <!-- Barre de recherche -->
        <div class="mb-4 d-flex justify-content-center">
          <input
            v-model="search"
            type="search"
            class="form-control w-50"
            placeholder="Rechercher un bien, une ville, une description..."
            @keyup.enter="currentPage = 1"
          />
        </div>

        <div v-if="erreur" class="alert alert-danger text-center">{{ erreur }}</div>
        <div v-else-if="loading" class="text-center">Chargement des biens...</div>
        <div v-else>
          <div class="row">
            <ListingCard 
              v-for="bien in paginatedBiens" 
              :key="bien.id" 
              :bien="bien" 
              @reserve="handleReservation"
            />
          </div>

          <!-- Pagination -->
          <nav v-if="totalPages > 1" class="mt-4">
            <ul class="pagination justify-content-center">
              <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link" @click="goToPage(currentPage - 1)">Précédent</button>
              </li>
              <li
                v-for="page in totalPages"
                :key="page"
                class="page-item"
                :class="{ active: currentPage === page }"
              >
                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <button class="page-link" @click="goToPage(currentPage + 1)">Suivant</button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </section>

    <ReservationModal 
      v-if="showReservationModal" 
      :bien="selectedBien" 
      @close="closeReservationModal" 
    />

    <pied />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { biensApi } from '@/utils/apiResources';
import { useUserStore } from '@/stores/user';
import Navbar from '@/components/Navbar.vue';
import HomeSection from '@/components/HomeSection.vue';
import AproposSection from '@/components/AproposSection.vue';
import Galerie from '@/components/Galerie.vue';
import Vedette from '@/components/vedette.vue';
import vision from '@/components/vision.vue';
import client from '@/components/client.vue';
import pied from '@/components/pied.vue';
import ListingCard from '@/components/ListingCard.vue';
import ReservationModal from '@/components/ReservationModal.vue';

const biens = ref([])
const loading = ref(true)
const erreur = ref('')
const search = ref('')
const currentPage = ref(1);
const perPage = 6;

const userStore = useUserStore();
const selectedBien = ref(null);
const showReservationModal = ref(false);

const handleReservation = (bien) => {
  console.log('handleReservation déclenché dans PagePublic.vue. Bien reçu:', bien);
  if (!userStore.user) {
    alert('Veuillez vous connecter pour faire une réservation.');
    // Optionnel : rediriger vers la page de login
    // router.push('/login');
    return;
  }
  selectedBien.value = bien;
  showReservationModal.value = true;
};

const closeReservationModal = () => {
  showReservationModal.value = false;
  selectedBien.value = null;
};

const filteredBiens = computed(() => {
  if (!search.value) return biens.value
  return biens.value.filter(bien => {
    return (
      bien.titre?.toLowerCase().includes(search.value.toLowerCase()) ||
      bien.description?.toLowerCase().includes(search.value.toLowerCase()) ||
      bien.ville?.nom?.toLowerCase().includes(search.value.toLowerCase())
    )
  })
})

const paginatedBiens = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return filteredBiens.value.slice(start, start + perPage)
})

const totalPages = computed(() => Math.ceil(filteredBiens.value.length / perPage))

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const BASE_URL = 'http://localhost:8000/storage/'; // À adapter selon ton backend

const getBienImage = (bien) => {
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
    erreur.value = "Impossible de charger les biens."
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.public-biens-section {
  background: linear-gradient(135deg, #f6f7fb 70%, #e3eafc 100%);
  min-height: 600px;
  animation: fadeIn 1.2s;
}
.public-biens-section h2 {
  font-size: 2.3rem;
  font-weight: bold;
  color: #1d3557;
}
</style>
