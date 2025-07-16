<template>
  <div class="container-fluid p-4 admin-dashboard">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Gestion des contrats</h2>
        <p class="text-muted fs-6">Contrats de vente et de location (biens, clients, agents, montants, dates)</p>
      </div>
      <div class="dropdown">
        <button class="btn btn-primary btn-lg shadow-sm dropdown-toggle" type="button" id="nouveauContratDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-plus me-2"></i> Nouveau contrat
        </button>
        <ul class="dropdown-menu" aria-labelledby="nouveauContratDropdown">
          <li><a class="dropdown-item" href="#" @click.prevent="openVenteModal">Contrat de vente</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="openLocationModal">Contrat de location</a></li>
        </ul>
      </div>
    </div>
    <div v-if="notification.message" :class="`alert alert-${notification.type} alert-dismissible fade show`" role="alert">
      {{ notification.message }}
      <button type="button" class="btn-close" @click="notification.message = ''"></button>
    </div>
    <div class="filter-section mb-4 d-flex flex-wrap align-items-center gap-3">
      <select v-model="filterType" class="form-select w-auto shadow-sm">
        <option value="">Tous types</option>
        <option value="vente">Vente</option>
        <option value="location">Location</option>
      </select>
      <input v-model="searchQuery" type="search" class="form-control shadow-sm" placeholder="Rechercher un contrat..." style="max-width: 300px;" />
    </div>
    <div v-if="loading" class="text-center py-5">
      <span class="spinner-border text-primary"></span>
    </div>
    <div v-else>
      <div v-if="contrats.length === 0" class="text-muted text-center py-5">Aucun contrat trouvé.</div>
      <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
          <thead class="table-light">
            <tr>
              <th>Type</th>
              <th>Bien</th>
              <th>Client</th>
              <th>Agent</th>
              <th>Montant</th>
              <th>Date début</th>
              <th>Date fin</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contrat in filteredContrats" :key="contrat.id">
              <td>
                <span :class="{'badge bg-success': contrat.type === 'vente', 'badge bg-primary': contrat.type === 'location'}">
                  {{ contrat.type === 'vente' ? 'Vente' : 'Location' }}
                </span>
              </td>
              <td>{{ contrat.bien?.titre || '—' }}</td>
              <td>{{ contrat.client?.name || '—' }}</td>
              <td>{{ contrat.agent?.name || '—' }}</td>
              <td>{{ contrat.montant ? contrat.montant.toLocaleString() + ' FCFA' : '—' }}</td>
              <td>{{ contrat.date_debut ? new Date(contrat.date_debut).toLocaleDateString() : '—' }}</td>
              <td>{{ contrat.date_fin ? new Date(contrat.date_fin).toLocaleDateString() : '—' }}</td>
              <td>
                <button class="btn btn-sm btn-outline-info me-1" @click="viewContrat(contrat)"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning me-1" @click="editContrat(contrat)"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(contrat)"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Modales -->
    <ModalContratVente v-if="showVenteModal" :contrat="contratToEdit" @enregistrer="handleSaveVente" @fermer="closeVenteModal" />
    <ModalContratLocation v-if="showLocationModal" :contrat="contratToEdit" @enregistrer="handleSaveLocation" @fermer="closeLocationModal" />
    <ModalConfirmation v-if="showDeleteModal" :visible="showDeleteModal" :message="'Supprimer ce contrat ?'" @confirmer="deleteContrat" @annuler="showDeleteModal = false" />
    <ModalVoirContrat v-if="showViewModal" :contrat="contratToView" @fermer="showViewModal = false" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ModalContratVente from '@/components/contrats/ModalContratVente.vue'
import ModalContratLocation from '@/components/contrats/ModalContratLocation.vue'
import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
import ModalVoirContrat from '@/components/contrats/ModalVoirContrat.vue'
import { contratsApi } from '../../utils/apiResources'

const contrats = ref([])
const loading = ref(true)
const filterType = ref('')
const searchQuery = ref('')
const showVenteModal = ref(false)
const showLocationModal = ref(false)
const showDeleteModal = ref(false)
const showViewModal = ref(false)
const contratToEdit = ref(null)
const contratToView = ref(null)
const contratToDelete = ref(null)
const notification = ref({ message: '', type: 'success' })

const fetchContrats = async () => {
  loading.value = true
  try {
    const res = await contratsApi.list()
    contrats.value = res.data
  } catch (e) {
    contrats.value = []
  } finally {
    loading.value = false
  }
}
onMounted(fetchContrats)

const filteredContrats = computed(() => {
  let list = contrats.value
  if (filterType.value) list = list.filter(c => c.type === filterType.value)
  if (searchQuery.value) {
    list = list.filter(c =>
      (c.bien?.titre || '').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (c.client?.name || '').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (c.agent?.name || '').toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }
  return list
})

const openVenteModal = () => { contratToEdit.value = null; showVenteModal.value = true }
const openLocationModal = () => { contratToEdit.value = null; showLocationModal.value = true }
const closeVenteModal = () => { showVenteModal.value = false }
const closeLocationModal = () => { showLocationModal.value = false }
const handleSaveVente = async (contratData) => {
  try {
    const message = contratData.id ? 'Contrat de vente mis à jour avec succès !' : 'Contrat de vente créé avec succès !';
    if (contratData.id) {
      await contratsApi.update(contratData.id, { ...contratData, type: 'vente' });
    } else {
      await contratsApi.create({ ...contratData, type: 'vente' });
    }
    fetchContrats();
    closeVenteModal();
    notification.value = { message, type: 'success' };
    setTimeout(() => notification.value.message = '', 3000);
  } catch (error) {
    console.error("Erreur lors de l'enregistrement du contrat de vente:", error);
    notification.value = { message: "Une erreur s'est produite lors de l'enregistrement.", type: 'danger' };
  }
};

const handleSaveLocation = async (contratData) => {
  try {
    const message = contratData.id ? 'Contrat de location mis à jour avec succès !' : 'Contrat de location créé avec succès !';
    if (contratData.id) {
      await contratsApi.update(contratData.id, { ...contratData, type: 'location' });
    } else {
      await contratsApi.create({ ...contratData, type: 'location' });
    }
    fetchContrats();
    closeLocationModal();
    notification.value = { message, type: 'success' };
    setTimeout(() => notification.value.message = '', 3000);
  } catch (error) {
    console.error("Erreur lors de l'enregistrement du contrat de location:", error);
    notification.value = { message: "Une erreur s'est produite lors de l'enregistrement.", type: 'danger' };
  }
};
const editContrat = (contrat) => {
  contratToEdit.value = { ...contrat }
  if (contrat.type === 'vente') showVenteModal.value = true
  else showLocationModal.value = true
}
const confirmDelete = (contrat) => { contratToDelete.value = contrat; showDeleteModal.value = true }
const deleteContrat = async () => { await contratsApi.remove(contratToDelete.value.id); fetchContrats(); showDeleteModal.value = false }
const viewContrat = (contrat) => { contratToView.value = contrat; showViewModal.value = true }
</script>

<style scoped>
.table-responsive { border-radius: 12px; overflow: hidden; }
.table { margin: 0; }
</style> 