<template>
  <div class="form-page-bg">
    <div class="form-card">
      <h2 class="mb-2"><i class="fas fa-home me-2"></i>{{ isEdit ? 'Modifier le bien' : 'Ajouter un bien' }}</h2>
      <p class="text-muted mb-4">Remplissez les informations du bien immobilier.</p>
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
          <button type="button" class="btn btn-outline-secondary btn-lg" @click="annuler">Annuler</button>
          <button type="submit" class="btn btn-success btn-lg" :disabled="chargement">
            <span v-if="chargement" class="spinner-border spinner-border-sm me-2"></span>
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '../../utils/api'
import { biensApi } from '../../utils/apiResources'

const router = useRouter()
const route = useRoute()
const isEdit = computed(() => !!route.params.id)
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

async function chargerBien() {
  if (isEdit.value) {
    chargement.value = true
    try {
      const res = await biensApi.get(route.params.id)
      const val = res.data
      Object.assign(form, {
        titre: val.titre || '', description: val.description || '', prix: val.prix || '',
        surface: val.surface || '', adresse: val.adresse || '', statut: val.statut || '',
        ville_id: val.ville_id || val.ville?.id || '',
        type_bien_id: val.type_bien_id || val.type_bien?.id || '',
        proprietaire_id: val.proprietaire_id || val.proprietaire?.id || '',
        image: val.image || '', imagePreview: val.image || ''
      })
    } catch (e) {
      alert("Erreur lors du chargement du bien")
    } finally {
      chargement.value = false
    }
  }
}

onMounted(() => {
  chargerOptions()
  chargerBien()
})

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

async function enregistrerBien() {
  if (!valider()) return
  chargement.value = true
  try {
    const bienData = { ...form }
    if (isEdit.value) {
      await biensApi.update(route.params.id, bienData)
    } else {
      await biensApi.create(bienData)
    }
    router.push({ name: 'BiensDash' })
  } catch (e) {
    alert("Erreur lors de l'enregistrement")
  } finally {
    chargement.value = false
  }
}

function annuler() {
  router.push({ name: 'BiensDash' })
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
.form-page-bg {
  min-height: 100vh;
  background: linear-gradient(120deg, #f8fafc 60%, #e3e9f7 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}
.form-card {
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
</style> 