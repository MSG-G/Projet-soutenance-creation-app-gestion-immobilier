<template>
  <!-- APRÈS -->
<div v-if="visible" class="modal-backdrop">
    <div class="modal-content animate-slide">
      <h4 class="mb-3 text-center">{{ props.typeBien ? 'Modifier un type de bien' : 'Ajouter un type de bien' }}</h4>
      <form @submit.prevent="submit" novalidate>
        <div class="mb-3">
          <label class="form-label">Nom <span class="text-danger">*</span></label>
          <input v-model="form.nom" type="text" class="form-control" :class="{'is-invalid': errors.nom}" required />
          <div v-if="errors.nom" class="invalid-feedback">{{ errors.nom }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea v-model="form.description" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="button" class="btn btn-outline-secondary" @click="close">Annuler</button>
          <button type="submit" class="btn btn-success" :disabled="loading">
            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
            {{ props.typeBien ? 'Mettre à jour' : 'Ajouter' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive } from 'vue'
import { useTypesBienStore } from '../../stores/useTypesBienStore'

const props = defineProps({ visible: Boolean, typeBien: Object })
const emit = defineEmits(['close', 'saved'])
const form = reactive({ nom: '', description: '' })
const errors = reactive({ nom: '' })
const loading = ref(false)
const store = useTypesBienStore()

function reset() {
  form.nom = ''
  form.description = ''
  errors.nom = ''
}

function close() {
  reset()
  emit('close')
}

import { watch } from 'vue'

watch(
  () => [props.visible, props.typeBien],
  ([visible, typeBien]) => {
    if (visible) {
      if (typeBien) {
        form.nom = typeBien.nom || ''
        form.description = typeBien.description || ''
      } else {
        form.nom = ''
        form.description = ''
      }
      errors.nom = ''
    }
  },
  { immediate: true }
)

async function submit() {
  errors.nom = form.nom ? '' : 'Le nom est requis.'
  if (!form.nom) return
  loading.value = true
  try {
    if (props.typeBien && props.typeBien.id) {
      await store.updateTypeBien(props.typeBien.id, { nom: form.nom, description: form.description })
    } else {
      await store.addTypeBien({ nom: form.nom, description: form.description })
    }
    emit('saved')
    close()
  } catch (e) {
    errors.nom = e?.response?.data?.errors?.nom?.[0] || `Erreur lors de l'${props.typeBien ? 'édition' : 'ajout'}.`
  } finally {
    loading.value = false
  }
}
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
  z-index: 3000;
  overflow-y: auto;
  animation: fadeInBg 0.3s;
}
@media (max-width: 600px) {
  .modal-backdrop {
    align-items: center;
    padding: 0;
  }
}

.modal-content {
  background: #fff;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  min-width: 320px;
  max-width: 520px;
  width: 100%;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  animation: slideIn 0.3s;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
@media (max-width: 600px) {
  .modal-content {
    padding: 1.2rem 0.7rem;
    min-width: 0;
    max-width: 98vw;
  }
}

.is-invalid { border-color: #e74c3c !important; }
.invalid-feedback { color: #e74c3c; font-size: 0.85rem; }
@media (max-width: 600px) {
  .modal-content {
    padding: 1.2rem 0.7rem;
    max-width: 99vw;
  }
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