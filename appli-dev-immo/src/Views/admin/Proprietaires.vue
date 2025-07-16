<template>
  <div class="layout">
    <main class="page p-4">
      <!-- En-tête -->
      <div class="header mb-4">
        <h2 class="fw-semibold mb-1 text-primary">👤 Gestion des utilisateurs</h2>
        <p class="text-muted mb-0">Consultez, ajoutez ou modifiez les comptes utilisateurs.</p>
      </div>

      <!-- Barre d’actions -->
      <div class="action-bar sticky-top d-flex flex-wrap gap-3 align-items-center py-3 bg-white shadow-sm px-3 rounded mb-4">
        <div class="search-container position-relative flex-grow-1">
          <input
            v-model="recherche"
            class="form-control ps-5"
            placeholder="🔍 Rechercher un utilisateur..."
            @input="pageActuelle = 1"
          />
          <i class="fas fa-search search-icon"></i>
        </div>
        <button @click="resetRecherche" class="btn btn-light border shadow-sm" title="Réinitialiser">
          <i class="fas fa-sync-alt"></i>
        </button>
        <button @click="ouvrirFormulaire()" class="btn btn-success d-flex align-items-center gap-2">
          <i class="fas fa-plus"></i> Ajouter
        </button>
      </div>

      <!-- États -->
      <ErrorAlert v-if="erreur" :message="erreur" />
      <Loader v-if="chargement" />

      <!-- Liste des propriétaires en cards -->
      <div class="row" v-if="!chargement && proprietairesFiltres.length">
        <div
          v-for="p in proprietairesFiltres"
          :key="p.id"
          class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"
        >
          <div class="card-user shadow-sm p-3 text-center animate__animated animate__fadeIn">
            <i class="fas fa-user text-secondary role-icon mb-3"></i>
            <h5 class="mb-1">{{ p.nom }} {{ p.prenom }}</h5>
            <p class="mb-1 text-muted">{{ p.email }}</p>
            <p class="mb-1"><i class="fas fa-phone me-1"></i> {{ p.telephone }}</p>
            <span class="badge bg-secondary mb-2 text-uppercase small">Propriétaire</span>
            <div class="d-flex justify-content-center gap-2 mt-2">
              <button class="btn btn-sm btn-outline-primary" @click="ouvrirFormulaire(p)">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" @click="confirmerSuppression(p)">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="!chargement" class="alert alert-warning text-center">
        Aucun propriétaire trouvé.
      </div>

      <!-- Modals -->
      <ModalProprietaire
        v-if="modalVisible"
        :proprietaire="proprietaireEdit"
        :erreurApi="erreurApi"
        @fermer="fermerFormulaire"
        @enregistrer="handleEnregistrer"
      />
      <ModalConfirmation
        :visible="modalSuppressionVisible"
        :message="`Supprimer l'utilisateur '${proprietaireSuppression?.nom}' ?`"
        @confirmer="supprimerProprietaire"
        @annuler="modalSuppressionVisible = false"
      />
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import ModalProprietaire from '@/components/proprietaires/ModalProprietaire.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
import Loader from '@/components/Loader.vue'
import ErrorAlert from '@/components/ErrorAlert.vue'
import { proprietairesApi } from '@/utils/apiResources'

const proprietaires = ref([])
const chargement = ref(false)
const erreur = ref("")
const erreurApi = ref("")
const recherche = ref("")
const modalVisible = ref(false)
const modalSuppressionVisible = ref(false)
const proprietaireEdit = ref(null)
const proprietaireSuppression = ref(null)

const chargerProprietaires = async () => {
  chargement.value = true
  try {
    const res = await proprietairesApi.list()
    proprietaires.value = res.data
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors du chargement des propriétaires'
  } finally {
    chargement.value = false
  }
}

const proprietairesFiltres = computed(() =>
  proprietaires.value.filter(p =>
    p.nom.toLowerCase().includes(recherche.value.toLowerCase()) ||
    p.email?.toLowerCase().includes(recherche.value.toLowerCase())
  )
)

function ouvrirFormulaire(p = null) {
  proprietaireEdit.value = p ? { ...p } : null
  erreurApi.value = ""
  modalVisible.value = true
}
function fermerFormulaire() {
  modalVisible.value = false
  erreurApi.value = ""
}
async function handleEnregistrer(p) {
  try {
    if (p.id) {
      await proprietairesApi.update(p.id, p)
    } else {
      await proprietairesApi.create(p)
    }
    fermerFormulaire()
    await chargerProprietaires()
  } catch (err) {
    // Affiche le message d'erreur du backend
    if (err.response?.data?.errors) {
      // Si l'API retourne un objet errors (Laravel), affiche le premier message
      const errors = err.response.data.errors
      erreurApi.value = Object.values(errors).flat().join(' ')
    } else {
      erreurApi.value = err.response?.data?.message || 'Erreur lors de l’enregistrement.'
    }
  }
}
function confirmerSuppression(p) {
  proprietaireSuppression.value = p
  modalSuppressionVisible.value = true
}
async function supprimerProprietaire() {
  await proprietairesApi.remove(proprietaireSuppression.value.id)
  modalSuppressionVisible.value = false
  await chargerProprietaires()
}
function resetRecherche() {
  recherche.value = ''
}
onMounted(chargerProprietaires)
</script>

<style scoped>
.page {
  background: #f8f9fa;
}
.action-bar {
  border-radius: 10px;
  position: sticky;
  top: 10px;
  z-index: 10;
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
  transition: border-color 0.2s;
}
.card-user {
  background-color: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.25s ease-in-out;
}
.card-user:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.1);
}
.role-icon {
  font-size: 2.2rem;
}
</style>
