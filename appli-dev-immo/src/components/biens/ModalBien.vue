<template>
  <transition name="modal-fade">
    <div v-if="visible" class="modal-backdrop" @click.self="fermer">
      <div class="modal-content animate-slide">
        <h4 class="mb-4 text-center fw-bold text-primary">
          {{ bien && bien.id ? 'Modifier le bien' : 'Ajouter un bien' }}
        </h4>

        <form @submit.prevent="enregistrerBien" class="modal-form" novalidate>
  <div v-if="alerteErreur" class="alert alert-danger">{{ alerteErreur }}</div>
          <div v-if="bienCree && bienCree.id && !photoAjoutee" class="alert alert-info mt-2">
            Bien créé ! Vous pouvez maintenant ajouter une photo.
            <input type="file" @change="onAjoutPhoto" accept="image/*" class="form-control mt-2" />
            <button class="btn btn-primary mt-2" @click.prevent="envoyerPhoto">Ajouter la photo</button>
            <div v-if="photoErreur" class="text-danger mt-1">{{ photoErreur }}</div>
          </div>
          <div v-if="bienCree && bienCree.id && photoAjoutee" class="alert alert-success mt-2">
            Photo ajoutée !
            <button class="btn btn-link p-0 ms-2" @click="photoAjoutee = false">Ajouter une autre photo</button>
            <button class="btn btn-secondary ms-3" @click="fermer">Fermer</button>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Titre <span class="text-danger">*</span></label>
              <input v-model="form.titre" type="text" class="form-control" :class="{ 'is-invalid': erreurs.titre }" />
              <div v-if="erreurs.titre" class="invalid-feedback">{{ erreurs.titre }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
              <input v-model.number="form.prix" type="number" class="form-control" :class="{ 'is-invalid': erreurs.prix }" />
              <div v-if="erreurs.prix" class="invalid-feedback">{{ erreurs.prix }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Surface (m²) <span class="text-danger">*</span></label>
              <input v-model.number="form.surface" type="number" class="form-control" :class="{ 'is-invalid': erreurs.surface }" />
              <div v-if="erreurs.surface" class="invalid-feedback">{{ erreurs.surface }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Adresse <span class="text-danger">*</span></label>
              <input v-model="form.adresse" type="text" class="form-control" :class="{ 'is-invalid': erreurs.adresse }" />
              <div v-if="erreurs.adresse" class="invalid-feedback">{{ erreurs.adresse }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Statut <span class="text-danger">*</span></label>
              <select v-model="form.statut" class="form-select" :class="{ 'is-invalid': erreurs.statut }">
                <option value="">-- Sélectionner --</option>
                <option value="disponible">Disponible</option>
                <option value="vendu">Vendu</option>
                <option value="loue">Loué</option>
                <option value="reserve">Réservé</option>
              </select>
              <div v-if="erreurs.statut" class="invalid-feedback">{{ erreurs.statut }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Ville <span class="text-danger">*</span></label>
              <div class="input-group">
                <select v-model="form.ville_id" class="form-select" :class="{ 'is-invalid': erreurs.ville_id }">
                  <option value="">-- Sélectionner --</option>
                  <option v-for="ville in villesStore.villes" :key="ville.id" :value="ville.id">{{ ville.nom }}</option>
                </select>
                <button type="button" class="btn btn-outline-primary" @click="showVilleModal = true" title="Ajouter une ville"><i class="fas fa-plus"></i></button>
              </div>
              <div v-if="erreurs.ville_id" class="invalid-feedback">{{ erreurs.ville_id }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Type de bien <span class="text-danger">*</span></label>
              <div class="input-group">
                <select v-model="form.type_bien_id" class="form-select" :class="{ 'is-invalid': erreurs.type_bien_id }">
                  <option value="">-- Sélectionner --</option>
                  <option v-for="type in typesBienStore.typesBien" :key="type.id" :value="type.id">{{ type.nom }}</option>
                </select>
                <button type="button" class="btn btn-outline-primary" @click="showTypeBienModal = true" title="Ajouter un type de bien"><i class="fas fa-plus"></i></button>
              </div>
              <div v-if="erreurs.type_bien_id" class="invalid-feedback">{{ erreurs.type_bien_id }}</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Propriétaire <span class="text-danger">*</span></label>
              <select v-model="form.proprietaire_id" class="form-select" :class="{ 'is-invalid': erreurs.proprietaire_id }">
                <option value="">-- Sélectionner --</option>
                <option v-for="proprio in proprietaires" :key="proprio.id" :value="proprio.id">
                  {{ proprio.nom }} {{ proprio.prenom }}
                </option>
              </select>
              <div v-if="erreurs.proprietaire_id" class="invalid-feedback">{{ erreurs.proprietaire_id }}</div>
            </div>

            <div class="col-12">
              <label class="form-label">Description <span class="text-danger">*</span></label>
              <textarea v-model="form.description" rows="3" class="form-control" :class="{ 'is-invalid': erreurs.description }"></textarea>
              <div v-if="erreurs.description" class="invalid-feedback">{{ erreurs.description }}</div>
            </div>

            <div class="col-12">
              <label class="form-label">Image</label>
              <input type="file" @change="onFileChange" accept="image/*" class="form-control" />
              <div v-if="form.imagePreview" class="mt-3 text-center">
                <img :src="form.imagePreview" alt="Aperçu" class="img-thumbnail img-preview" />
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn btn-outline-secondary" @click="fermer">Annuler</button>
            <button type="submit" class="btn btn-success">Enregistrer</button>
          </div>
        </form>
        <ModalTypeBien :visible="showTypeBienModal" @close="showTypeBienModal = false" @added="afterTypeBienAdded" />
        <ModalVille :visible="showVilleModal" @close="showVilleModal = false" @added="afterVilleAdded" />
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive, watch, onMounted } from 'vue'
import api from '../../utils/api'
import { photosApi } from '../../utils/apiResources'

const props = defineProps({ visible: Boolean, bien: Object, bienCree: Object })
const emit = defineEmits(['fermer', 'enregistrer'])

const bienCree = ref(props.bienCree || null)
const photoFichier = ref(null)
const photoAjoutee = ref(false)
const photoErreur = ref('')

// Watch for prop bienCree changes from parent
watch(() => props.bienCree, (val) => {
  bienCree.value = val
  // Reset photo upload state if bienCree changes
  photoFichier.value = null
  photoAjoutee.value = false
  photoErreur.value = ''
})

function onAjoutPhoto(e) {
  photoFichier.value = e.target.files[0] || null
  photoErreur.value = ''
}

async function envoyerPhoto() {
  if (!photoFichier.value) {
    photoErreur.value = "Veuillez sélectionner une image."
    return
  }
  try {
    const formData = new FormData()
    formData.append('image', photoFichier.value)
    formData.append('bien_id', bienCree.value.id)
    await photosApi.add(formData)
    photoAjoutee.value = true
    photoErreur.value = ''
  } catch (err) {
    photoErreur.value = "Erreur lors de l'upload de la photo."
  }
}

import ModalTypeBien from './ModalTypeBien.vue'
import ModalVille from './ModalVille.vue'
import { useTypesBienStore } from '../../stores/useTypesBienStore'
import { useVillesStore } from '../../stores/useVillesStore'

const form = reactive({
  titre: '', description: '', prix: '', surface: '',
  adresse: '', statut: '', ville_id: '', type_bien_id: '',
  proprietaire_id: '', image: '', imagePreview: ''
})

const erreurs = reactive({})
const proprietaires = ref([])

const showTypeBienModal = ref(false)
const showVilleModal = ref(false)
const typesBienStore = useTypesBienStore()
const villesStore = useVillesStore()

async function chargerOptions() {
  await Promise.all([
    typesBienStore.fetchTypesBien(),
    villesStore.fetchVilles(),
    api.get('/proprietaires').then(res => proprietaires.value = res.data)
  ])
}

onMounted(chargerOptions)

watch(() => props.bien, (val) => {
  Object.assign(form, {
    titre: val?.titre || '',
    description: val?.description || '',
    prix: val?.prix || '',
    surface: val?.surface || '',
    adresse: val?.adresse || '',
    statut: val?.statut || '',
    ville_id: val?.ville_id || val?.ville?.id || '',
    type_bien_id: val?.type_bien_id || val?.type_bien?.id || '',
    proprietaire_id: val?.proprietaire_id || val?.proprietaire?.id || '',
    image: val?.image || '',
    imagePreview: val?.image || ''
  })
}, { immediate: true })

function valider() {
  erreurs.titre = form.titre ? '' : 'Le titre est requis.'
  erreurs.description = form.description ? '' : 'La description est requise.'
  erreurs.prix = form.prix > 0 ? '' : 'Le prix doit être positif.'
  erreurs.surface = form.surface > 0 ? '' : 'La surface doit être positive.'
  erreurs.adresse = form.adresse ? '' : "L'adresse est requise."
  erreurs.statut = form.statut ? '' : 'Le statut est requis.'
  erreurs.ville_id = form.ville_id ? '' : 'La ville est requise.'
  erreurs.type_bien_id = form.type_bien_id ? '' : 'Le type est requis.'
  erreurs.proprietaire_id = form.proprietaire_id ? '' : 'Le propriétaire est requis.'
  return Object.values(erreurs).every(e => !e)
}

const alerteErreur = ref('')

async function enregistrerBien() {
  alerteErreur.value = ''
  if (!valider()) {
    alerteErreur.value = 'Veuillez corriger les champs en rouge pour continuer.'
    return
  }
  // Annulation FormData : on envoie un objet JS classique
  const bienData = { ...form };
  if (props.bien?.id) bienData.id = props.bien.id;
  emit('enregistrer', bienData);
}

function fermer() {
  emit('fermer')
}

function onFileChange(e) {
  const file = e.target.files[0]
  if (file?.type?.startsWith('image/')) {
    form.image = file
    form.imagePreview = URL.createObjectURL(file)
  }
}

function afterTypeBienAdded() {
  typesBienStore.fetchTypesBien()
}
function afterVilleAdded() {
  villesStore.fetchVilles()
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
  overflow-y: auto;
  padding: 2rem;
}

.modal-content {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  width: 100%;
  max-width: 720px;
  max-height: 95vh;
  overflow-y: auto;
  animation: fadeIn 0.4s ease, slideIn 0.4s ease;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}
.modal-content:hover {
  transform: scale(1.01);
}

.img-preview {
  max-width: 140px;
  max-height: 100px;
  border-radius: 8px;
  object-fit: cover;
}

.is-invalid {
  border-color: #e74c3c !important;
}

.invalid-feedback {
  color: #e74c3c;
  font-size: 0.85rem;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

@keyframes slideIn {
  from {
    transform: translateY(-40px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
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

