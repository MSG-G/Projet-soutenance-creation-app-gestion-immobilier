<template>
  <div class="modal-confirmation">
    <div class="modal-content">
      <p>{{ message }}</p>
      <div class="d-flex gap-2 mt-3">
        <button class="btn btn-danger" @click="$emit('confirmer')">Confirmer</button>
        <button class="btn btn-secondary" @click="$emit('annuler')">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  message: { type: String, required: true }
})
</script>

<style scoped>
.modal-confirmation {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.modal-content {
  background: #fff;
  padding: 2rem;
  border-radius: 10px;
  min-width: 320px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.15);
}
</style> 