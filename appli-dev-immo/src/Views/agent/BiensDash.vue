<template>
  <div class="layout">
    <main class="container-fluid px-4 py-3 full-page">
      <h2 class="mb-4 fw-semibold">Gestion des biens immobiliers</h2>

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

        <button @click="ouvrirFormulaire()" class="btn btn-success ms-auto" title="Ajouter un nouveau bien">
          <i class="fas fa-plus me-1"></i> Nouveau bien
        </button>
      </div>


      <!-- États -->
      <ErrorAlert v-if="erreur" :message="erreur" />
      <Loader v-if="chargement" />

      <!-- Liste des biens en cards -->
      <div v-if="!chargement && biensFiltres.length" class="row g-4">
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
            <p class="mb-1"><strong>Propriétaire :</strong> {{ bien.proprietaire?.nom }}</p>
            <div class="d-flex justify-content-end gap-2 mt-2">
              <button class="btn btn-sm btn-outline-primary" @click="ouvrirFormulaire(bien)">
                <i class="fas fa-edit"></i>
              </button>
              <!-- <button class="btn btn-sm btn-outline-danger" @click="confirmerSuppression(bien)">
                <i class="fas fa-trash"></i>
              </button> -->
              <button class="btn btn-sm btn-outline-info" @click="ouvrirShowBien(bien)">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <nav v-if="totalPages > 1 && !chargement" aria-label="Pagination biens" class="mt-4">
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
      <div v-else-if="!chargement" class="alert alert-warning text-center">Aucun bien trouvé.</div>

      <!-- Modals -->
      <ModalBien
        :visible="modalVisible"
        :bien="bienEdit"
        :bien-cree="bienCree"
        @fermer="fermerFormulaire"
        @enregistrer="handleEnregistrer"
      />
      <ModalConfirmation
        :visible="modalSuppressionVisible"
        :message="`Voulez-vous vraiment supprimer le bien '${bienSuppression?.titre}' ?`"
        :loading="suppressionLoading"
        @confirmer="supprimerBien"
        @annuler="modalSuppressionVisible = false"
      />
      <ModalVoirBien
        v-if="showBienVisible"
        :bien="bienShow"
        :key="bienShow && (bienShow.photos && bienShow.photos.length ? bienShow.photos[0].url : bienShow.image) + '-' + showBienVisible"
        @fermer="fermerShowBien"
      />
    </main>
  </div>
</template>
<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import Loader from '@/components/Loader.vue'
import ErrorAlert from '@/components/ErrorAlert.vue'
import ModalBien from '@/components/biens/ModalBien.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
import ModalVoirBien from '@/components/biens/ModalVoirBien.vue'
import { biensApi } from '../../utils/apiResources'

const recherche = ref('')
const filtreLieu = ref('')
const filtreType = ref('')
const filtreStatut = ref('')

const villes = ['Dakar', 'Thiès', 'Saint-Louis', 'Mbour', 'Kédougou', 'Ziguinchor', 'Kaolack']
const types = ['Appartement', 'Villa', 'Maison', 'Terrain']
const statuts = ['Disponible', 'Vendu', 'Loué', 'Réservé']

const biens = ref([])
const chargement = ref(false)
const erreur = ref('')
const placeholderImage = '/images/placeholder.png'

const pageActuelle = ref(1)
const itemsParPage = 8

const modalVisible = ref(false)
const bienEdit = ref(null)
const bienCree = ref(null)
const modalSuppressionVisible = ref(false)
const bienSuppression = ref(null)

const showBienVisible = ref(false)
const bienShow = ref(null)

const suppressionLoading = ref(false)

const chargerBiens = async () => {
  chargement.value = true
  erreur.value = ''
  try {
    const response = await biensApi.list()
    biens.value = Array.isArray(response.data) ? response.data : response.data.data || []
    console.log('Biens reçus de l’API:', biens.value)
    console.log('Nombre total de biens reçus:', biens.value.length)
  } catch (err) {
    erreur.value = err.response?.data?.message || "Impossible de charger les biens."
  } finally {
    chargement.value = false
  }
}

watch(biens, (nv) => {
  console.log('Biens affichés après filtrage:', biensFiltres.value.length)
  console.log('Biens filtrés:', biensFiltres.value)
})

const biensFiltres = computed(() => {
  return biens.value.filter((b) => {
    return (
      (!filtreLieu.value || b.ville?.nom === filtreLieu.value) &&
      (!filtreType.value || b.type_bien?.nom === filtreType.value) &&
      (!filtreStatut.value || b.statut === filtreStatut.value) &&
      (!recherche.value || b.titre.toLowerCase().includes(recherche.value.toLowerCase()))
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

function ouvrirFormulaire(bien = null) {
  bienEdit.value = bien ? { ...bien } : null
  modalVisible.value = true
}

function fermerFormulaire() {
  modalVisible.value = false
  bienEdit.value = null
}

async function handleEnregistrer(bienSauve) {
  try {
    let bienCreeRes = null;
    // Si bienSauve est un FormData (cas image), il faut forcer multipart
    const isFormData = (typeof FormData !== 'undefined') && (bienSauve instanceof FormData);
    if (isFormData && bienSauve.get('id')) {
      await biensApi.update(bienSauve.get('id'), bienSauve, { headers: { 'Content-Type': 'multipart/form-data' } });
      // On ne peut pas cloner un FormData directement, on recharge après
      bienCreeRes = {};
    } else if (isFormData) {
      const res = await biensApi.create(bienSauve, { headers: { 'Content-Type': 'multipart/form-data' } });
      bienCreeRes = res.data;
    } else if (bienSauve.id) {
      await biensApi.update(bienSauve.id, bienSauve);
      // Recharge le bien depuis l’API pour avoir l'image à jour
      const res = await biensApi.get(bienSauve.id);
      bienCreeRes = res.data;
    } else {
      const res = await biensApi.create(bienSauve);
      bienCreeRes = res.data;
    }
    bienCree.value = bienCreeRes;
    // NE PAS fermer la modale ici ! Laisser l'utilisateur uploader des photos
    // chargerBiens() sera appelé à la fermeture réelle
  } catch (err) {
    // Affichage détaillé de l'erreur backend pour debug
    if (err?.response?.data) {
      console.error('Erreur API:', err.response.data);
    } else {
      console.error(err);
    }
    alert("Erreur lors de l'enregistrement");
  }
}

function confirmerSuppression(bien) {
  bienSuppression.value = bien
  modalSuppressionVisible.value = true
}

async function supprimerBien() {
  suppressionLoading.value = true
  try {
    await biensApi.remove(bienSuppression.value.id)
    modalSuppressionVisible.value = false
    bienSuppression.value = null
    chargerBiens()
  } catch (err) {
    console.error(err)
    alert("Erreur lors de la suppression")
  } finally {
    suppressionLoading.value = false
  }
}

async function ouvrirShowBien(bien) {
  // Si le bien a un id, recharge-le depuis l'API pour avoir l'image à jour
  if (bien.id) {
    try {
      const res = await biensApi.get(bien.id);
      bienShow.value = res.data;
    } catch (e) {
      // En cas d'erreur, fallback sur l'objet local
      bienShow.value = bien;
    }
  } else {
    bienShow.value = bien;
  }
  showBienVisible.value = true;
}
function fermerShowBien() {
  showBienVisible.value = false
  bienShow.value = null
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

const router = useRouter()
function allerFormulaireBien() {
  router.push({ name: 'BienFormAjout' })
}

onMounted(() => chargerBiens())

watch([recherche, filtreLieu, filtreType, filtreStatut], () => {
  pageActuelle.value = 1
})
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

/* Filtres / barre d'action */
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

.table-responsive {
  max-height: 65vh;
  overflow-y: auto;
  background: white;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 0 12px rgb(0 0 0 / 0.05);
}

.table th,
.table td {
  vertical-align: middle;
}

.table thead th.sticky-top {
  position: sticky;
  top: 0;
  background: white;
  z-index: 5;
  border-bottom: 2px solid #dee2e6;
}

.pagination .page-item.active .page-link {
  background-color: #198754;
  border-color: #198754;
  color: white;
}

.pagination .page-link {
  cursor: pointer;
}

.badge {
  font-weight: 500;
  font-size: 0.9rem;
  padding: 0.35em 0.6em;
  border-radius: 0.5rem;
}

/* Responsive */
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