<template>
  <div v-if="visible" class="modal-backdrop" @click.self="$emit('fermer')">
    <div class="modal-content animate-slide">
      <h4 class="mb-3 text-center">Détail de la ville</h4>
      <div class="mb-3"><strong>Nom :</strong> {{ ville.nom }}</div>
      <div class="mb-3"><strong>Région :</strong> {{ ville.region || '-' }}</div>
      <div class="mb-3"><strong>Code postal :</strong> {{ ville.code_postal || '-' }}</div>
      <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-outline-secondary" @click="$emit('fermer')">Fermer</button>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({ visible: Boolean, ville: Object })
const emit = defineEmits(['fermer'])
</script>
<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  width: 100vw;
  min-height: 100vh;
  background: rgba(30, 41, 59, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  overflow-y: auto;
  animation: fadeInBg 0.3s;
}
.modal-content {
  background: #fff;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  min-width: 320px;
  max-width: 520px;
  width: 100%;
  margin: 0 auto;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  animation: slideIn 0.3s;
  position: relative;
  text-align: left;
}
@keyframes fadeInBg {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes slideIn {
  from { transform: translateY(40px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
