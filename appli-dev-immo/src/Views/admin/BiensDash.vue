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

      <!-- Liste des biens -->
      <div v-if="!chargement && biensFiltres.length" class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
          <thead class="table-light sticky-top">
            <tr>
              <th>Image</th>
              <th>Nom</th>
              <th>Lieu</th>
              <th>Type</th>
              <th>Prix (Fcfa)</th>
              <th>Statut</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="bien in biensFiltresPage" :key="bien.id">
              <td>
                <img
                  :src="bien.image || placeholderImage"
                  alt="img"
                  class="img-thumbnail"
                  style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;"
                />
              </td>
              <td>{{ bien.nom }}</td>
              <td>{{ bien.lieu }}</td>
              <td>{{ bien.type }}</td>
              <td>{{ bien.prix.toLocaleString() }}</td>
              <td>
                <span :class="badgeStatut(bien.statut)">{{ bien.statut }}</span>
              </td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-primary me-2" @click="ouvrirFormulaire(bien)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="confirmerSuppression(bien)">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mt-4">
          <li class="page-item" :class="{ disabled: pageActuelle === 1 }" @click="changerPage(pageActuelle - 1)">
            <a class="page-link">&laquo;</a>
          </li>
          <li
            v-for="page in totalPages"
            :key="page"
            class="page-item"
            :class="{ active: page === pageActuelle }"
            @click="changerPage(page)"
          >
            <a class="page-link">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: pageActuelle === totalPages }" @click="changerPage(pageActuelle + 1)">
            <a class="page-link">&raquo;</a>
          </li>
        </ul>
      </div>

      <div v-else-if="!chargement" class="alert alert-warning text-center">Aucun bien trouvé.</div>

      <!-- Modals -->
      <ModalBien
  :visible="modalVisible"
  :bien="bienEdit"
  @fermer="fermerFormulaire"
  @enregistrer="handleEnregistrer"
/>
      <ModalConfirmation
        v-if="modalSuppressionVisible"
        :message="`Voulez-vous vraiment supprimer le bien '${bienSuppression?.nom}' ?`"
        @confirmer="supprimerBien"
        @annuler="modalSuppressionVisible = false"
      />
    </main>
  </div>
</template>
<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'

import Loader from '@/components/Loader.vue'
import ErrorAlert from '@/components/ErrorAlert.vue'
import ModalBien from '@/components/biens/ModalBien.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'

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
const modalSuppressionVisible = ref(false)
const bienSuppression = ref(null)

const chargerBiens = async () => {
  chargement.value = true
  erreur.value = ''
  try {
    const res = await axios.get('/api/biens')
    biens.value = res.data.data || []
  } catch (err) {
    erreur.value = "Impossible de charger les biens."
  } finally {
    chargement.value = false
  }
}

const biensFiltres = computed(() => {
  return biens.value.filter((b) => {
    return (
      (!filtreLieu.value || b.lieu === filtreLieu.value) &&
      (!filtreType.value || b.type === filtreType.value) &&
      (!filtreStatut.value || b.statut === filtreStatut.value) &&
      (!recherche.value || b.nom.toLowerCase().includes(recherche.value.toLowerCase()))
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
    if (bienSauve.id) {
      await axios.put(`/api/biens/${bienSauve.id}`, bienSauve)
    } else {
      await axios.post('/api/biens', bienSauve)
    }
    fermerFormulaire()
    chargerBiens()
  } catch (err) {
    console.error(err)
    alert("Erreur lors de l'enregistrement")
  }
}

function confirmerSuppression(bien) {
  bienSuppression.value = bien
  modalSuppressionVisible.value = true
}

async function supprimerBien() {
  try {
    await axios.delete(`/api/biens/${bienSuppression.value.id}`)
    modalSuppressionVisible.value = false
    chargerBiens()
  } catch (err) {
    console.error(err)
    alert("Erreur lors de la suppression")
  }
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