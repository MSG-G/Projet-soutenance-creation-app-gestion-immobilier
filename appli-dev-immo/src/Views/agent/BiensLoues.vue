<template>
  <div class="container-fluid p-4 admin-dashboard">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Biens loués</h2>
        <p class="text-muted fs-6">Liste des biens immobiliers loués et gestion des locations</p>
      </div>
      <button @click="openAddLocationModal" class="btn btn-success btn-lg shadow-sm">
        <i class="fas fa-plus me-2"></i> Ajouter une location
      </button>
    </div>
    <div class="filter-section mb-4 d-flex flex-wrap align-items-center gap-3">
      <input v-model="searchQuery" type="search" class="form-control shadow-sm" placeholder="Rechercher un bien loué..." style="max-width: 300px;" />
      <input v-model="filterDate" type="date" class="form-control shadow-sm" style="max-width: 180px;" />
    </div>
    <div v-if="loading" class="text-center py-5">
      <span class="spinner-border text-primary"></span>
    </div>
    <div v-else>
      <div v-if="biensLoues.length === 0" class="text-muted text-center py-5">Aucun bien loué trouvé.</div>
      <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
          <thead class="table-light">
            <tr>
              <th>Titre</th>
              <th>Prix</th>
              <th>Adresse</th>
              <th>Locataire</th>
              <th>Date début</th>
              <th>Date fin</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="bien in filteredBiensLoues" :key="bien.id">
              <td>{{ bien.titre }}</td>
              <td>{{ bien.prix.toLocaleString() }} FCFA</td>
              <td>{{ bien.adresse }}</td>
              <td>{{ bien.locataire?.name || '—' }}</td>
              <td>{{ bien.date_debut ? new Date(bien.date_debut).toLocaleDateString() : '—' }}</td>
              <td>{{ bien.date_fin ? new Date(bien.date_fin).toLocaleDateString() : '—' }}</td>
              <td>
                <button class="btn btn-sm btn-outline-info me-1" @click="viewBien(bien)"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-danger me-1" @click="confirmDelete(bien)"><i class="fas fa-trash"></i></button>
                <button v-if="bien.contratLocation" class="btn btn-sm btn-outline-primary" @click="viewContrat(bien.contratLocation)"><i class="fas fa-file-contract"></i> Voir contrat</button>
                <button v-else class="btn btn-sm btn-outline-success" @click="openContratLocationModal(bien)"><i class="fas fa-file-signature"></i> Créer contrat</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Modal d'ajout/édition de location -->
    <ModalLocation v-if="showAddModal" @ajouter="addLocation" @fermer="closeAddLocationModal" />
    <!-- Modal de confirmation de suppression -->
    <ModalConfirmation v-if="showDeleteModal" :visible="showDeleteModal" :message="'Supprimer la location du bien ' + bienToDelete?.titre + ' ?'" @confirmer="deleteLocation" @annuler="showDeleteModal = false" />
    <!-- Modal de détail -->
    <ModalVoirBien v-if="showViewModal" :bien="bienToView" @fermer="showViewModal = false" />
    <!-- Modal de création/édition de contrat de location -->
    <ModalContratLocation v-if="showContratLocationModal" :contrat="contratToEdit" @enregistrer="handleSaveLocation" @fermer="() => showContratLocationModal.value = false" />
    <!-- Modal de détail du contrat -->
    <ModalVoirContrat v-if="showVoirContratModal" :contrat="contratToView" @fermer="() => showVoirContratModal.value = false" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ModalLocation from '@/components/biens/ModalLocation.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
import ModalVoirBien from '@/components/biens/ModalVoirBien.vue'
import ModalContratLocation from '@/components/contrats/ModalContratLocation.vue'
import ModalVoirContrat from '@/components/contrats/ModalVoirContrat.vue'
import { biensApi, contratsApi } from '../../utils/apiResources'

const biensLoues = ref([])
const loading = ref(true)
const searchQuery = ref('')
const filterDate = ref('')
const showAddModal = ref(false)
const showDeleteModal = ref(false)
const showViewModal = ref(false)
const bienToDelete = ref(null)
const bienToView = ref(null)
const showContratLocationModal = ref(false)
const showVoirContratModal = ref(false)
const contratToEdit = ref(null)
const contratToView = ref(null)

const fetchBiensLoues = async () => {
  loading.value = true
  try {
    const res = await biensApi.list()
    biensLoues.value = res.data.filter(b => b.statut === 'loué')
  } catch (e) {
    biensLoues.value = []
  } finally {
    loading.value = false
  }
}
onMounted(fetchBiensLoues)

const filteredBiensLoues = computed(() => {
  let list = biensLoues.value
  if (searchQuery.value) {
    list = list.filter(b => b.titre.toLowerCase().includes(searchQuery.value.toLowerCase()) || b.adresse?.toLowerCase().includes(searchQuery.value.toLowerCase()))
  }
  if (filterDate.value) {
    list = list.filter(b => b.date_debut && b.date_debut.startsWith(filterDate.value))
  }
  return list
})

const openAddLocationModal = () => { showAddModal.value = true }
const closeAddLocationModal = () => { showAddModal.value = false }
const addLocation = async (location) => {
  try {
    await reservationsApi.create(location)
    await fetchBiensLoues()
  } catch (e) {
    alert('Erreur lors de la création de la location')
  } finally {
    closeAddLocationModal()
  }
}
const confirmDelete = (bien) => { bienToDelete.value = bien; showDeleteModal.value = true }
const deleteLocation = async () => { /* Appel API pour supprimer la location */ fetchBiensLoues(); showDeleteModal.value = false }
const viewBien = (bien) => { bienToView.value = bien; showViewModal.value = true }

const openContratLocationModal = (bien) => {
  contratToEdit.value = {
    bien_id: bien.id,
    client_id: bien.locataire?.id || '',
    agent_id: '',
    montant: bien.prix,
    date_debut: bien.date_debut || '',
    date_fin: bien.date_fin || ''
  }
  showContratLocationModal.value = true
}
const viewContrat = (contrat) => {
  contratToView.value = contrat
  showVoirContratModal.value = true
}
const handleSaveLocation = async (contrat) => {
  await contratsApi.create({ ...contrat, type: 'location' })
  showContratLocationModal.value = false
}
</script>

<style scoped>
.table-responsive { border-radius: 12px; overflow: hidden; }
.table { margin: 0; }
</style> 