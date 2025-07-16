<template>
  <transition name="modal-fade">
    <div v-if="visible" class="modal-backdrop" @click.self="fermer">
      <div class="modal-content form-modal animate-pop">
        <h2 class="mb-2 text-center"><i class="fas fa-home me-2"></i>{{ isEdit ? 'Modifier le bien' : 'Ajouter un bien' }}</h2>
        <p class="text-muted mb-4 text-center">Remplissez les informations du bien immobilier.</p>
        <form @submit.prevent="enregistrerBien" novalidate>
          <div class="mb-3">
            <label class="form-label">Titre <span class="text-danger">*</span></label>
            <input v-model="form.titre" type="text" class="form-control" :class="{'is-invalid': erreurs.titre}" required autofocus />
            <div v-if="erreurs.titre" class="invalid-feedback">{{ erreurs.titre }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea v-model="form.description" class="form-control" :class="{'is-invalid': erreurs.description}" required></textarea>
            <div v-if="erreurs.description" class="invalid-feedback">{{ erreurs.description }}</div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
              <input v-model.number="form.prix" type="number" min="0" class="form-control" :class="{'is-invalid': erreurs.prix}" required />
              <div v-if="erreurs.prix" class="invalid-feedback">{{ erreurs.prix }}</div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Surface (m²) <span class="text-danger">*</span></label>
              <input v-model.number="form.surface" type="number" min="0" class="form-control" :class="{'is-invalid': erreurs.surface}" required />
              <div v-if="erreurs.surface" class="invalid-feedback">{{ erreurs.surface }}</div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Adresse <span class="text-danger">*</span></label>
            <input v-model="form.adresse" type="text" class="form-control" :class="{'is-invalid': erreurs.adresse}" required />
            <div v-if="erreurs.adresse" class="invalid-feedback">{{ erreurs.adresse }}</div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut <span class="text-danger">*</span></label>
              <select v-model="form.statut" class="form-select" :class="{'is-invalid': erreurs.statut}" required>
                <option value="">-- Sélectionner --</option>
                <option value="disponible">Disponible</option>
                <option value="vendu">Vendu</option>
                <option value="loue">Loué</option>
                <option value="reserve">Réservé</option>
              </select>
              <div v-if="erreurs.statut" class="invalid-feedback">{{ erreurs.statut }}</div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ville <span class="text-danger">*</span></label>
              <select v-model="form.ville_id" class="form-select" :class="{'is-invalid': erreurs.ville_id}" required>
                <option value="">-- Sélectionner --</option>
                <option v-for="ville in villes" :key="ville.id" :value="ville.id">{{ ville.nom }}</option>
              </select>
              <div v-if="erreurs.ville_id" class="invalid-feedback">{{ erreurs.ville_id }}</div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Type de bien <span class="text-danger">*</span></label>
            <select v-model="form.type_bien_id" class="form-select" :class="{'is-invalid': erreurs.type_bien_id}" required>
              <option value="">-- Sélectionner --</option>
              <option v-for="type in typesBien" :key="type.id" :value="type.id">{{ type.nom }}</option>
            </select>
            <div v-if="erreurs.type_bien_id" class="invalid-feedback">{{ erreurs.type_bien_id }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Propriétaire <span class="text-danger">*</span></label>
            <select v-model="form.proprietaire_id" class="form-select" :class="{'is-invalid': erreurs.proprietaire_id}" required>
              <option value="">-- Sélectionner --</option>
              <option v-for="proprio in proprietaires" :key="proprio.id" :value="proprio.id">{{ proprio.nom }} {{ proprio.prenom }}</option>
            </select>
            <div v-if="erreurs.proprietaire_id" class="invalid-feedback">{{ erreurs.proprietaire_id }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" @change="onFileChange" accept="image/*" class="form-control" />
            <div v-if="form.imagePreview" class="mt-3 text-center">
              <img :src="form.imagePreview" alt="Aperçu" class="img-thumbnail img-preview" />
            </div>
          </div>
          <div class="d-flex gap-3 justify-content-end mt-4">
            <button type="button" class="btn btn-outline-secondary btn-lg" @click="fermer">Annuler</button>
            <button type="submit" class="btn btn-success btn-lg" :disabled="chargement">
              <span v-if="chargement" class="spinner-border spinner-border-sm me-2"></span>
              Enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { reactive, watch, ref, onMounted, computed } from 'vue'
import api from '../../utils/api'

const props = defineProps({
  visible: Boolean,
  bien: Object
})
const emit = defineEmits(['fermer', 'enregistrer'])
const isEdit = computed(() => !!props.bien && !!props.bien.id)
const chargement = ref(false)
const form = reactive({
  titre: '', description: '', prix: '', surface: '', adresse: '', statut: '',
  ville_id: '', type_bien_id: '', proprietaire_id: '', image: '', imagePreview: ''
})
const erreurs = reactive({ titre: '', description: '', prix: '', surface: '', adresse: '', statut: '', ville_id: '', type_bien_id: '', proprietaire_id: '' })
const villes = ref([])
const typesBien = ref([])
const proprietaires = ref([])

async function chargerOptions() {
  const [villesRes, typesRes, proprietairesRes] = await Promise.all([
    api.get('/villes'), api.get('/types-bien'), api.get('/proprietaires')
  ])
  villes.value = villesRes.data
  typesBien.value = typesRes.data
  proprietaires.value = proprietairesRes.data
}

onMounted(() => {
  chargerOptions()
})

watch(() => props.bien, (val) => {
  if (val) {
    Object.assign(form, {
      titre: val.titre || '', description: val.description || '', prix: val.prix || '',
      surface: val.surface || '', adresse: val.adresse || '', statut: val.statut || '',
      ville_id: val.ville_id || val.ville?.id || '',
      type_bien_id: val.type_bien_id || val.type_bien?.id || '',
      proprietaire_id: val.proprietaire_id || val.proprietaire?.id || '',
      image: val.image || '', imagePreview: val.image || ''
    })
  } else {
    Object.keys(form).forEach(k => form[k] = '')
  }
}, { immediate: true })

function valider() {
  erreurs.titre = form.titre ? '' : 'Le titre est requis.'
  erreurs.description = form.description ? '' : 'La description est requise.'
  erreurs.prix = form.prix > 0 ? '' : 'Le prix doit être positif.'
  erreurs.surface = form.surface > 0 ? '' : 'La surface doit être positive.'
  erreurs.adresse = form.adresse ? '' : "L'adresse est requise."
  erreurs.statut = form.statut ? '' : 'Le statut est requis.'
  erreurs.ville_id = form.ville_id ? '' : 'La ville est requise.'
  erreurs.type_bien_id = form.type_bien_id ? '' : 'Le type de bien est requis.'
  erreurs.proprietaire_id = form.proprietaire_id ? '' : 'Le propriétaire est requis.'
  return Object.values(erreurs).every(e => !e)
}

function enregistrerBien() {
  if (!valider()) return
  chargement.value = true
  const bienData = { ...form }
  if (props.bien && props.bien.id) bienData.id = props.bien.id
  emit('enregistrer', bienData)
  chargement.value = false
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
  backdrop-filter: blur(2px);
}
.form-modal {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 40px rgba(0,0,0,0.13);
  padding: 2.5rem 2rem;
  width: 100%;
  max-width: 600px;
  overflow-y: auto;
  max-height: 90vh;
  animation: slideInUp 0.5s cubic-bezier(.4,2,.6,1) both;
  scrollbar-width: thin;
  scrollbar-color: #ccc transparent;
}
.img-preview {
  max-width: 120px;
  max-height: 80px;
  border-radius: 6px;
  object-fit: cover;
}
button {
  transition: all 0.3s ease-in-out;
}
button:hover {
  transform: scale(1.03);
}
.invalid-feedback {
  color: #e74c3c;
  font-size: 0.9em;
  margin-top: 0.2em;
}
.is-invalid {
  border-color: #e74c3c !important;
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