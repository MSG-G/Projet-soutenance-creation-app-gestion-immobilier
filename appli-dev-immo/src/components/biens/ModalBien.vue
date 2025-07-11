<template>
  <transition name="modal-fade">
    <div v-if="visible" class="modal-backdrop" @click.self="fermer">
      <div class="modal-content animate-pop">
        <h4 class="mb-3 fw-bold text-center text-primary">
          {{ bien && bien.id ? 'Modifier le bien' : 'Ajouter un bien' }}
        </h4>
        <form @submit.prevent="enregistrerBien" novalidate>
          <div class="mb-3">
            <label class="form-label">Nom du bien <span class="text-danger">*</span></label>
            <input v-model="form.nom" type="text" class="form-control" :class="{'is-invalid': erreurs.nom}" required />
            <div v-if="erreurs.nom" class="invalid-feedback">{{ erreurs.nom }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Lieu <span class="text-danger">*</span></label>
            <input v-model="form.lieu" type="text" class="form-control" :class="{'is-invalid': erreurs.lieu}" required />
            <div v-if="erreurs.lieu" class="invalid-feedback">{{ erreurs.lieu }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Type <span class="text-danger">*</span></label>
            <select v-model="form.type" class="form-select" :class="{'is-invalid': erreurs.type}" required>
              <option value="">-- Sélectionner --</option>
              <option>Appartement</option>
              <option>Villa</option>
              <option>Maison</option>
              <option>Terrain</option>
            </select>
            <div v-if="erreurs.type" class="invalid-feedback">{{ erreurs.type }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
            <input v-model.number="form.prix" type="number" min="0" class="form-control" :class="{'is-invalid': erreurs.prix}" required />
            <div v-if="erreurs.prix" class="invalid-feedback">{{ erreurs.prix }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Statut <span class="text-danger">*</span></label>
            <select v-model="form.statut" class="form-select" :class="{'is-invalid': erreurs.statut}" required>
              <option value="">-- Sélectionner --</option>
              <option>Disponible</option>
              <option>Vendu</option>
              <option>Loué</option>
              <option>Réservé</option>
            </select>
            <div v-if="erreurs.statut" class="invalid-feedback">{{ erreurs.statut }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" @change="onFileChange" accept="image/*" class="form-control" />
            <div v-if="form.imagePreview" class="mt-3 text-center">
              <img :src="form.imagePreview" alt="Aperçu" class="img-thumbnail img-preview" />
            </div>
          </div>

          <div class="d-flex gap-3 justify-content-end mt-4">
            <button type="button" class="btn btn-outline-secondary" @click="fermer">Annuler</button>
            <button type="submit" class="btn btn-success">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { reactive, watch } from 'vue'
const props = defineProps({
  visible: Boolean,
  bien: Object
})
const emit = defineEmits(['fermer', 'enregistrer'])

const form = reactive({
  nom: '',
  lieu: '',
  type: '',
  prix: '',
  statut: '',
  image: '',
  imagePreview: ''
})
const erreurs = reactive({ nom: '', lieu: '', type: '', prix: '', statut: '' })

watch(() => props.bien, (val) => {
  if (val) {
    form.nom = val.nom || ''
    form.lieu = val.lieu || ''
    form.type = val.type || ''
    form.prix = val.prix || ''
    form.statut = val.statut || ''
    form.image = val.image || ''
    form.imagePreview = val.image || ''
  } else {
    form.nom = ''
    form.lieu = ''
    form.type = ''
    form.prix = ''
    form.statut = ''
    form.image = ''
    form.imagePreview = ''
  }
}, { immediate: true })

function valider() {
  erreurs.nom = form.nom ? '' : 'Le nom est requis.'
  erreurs.lieu = form.lieu ? '' : 'Le lieu est requis.'
  erreurs.type = form.type ? '' : 'Le type est requis.'
  erreurs.prix = form.prix && form.prix > 0 ? '' : 'Le prix doit être positif.'
  erreurs.statut = form.statut ? '' : 'Le statut est requis.'
  return !erreurs.nom && !erreurs.lieu && !erreurs.type && !erreurs.prix && !erreurs.statut
}

function enregistrerBien() {
  if (!valider()) return
  const bienData = { ...form }
  if (props.bien && props.bien.id) bienData.id = props.bien.id
  emit('enregistrer', bienData)
}

function fermer() {
  emit('fermer')
}

function onFileChange(e) {
  const file = e.target.files[0]
  if (file && file.type.startsWith('image/')) {
    form.image = file
    form.imagePreview = URL.createObjectURL(file)
  }
}
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
}
.modal-content {
  background: white;
  border-radius: 14px;
  padding: 2rem;
  width: 100%;
  max-width: 620px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}
.modal-content:hover {
  transform: scale(1.01);
}
.img-preview {
  max-width: 120px;
  max-height: 80px;
  border-radius: 6px;
  object-fit: cover;
}
.invalid-feedback {
  color: #e74c3c;
  font-size: 0.9em;
  margin-top: 0.2em;
}
.is-invalid {
  border-color: #e74c3c !important;
}
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.3s;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
</style>
