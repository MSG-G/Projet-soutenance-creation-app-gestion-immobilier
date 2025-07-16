<template>
  <transition name="modal-fade">
    <div v-if="visible" class="modal-backdrop" @click.self="annuler">
      <div class="modal-content delete-modal">
        <div class="text-center">
          <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
          <h4 class="mb-2">Suppression</h4>
          <p class="mb-4" style="word-break:break-word;max-width:90vw;overflow:auto;">
            {{ message }}
          </p>
          <div class="d-flex gap-3 justify-content-center">
            <button class="btn btn-outline-secondary btn-lg" @click="annuler">Annuler</button>
            <button class="btn btn-danger btn-lg" @click="confirmer" :disabled="loading">
              <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({
  message: String,
  visible: Boolean,
  loading: Boolean
})
const emit = defineEmits(['confirmer', 'annuler'])
function confirmer() { emit('confirmer') }
function annuler() { emit('annuler') }
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
  padding: 1rem;
  backdrop-filter: blur(2px);
}
.delete-modal {
  background: #fff;
  border-radius: 16px;
  padding: 2.5rem 2rem;
  max-width: 400px;
  width: 100%;
  box-shadow: 0 8px 40px rgba(0,0,0,0.13);
  animation: slideInUp 0.4s cubic-bezier(.4,2,.6,1) both;
  overflow-y: auto;
  max-height: 90vh;
}
@keyframes slideInUp {
  from { transform: translateY(40px) scale(0.98); opacity: 0; }
  to { transform: translateY(0) scale(1); opacity: 1; }
}
::-webkit-scrollbar {
  width: 8px;
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #bdbdbd;
  border-radius: 6px;
}
::-webkit-scrollbar-thumb:hover {
  background: #888;
}
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.3s;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
</style> 