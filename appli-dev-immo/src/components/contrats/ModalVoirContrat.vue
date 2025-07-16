<template>
  <div class="modal-overlay" @click.self="$emit('fermer')">
    <div class="modal-content p-4">
      <h4 class="mb-3 fw-bold text-primary">Détail du contrat</h4>
      <div class="mb-3">
        <span class="badge bg-success" v-if="contrat.type === 'vente'">Vente</span>
        <span class="badge bg-primary" v-else-if="contrat.type === 'location'">Location</span>
      </div>
      <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Bien :</strong> {{ contrat.bien?.titre || '—' }}</li>
        <li class="list-group-item"><strong>Client :</strong> {{ contrat.client?.name || '—' }}</li>
        <li class="list-group-item"><strong>Agent :</strong> {{ contrat.agent?.name || '—' }}</li>
        <li class="list-group-item"><strong>Montant :</strong> {{ contrat.montant ? contrat.montant.toLocaleString() + ' FCFA' : '—' }}</li>
        <li class="list-group-item"><strong>Date début :</strong> {{ contrat.date_debut ? new Date(contrat.date_debut).toLocaleDateString() : '—' }}</li>
        <li class="list-group-item" v-if="contrat.type === 'location'"><strong>Date fin :</strong> {{ contrat.date_fin ? new Date(contrat.date_fin).toLocaleDateString() : '—' }}</li>
      </ul>
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary" @click="$emit('fermer')">Fermer</button>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({ contrat: Object })
</script>
<style scoped>
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 2000; }
.modal-content { background: white; border-radius: 14px; max-width: 420px; width: 100%; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
.list-group-item { border: none; padding-left: 0; }
</style> 