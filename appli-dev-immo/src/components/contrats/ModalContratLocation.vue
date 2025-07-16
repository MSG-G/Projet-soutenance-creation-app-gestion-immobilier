<template>
  <div class="modal-overlay" @click.self="$emit('fermer')">
    <div class="modal-content p-4">
      <h4 class="mb-3 fw-bold text-primary">Contrat de location</h4>
      <form @submit.prevent="valider">
        <div class="mb-3">
          <label class="form-label">Bien</label>
          <select v-model="form.bien_id" class="form-select" required>
            <option value="" disabled>Choisir un bien</option>
            <option v-for="bien in biens" :key="bien.id" :value="bien.id">{{ bien.titre }}</option>
          </select>
          <div v-if="selectedBien" class="alert alert-light p-2 mt-2 border small">
            <p class="mb-1"><strong><i class="fas fa-info-circle me-1"></i> Détails du bien</strong></p>
            <p class="mb-1"><strong>Prix :</strong> {{ selectedBien.prix ? selectedBien.prix.toLocaleString() : 'N/A' }} FCFA</p>
            <p class="mb-0"><strong>Statut :</strong> <span class="badge bg-secondary">{{ selectedBien.statut }}</span></p>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Locataire</label>
          <select v-model="form.client_id" class="form-select" required>
            <option value="" disabled>Choisir un locataire</option>
            <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Agent</label>
          <select v-model="form.agent_id" class="form-select" required>
            <option value="" disabled>Choisir un agent</option>
            <option v-for="agent in agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Montant</label>
          <input v-model.number="form.montant" type="number" class="form-control" required min="0" />
        </div>
        <div class="mb-3">
          <label class="form-label">Date début</label>
          <input v-model="form.date_debut" type="date" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Date fin</label>
          <input v-model="form.date_fin" type="date" class="form-control" required />
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button type="button" class="btn btn-secondary" @click="$emit('fermer')">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { biensApi, usersApi } from '../../utils/apiResources'
const props = defineProps({ contrat: Object })
const emit = defineEmits(['enregistrer', 'fermer'])
const form = ref({ bien_id: '', client_id: '', agent_id: '', montant: '', date_debut: '', date_fin: '' })
const biens = ref([])
const clients = ref([])
const agents = ref([])

const selectedBien = computed(() => {
  return biens.value.find(b => b.id === form.value.bien_id)
})
const valider = () => {
  if (form.value.bien_id && form.value.client_id && form.value.agent_id && form.value.montant && form.value.date_debut && form.value.date_fin) {
    emit('enregistrer', { ...form.value })
  }
}
onMounted(async () => {
  try {
    const [biensRes, clientsRes, agentsRes] = await Promise.all([
      biensApi.list(),
      usersApi.listClients(),
      usersApi.listAgents()
    ])
    biens.value = biensRes.data.filter(b => b.statut !== 'loué')
    clients.value = clientsRes.data
    agents.value = agentsRes.data
  } catch (error) {
    console.error('Erreur lors du chargement des données pour le formulaire:', error)
    // Optionnel: afficher un message d'erreur à l'utilisateur
  }
})
watch(() => form.value.bien_id, (newBienId) => {
  if (newBienId) {
    const bien = biens.value.find(b => b.id === newBienId)
    if (bien) {
      form.value.montant = bien.prix
    }
  }
})

watch(() => props.contrat, (newContrat) => {
  if (newContrat) {
    form.value = {
      id: newContrat.id,
      bien_id: newContrat.bien_id || (newContrat.bien ? newContrat.bien.id : ''),
      client_id: newContrat.client_id || (newContrat.client ? newContrat.client.id : ''),
      agent_id: newContrat.agent_id || (newContrat.agent ? newContrat.agent.id : ''),
      montant: newContrat.montant,
      date_debut: newContrat.date_debut ? newContrat.date_debut.split('T')[0] : '',
      date_fin: newContrat.date_fin ? newContrat.date_fin.split('T')[0] : ''
    }
  } else {
    form.value = { bien_id: '', client_id: '', agent_id: '', montant: '', date_debut: '', date_fin: '' }
  }
}, { immediate: true, deep: true })
</script>
<style scoped>
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 2000; }
.modal-content { background: white; border-radius: 14px; max-width: 420px; width: 100%; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
</style> 