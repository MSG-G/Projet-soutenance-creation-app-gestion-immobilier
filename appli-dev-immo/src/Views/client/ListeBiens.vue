<template>
  <HeaderDash />
  <div class="layout">
    <main class="container-fluid px-4 py-3 full-page">
      <h2 class="mb-4 fw-semibold">Biens disponibles</h2>
      <!-- Barre d'actions -->
      <div class="filters-bar d-flex align-items-center gap-3 mb-4 flex-wrap">
        <div class="search-wrapper">
          <input
            v-model="recherche"
            type="search"
            class="form-control ps-5"
            placeholder="Rechercher un bien..."
            @input="pageActuelle = 1"
          />
          <i class="fas fa-search search-icon"></i>
        </div>
        <select v-model="filtreLieu" class="form-select" @change="pageActuelle = 1">
          <option value="">-- Lieu --</option>
          <option v-for="ville in villes" :key="ville">{{ ville }}</option>
        </select>
        <select v-model="filtreType" class="form-select" @change="pageActuelle = 1">
          <option value="">-- Type --</option>
          <option v-for="type in types" :key="type">{{ type }}</option>
        </select>
        <select v-model="filtreStatut" class="form-select" @change="pageActuelle = 1">
          <option value="">-- Statut --</option>
          <option v-for="statut in statuts" :key="statut">{{ statut }}</option>
        </select>
        <button @click="resetFiltres" class="btn btn-light border" title="Réinitialiser filtres">
          <i class="fas fa-sync-alt"></i>
        </button>
      </div>
      <!-- États -->
      <div v-if="error" class="alert alert-danger">{{ error }}</div>
      <div v-if="loading">
        <div class="text-center my-4">Chargement...</div>
      </div>
      <!-- Liste des biens en cards -->
      <div v-if="!loading && biensFiltres.length" class="row g-4">
        <div v-for="bien in biensFiltresPage" :key="bien.id" class="col-12 col-md-6 col-lg-4">
          <div class="card shadow-sm p-3 h-100">
            <img
              :src="(bien.photos && bien.photos.length)
                ? (bien.photos[0].url + '?t=' + (bien.updated_at || Date.now()))
                : (bien.image ? (bien.image + '?t=' + (bien.updated_at || Date.now())) : placeholderImage)"
              alt="img"
              class="img-fluid rounded mb-3"
              style="width:100%;height:180px;object-fit:cover;"
            />
            <h5 class="mb-1">{{ bien.titre }}</h5>
            <p class="mb-1 text-muted">{{ bien.description }}</p>
            <p class="mb-1"><strong>Prix :</strong> {{ bien.prix ? Number(bien.prix).toLocaleString() : '' }} FCFA</p>
            <p class="mb-1"><strong>Surface :</strong> {{ bien.surface }} m²</p>
            <p class="mb-1"><strong>Adresse :</strong> {{ bien.adresse }}</p>
            <p class="mb-1"><strong>Statut :</strong> <span style="font-size: 15px; color: black;" :class="badgeStatut(bien.statut)">{{ bien.statut }}</span></p>
            <p class="mb-1"><strong>Ville :</strong> {{ bien.ville?.nom }}</p>
            <p class="mb-1"><strong>Type :</strong> {{ bien.type_bien?.nom }}</p>
            <div class="d-flex justify-content-end gap-2 mt-2">
              <router-link :to="`/client/biens/${bien.id}`" class="btn btn-sm btn-outline-info" title="Voir le bien">
                <i class="fas fa-eye"></i>
              </router-link>
              <button class="btn btn-sm btn-outline-warning" @click="toggleFavori(bien)">
                <i :class="['fas', bien.favori ? 'fa-star' : 'fa-star-o']"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <nav v-if="totalPages > 1 && !loading" aria-label="Pagination biens" class="mt-4">
        <ul class="pagination justify-content-center">
          <li class="page-item" :class="{ disabled: pageActuelle === 1 }">
            <button class="page-link" @click="changerPage(pageActuelle - 1)" :disabled="pageActuelle === 1">&laquo;</button>
          </li>
          <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: pageActuelle === page }">
            <button class="page-link" @click="changerPage(page)">{{ page }}</button>
          </li>
          <li class="page-item" :class="{ disabled: pageActuelle === totalPages }">
            <button class="page-link" @click="changerPage(pageActuelle + 1)" :disabled="pageActuelle === totalPages">&raquo;</button>
          </li>
        </ul>
      </nav>
      <div v-else-if="!loading" class="alert alert-warning text-center">Aucun bien trouvé.</div>
    </main>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/utils/api'

const recherche = ref('')
const filtreLieu = ref('')
const filtreType = ref('')
const filtreStatut = ref('')

const villes = ['Dakar', 'Thiès', 'Saint-Louis', 'Mbour', 'Kédougou', 'Ziguinchor', 'Kaolack']
const types = ['Appartement', 'Villa', 'Maison', 'Terrain']
const statuts = ['Disponible', 'Vendu', 'Loué', 'Réservé']

const biens = ref([])
const loading = ref(false)
const error = ref('')
const placeholderImage = '/images/placeholder.png'

const pageActuelle = ref(1)
const itemsParPage = 8

const chargerBiens = async () => {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get('/biens')
    biens.value = Array.isArray(res.data) ? res.data : res.data.data || []
  } catch (err) {
    error.value = err.response?.data?.message || "Impossible de charger les biens."
  } finally {
    loading.value = false
  }
}

onMounted(() => chargerBiens())

const biensFiltres = computed(() => {
  return biens.value.filter((b) => {
    return (
      (!filtreLieu.value || b.ville?.nom === filtreLieu.value) &&
      (!filtreType.value || b.type_bien?.nom === filtreType.value) &&
      (!filtreStatut.value || b.statut === filtreStatut.value) &&
      (!recherche.value || b.titre?.toLowerCase().includes(recherche.value.toLowerCase()))
    )
  })
})

const totalPages = computed(() => Math.max(1, Math.ceil(biensFiltres.value.length / itemsParPage)))
const biensFiltresPage = computed(() => {
  const start = (pageActuelle.value - 1) * itemsParPage
  return biensFiltres.value.slice(start, start + itemsParPage)
})

function changerPage(num) {
  if (num >= 1 && num <= totalPages.value) {
    pageActuelle.value = num
  }
}

function resetFiltres() {
  filtreLieu.value = ''
  filtreType.value = ''
  filtreStatut.value = ''
  recherche.value = ''
  pageActuelle.value = 1
}

function badgeStatut(statut) {
  return {
    badge: true,
    'bg-success': statut === 'Disponible',
    'bg-danger': statut === 'Vendu',
    'bg-warning text-dark': statut === 'Réservé',
    'bg-info text-dark': statut === 'Loué'
  }
}

async function toggleFavori(bien) {
  try {
    // Ici, on simule un toggle favoris. Adaptez selon votre API !
    bien.favori = !bien.favori
    // await api.post(`/client/favoris/${bien.id}`) ou DELETE selon l'état
  } catch (e) {
    // rollback si erreur
    bien.favori = !bien.favori
    alert('Erreur lors de la gestion du favori')
  }
}
import HeaderDash from '@/components/HeaderDash.vue';
</script>
<style scoped>
.layout {
  display: flex;
}
.full-page {
  min-height: 100vh;
  background-color: #f9f9f9;
  border-radius: 10px;
}
.filters-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.search-wrapper {
  flex-grow: 1;
  position: relative;
  max-width: 350px;
  min-width: 250px;
}
.search-wrapper input {
  width: 100%;
}
.search-icon {
  position: absolute;
  top: 50%;
  left: 1rem;
  transform: translateY(-50%);
  color: #aaa;
  pointer-events: none;
  font-size: 1.2rem;
}
.form-select {
  min-width: 140px;
  max-width: 160px;
}
.btn-light, .btn-success {
  white-space: nowrap;
}
.card {
  border-radius: 10px;
}
.badge {
  font-weight: 500;
  font-size: 0.9rem;
  padding: 0.35em 0.6em;
  border-radius: 0.5rem;
}
.pagination .page-item.active .page-link {
  background-color: #198754;
  border-color: #198754;
  color: white;
}
.pagination .page-link {
  cursor: pointer;
}
@media (max-width: 768px) {
  .search-wrapper,
  .form-select,
  .btn-light,
  .btn-success {
    width: 100% !important;
    max-width: 100%;
  }
  .filters-bar {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>

