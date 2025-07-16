<template>
  <div v-if="visible" class="modal-backdrop" @click.self="close">
    <div class="modal-content animate-slide">
      <h4 class="mb-3 text-center">{{ props.ville ? 'Modifier une ville' : 'Ajouter une ville' }}</h4>
      <form @submit.prevent="submit" novalidate>
        <div class="mb-3">
          <label class="form-label">Nom <span class="text-danger">*</span></label>
          <input v-model="form.nom" type="text" class="form-control" :class="{'is-invalid': errors.nom}" required />
          <div v-if="errors.nom" class="invalid-feedback">{{ errors.nom }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Région</label>
          <input v-model="form.region" type="text" class="form-control" />
        </div>
        <div class="mb-3">
  <label class="form-label">Code postal</label>
  <div class="input-group">
    <input :type="showCodePostal ? 'text' : 'password'" v-model="form.code_postal" class="form-control" />
    <button type="button" class="btn btn-outline-secondary" tabindex="-1" @click="showCodePostal = !showCodePostal">
      <span v-if="showCodePostal"><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='currentColor' class='bi bi-eye-slash' viewBox='0 0 16 16'><path d='M13.359 11.238c.563-.59 1.07-1.25 1.487-1.97C14.71 8.77 15 8.385 15 8c0-.385-.29-.77-.154-.768a13.133 13.133 0 0 0-2.002-2.418A7.11 7.11 0 0 0 8 3.5c-1.51 0-2.94.442-4.143 1.314A13.133 13.133 0 0 0 1.154 7.232C1.29 7.23 1 7.615 1 8c0 .385.29.77.154.768a13.133 13.133 0 0 0 2.002 2.418A7.11 7.11 0 0 0 8 12.5c1.51 0 2.94-.442 4.143-1.314a13.133 13.133 0 0 0 1.216-1.18zm-1.415-1.415a5.972 5.972 0 0 1-1.216 1.18A6.11 6.11 0 0 1 8 11.5c-1.19 0-2.33-.35-3.228-.997A11.133 11.133 0 0 1 2.154 8c.12-.175.253-.348.397-.518A11.133 11.133 0 0 1 4.772 5.497 6.11 6.11 0 0 1 8 4.5c1.19 0 2.33.35 3.228.997A11.133 11.133 0 0 1 13.846 8c-.12.175-.253.348-.397.518z'/></svg></span>
      <span v-else><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'><path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4.5c-2.485 0-4.5-2.015-4.5-4.5S5.515 3.5 8 3.5s4.5 2.015 4.5 4.5-2.015 4.5-4.5 4.5z'/><path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z'/></svg></span>
    </button>
  </div>
</div>
        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="button" class="btn btn-outline-secondary" @click="close">Annuler</button>
          <button type="submit" class="btn btn-success" :disabled="loading">
  <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
  {{ props.ville ? 'Mettre à jour' : 'Ajouter' }}
</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive } from 'vue'
import { useVillesStore } from '../../stores/useVillesStore'

import { watch } from 'vue'
const props = defineProps({ visible: Boolean, ville: Object })
const emit = defineEmits(['close', 'added'])
const form = reactive({ nom: '', region: '', code_postal: '' })
const errors = reactive({ nom: '' })
const loading = ref(false)
const store = useVillesStore()
const showCodePostal = ref(false)

watch(
  () => [props.visible, props.ville],
  ([visible, ville]) => {
    if (visible) {
      if (ville) {
        form.nom = ville.nom || ''
        form.region = ville.region || ''
        form.code_postal = ville.code_postal || ''
      } else {
        form.nom = ''
        form.region = ''
        form.code_postal = ''
      }
      errors.nom = ''
      showCodePostal.value = false
    }
  },
  { immediate: true }
)

function reset() {
  form.nom = ''
  form.region = ''
  form.code_postal = ''
  errors.nom = ''
}

function close() {
  reset()
  emit('close')
}

async function submit() {
  errors.nom = form.nom ? '' : 'Le nom est requis.'
  if (!form.nom) return
  loading.value = true
  try {
    if (props.ville && props.ville.id) {
      await store.updateVille(props.ville.id, { nom: form.nom, region: form.region, code_postal: form.code_postal })
    } else {
      await store.addVille({ nom: form.nom, region: form.region, code_postal: form.code_postal })
    }
    emit('added')
    close()
  } catch (e) {
    errors.nom = e?.response?.data?.errors?.nom?.[0] || `Erreur lors de l'${props.ville ? 'édition' : 'ajout'}.`
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
  z-index: 1050;
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
  margin: 0 auto;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  animation: slideIn 0.3s;
  position: relative;
  text-align: left;
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