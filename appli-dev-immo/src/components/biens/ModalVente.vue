<template>
  <div class="modal-overlay" @click.self="$emit('fermer')">
    <div class="modal-content p-4">
      <h4 class="mb-3 fw-bold text-success">Ajouter une vente</h4>
      <form @submit.prevent="valider">
        <div class="mb-3">
          <label class="form-label">Bien</label>
          <select v-model="form.bien_id" class="form-select" required>
            <option value="" disabled>Choisir un bien</option>
            <option v-for="bien in biens" :key="bien.id" :value="bien.id">{{ bien.titre }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Acheteur</label>
          <select v-model="form.acheteur_id" class="form-select" required>
            <option value="" disabled>Choisir un acheteur</option>
            <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Prix de vente</label>
          <input v-model.number="form.prix" type="number" class="form-control" required min="0" />
        </div>
        <div class="mb-3">
          <label class="form-label">Date de vente</label>
          <input v-model="form.date_vente" type="date" class="form-control" required />
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button type="button" class="btn btn-secondary" @click="$emit('fermer')">Annuler</button>
          <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { biensApi, usersApi } from '../../utils/apiResources'
const emit = defineEmits(['ajouter', 'fermer'])
const form = ref({ bien_id: '', acheteur_id: '', prix: '', date_vente: '' })
const biens = ref([])
const clients = ref([])
const valider = () => {
  if (form.value.bien_id && form.value.acheteur_id && form.value.prix && form.value.date_vente) {
    emit('ajouter', { ...form.value })
  }
}
onMounted(async () => {
  const biensRes = await biensApi.list()
  biens.value = biensRes.data.filter(b => b.statut !== 'vendu')
  const usersRes = await usersApi.list()
  clients.value = usersRes.data.filter(u => u.role === 'client' || u.role === 'Client')
})
</script>
<style scoped>
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 2000; }
.modal-content { background: white; border-radius: 14px; max-width: 420px; width: 100%; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
</style> 