<template>
  <div class="layout">
    <main class="page p-4">

      <!-- En-tête -->
      <div class="header mb-4">
        <h2 class="fw-semibold mb-1 text-primary">👤 Gestion des propriétaires</h2>
        <p class="text-muted mb-0">Consultez, ajoutez ou modifiez les informations des propriétaires.</p>
      </div>

      <!-- Barre d’actions -->
      <div class="action-bar sticky-top d-flex flex-wrap gap-3 align-items-center py-3 bg-white shadow-sm px-3 rounded mb-4">
        <div class="search-container position-relative flex-grow-1">
          <input
            v-model="recherche"
            class="form-control ps-5"
            placeholder="🔍 Rechercher un propriétaire..."
            @input="pageActuelle = 1"
          />
          <i class="fas fa-search search-icon"></i>
        </div>

        <button @click="resetRecherche" class="btn btn-light border shadow-sm" title="Réinitialiser">
          <i class="fas fa-sync-alt"></i>
        </button>

        <button @click="ouvrirFormulaire()" class="btn btn-primary d-flex align-items-center gap-2">
          <i class="fas fa-plus"></i> Ajouter
        </button>
      </div>

      <!-- États -->
      <ErrorAlert v-if="erreur" :message="erreur" />
      <Loader v-if="chargement" />

      <!-- Tableau -->
      <transition name="fade">
        <div
          v-if="!chargement && proprietairesFiltres.length"
          class="table-responsive shadow-sm rounded"
        >
          <table class="table table-hover align-middle">
            <thead class="table-light sticky-top">
              <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="p in proprietairesPage"
                :key="p.id"
                @click="ouvrirFormulaire(p)"
                class="clickable-row"
              >
                <td>{{ p.nom }}</td>
                <td>{{ p.email }}</td>
                <td>{{ p.telephone }}</td>
                <td class="text-center">
                  <button @click.stop="ouvrirFormulaire(p)" class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button @click.stop="confirmerSuppression(p)" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <ul class="pagination justify-content-center mt-3">
            <li
              class="page-item"
              :class="{ disabled: pageActuelle === 1 }"
              @click="changerPage(pageActuelle - 1)"
            >
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
            <li
              class="page-item"
              :class="{ disabled: pageActuelle === totalPages }"
              @click="changerPage(pageActuelle + 1)"
            >
              <a class="page-link">&raquo;</a>
            </li>
          </ul>
        </div>
      </transition>

      <!-- Modals -->
      <ModalProprietaire
        v-if="modalVisible"
        :proprietaire="proprietaireEdit"
        @fermer="fermerFormulaire"
        @enregistrer="handleEnregistrer"
      />
      <ModalConfirmation
        v-if="modalSuppressionVisible"
        :message="`Supprimer le propriétaire '${proprietaireSuppression?.nom}' ?`"
        @confirmer="supprimerProprietaire"
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
import ModalProprietaire from '@/components/proprietaires/ModalProprietaire.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'

const recherche = ref('')
const proprietaires = ref([])
const chargement = ref(false)
const erreur = ref('')
const pageActuelle = ref(1)
const itemsParPage = 10

const modalVisible = ref(false)
const modalSuppressionVisible = ref(false)
const proprietaireEdit = ref(null)
const proprietaireSuppression = ref(null)

const chargerProprietaires = async () => {
  chargement.value = true
  try {
    const res = await axios.get('/api/proprietaires')
    proprietaires.value = res.data.data || []
  } catch {
    erreur.value = "Erreur lors du chargement"
  } finally {
    chargement.value = false
  }
}

const proprietairesFiltres = computed(() =>
  proprietaires.value.filter(p =>
    p.nom.toLowerCase().includes(recherche.value.toLowerCase())
  )
)
const totalPages = computed(() =>
  Math.max(1, Math.ceil(proprietairesFiltres.value.length / itemsParPage))
)
const proprietairesPage = computed(() => {
  const start = (pageActuelle.value - 1) * itemsParPage
  return proprietairesFiltres.value.slice(start, start + itemsParPage)
})

function ouvrirFormulaire(p = null) {
  proprietaireEdit.value = p ? { ...p } : null
  modalVisible.value = true
}
function fermerFormulaire() {
  modalVisible.value = false
}
async function handleEnregistrer(p) {
  if (p.id) {
    await axios.put(`/api/proprietaires/${p.id}`, p)
  } else {
    await axios.post(`/api/proprietaires`, p)
  }
  fermerFormulaire()
  await chargerProprietaires()
}
function confirmerSuppression(p) {
  proprietaireSuppression.value = p
  modalSuppressionVisible.value = true
}
async function supprimerProprietaire() {
  await axios.delete(`/api/proprietaires/${proprietaireSuppression.value.id}`)
  modalSuppressionVisible.value = false
  await chargerProprietaires()
}

function changerPage(n) {
  if (n >= 1 && n <= totalPages.value) {
    pageActuelle.value = n
    document.querySelector('.table-responsive')?.scrollIntoView({ behavior: 'smooth' })
  }
}
function resetRecherche() {
  recherche.value = ''
  pageActuelle.value = 1
}
onMounted(() => chargerProprietaires())
watch(recherche, () => (pageActuelle.value = 1))
</script>

<style scoped>
.page {
  background-color: #f9fafc;
}

.action-bar {
  border-radius: 10px;
  position: sticky;
  top: 10px;
  z-index: 999;
}

.search-container {
  position: relative;
}

.search-icon {
  position: absolute;
  top: 50%;
  left: 1rem;
  transform: translateY(-50%);
  color: #888;
}

.form-control {
  border-radius: 10px;
  padding-left: 2.5rem;
  transition: all 0.2s ease-in-out;
}

.clickable-row {
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.clickable-row:hover {
  background-color: #f0f8ff;
}

.table-hover tbody tr:hover td {
  background-color: #f0f8ff;
}

.btn-outline-danger:hover {
  background-color: #f8d7da;
  border-color: #f5c6cb;
}
</style>
