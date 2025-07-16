<template>
  <div class="container-fluid p-4 admin-dashboard">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Biens vendus</h2>
        <p class="text-muted fs-6">Liste des biens immobiliers vendus et gestion des ventes</p>
      </div>
      <button @click="openAddVenteModal" class="btn btn-success btn-lg shadow-sm">
        <i class="fas fa-plus me-2"></i> Ajouter une vente
      </button>
    </div>
    <div class="filter-section mb-4 d-flex flex-wrap align-items-center gap-3">
      <input v-model="searchQuery" type="search" class="form-control shadow-sm" placeholder="Rechercher un bien vendu..." style="max-width: 300px;" />
      <input v-model="filterDate" type="date" class="form-control shadow-sm" style="max-width: 180px;" />
    </div>
    <div v-if="loading" class="text-center py-5">
      <span class="spinner-border text-primary"></span>
    </div>
    <div v-else>
      <div v-if="biensVendus.length === 0" class="text-muted text-center py-5">Aucun bien vendu trouvé.</div>
      <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
          <thead class="table-light">
            <tr>
              <th>Titre</th>
              <th>Prix</th>
              <th>Adresse</th>
              <th>Acheteur</th>
              <th>Date de vente</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="bien in filteredBiensVendus" :key="bien.id">
              <td>{{ bien.titre }}</td>
              <td>{{ bien.prix.toLocaleString() }} FCFA</td>
              <td>{{ bien.adresse }}</td>
              <td>{{ bien.acheteur?.name || '—' }}</td>
              <td>{{ bien.date_vente ? new Date(bien.date_vente).toLocaleDateString() : '—' }}</td>
              <td>
                <button class="btn btn-sm btn-outline-info me-1" @click="viewBien(bien)"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-danger me-1" @click="confirmDelete(bien)"><i class="fas fa-trash"></i></button>
                <button v-if="bien.contratVente" class="btn btn-sm btn-outline-primary" @click="viewContrat(bien.contratVente)"><i class="fas fa-file-contract"></i> Voir contrat</button>
                <button v-else class="btn btn-sm btn-outline-success" @click="openContratVenteModal(bien)"><i class="fas fa-file-signature"></i> Créer contrat</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Modal d'ajout/édition de vente -->
    <ModalVente v-if="showAddModal" @ajouter="addVente" @fermer="closeAddVenteModal" />
    <!-- Modal de confirmation de suppression -->
    <ModalConfirmation v-if="showDeleteModal" :visible="showDeleteModal" :message="'Supprimer la vente du bien ' + bienToDelete?.titre + ' ?'" @confirmer="deleteVente" @annuler="showDeleteModal = false" />
    <!-- Modal de détail -->
    <ModalVoirBien v-if="showViewModal" :bien="bienToView" @fermer="showViewModal = false" />
    <!-- Modal de création/édition de contrat de vente -->
    <ModalContratVente v-if="showContratVenteModal" :contrat="contratToEdit" @enregistrer="handleSaveVente" @fermer="() => showContratVenteModal.value = false" />
    <!-- Modal de détail du contrat -->
    <ModalVoirContrat v-if="showVoirContratModal" :contrat="contratToView" @fermer="() => showVoirContratModal.value = false" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ModalVente from '@/components/biens/ModalVente.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
import ModalVoirBien from '@/components/biens/ModalVoirBien.vue'
import ModalContratVente from '@/components/contrats/ModalContratVente.vue'
import ModalVoirContrat from '@/components/contrats/ModalVoirContrat.vue'
import { biensApi } from '../../utils/apiResources'
import { contratsApi } from '../../utils/apiResources'

const biensVendus = ref([])
const loading = ref(true)
const searchQuery = ref('')
const filterDate = ref('')
const showAddModal = ref(false)
const showDeleteModal = ref(false)
const showViewModal = ref(false)
const bienToDelete = ref(null)
const bienToView = ref(null)
const showContratVenteModal = ref(false)
const showVoirContratModal = ref(false)
const contratToEdit = ref(null)
const contratToView = ref(null)

const fetchBiensVendus = async () => {
  loading.value = true
  try {
    const res = await biensApi.list()
    // On suppose que le backend renvoie les contrats ou un champ statut
    biensVendus.value = res.data.filter(b => b.statut === 'vendu')
  } catch (e) {
    biensVendus.value = []
  } finally {
    loading.value = false
  }
}
onMounted(fetchBiensVendus)

const filteredBiensVendus = computed(() => {
  let list = biensVendus.value
  if (searchQuery.value) {
    list = list.filter(b => b.titre.toLowerCase().includes(searchQuery.value.toLowerCase()) || b.adresse?.toLowerCase().includes(searchQuery.value.toLowerCase()))
  }
  if (filterDate.value) {
    list = list.filter(b => b.date_vente && b.date_vente.startsWith(filterDate.value))
  }
  return list
})

const openAddVenteModal = () => { showAddModal.value = true }
const closeAddVenteModal = () => { showAddModal.value = false }
const addVente = async (vente) => { /* Appel API pour ajouter une vente */ fetchBiensVendus(); closeAddVenteModal() }
const confirmDelete = (bien) => { bienToDelete.value = bien; showDeleteModal.value = true }
const deleteVente = async () => { /* Appel API pour supprimer la vente */ fetchBiensVendus(); showDeleteModal.value = false }
const viewBien = (bien) => { bienToView.value = bien; showViewModal.value = true }

const openContratVenteModal = (bien) => {
  contratToEdit.value = {
    bien_id: bien.id,
    client_id: bien.acheteur?.id || '',
    agent_id: '',
    montant: bien.prix,
    date_debut: bien.date_vente || ''
  }
  showContratVenteModal.value = true
}
const viewContrat = (contrat) => {
  contratToView.value = contrat
  showVoirContratModal.value = true
}
const handleSaveVente = async (contrat) => {
  await contratsApi.create({ ...contrat, type: 'vente' })
  showContratVenteModal.value = false
}
</script>

<style scoped>
.table-responsive { border-radius: 12px; overflow: hidden; }
.table { margin: 0; }
</style> 