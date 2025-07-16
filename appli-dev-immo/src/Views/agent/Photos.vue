<script setup>
import { ref, onMounted } from 'vue'
import { photosApi, biensApi } from '../../utils/apiResources'

const loading = ref(false)
const error = ref('')
const biens = ref([])
const lightboxUrl = ref('')
const lightboxVisible = ref(false)

onMounted(async () => {
  loading.value = true
  try {
    const res = await biensApi.list()
    biens.value = res.data
  } catch (err) {
    error.value = err.response?.data?.message || "Erreur lors du chargement des biens"
  } finally {
    loading.value = false
  }
})

function ouvrirLightbox(url) {
  lightboxUrl.value = url
  lightboxVisible.value = true
}
function fermerLightbox() {
  lightboxVisible.value = false
}

const ajouterPhoto = async (formData) => {
  loading.value = true
  try {
    await photosApi.add(formData)
    // Rafraîchir la liste des photos si besoin
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de l\'ajout de la photo'
  } finally {
    loading.value = false
  }
}

const supprimerPhoto = async (id) => {
  loading.value = true
  try {
    await photosApi.remove(id)
    // Rafraîchir la liste des photos si besoin
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de la suppression de la photo'
  } finally {
    loading.value = false
  }
}

function supprimerPhotoEtRetirer(bien, photo, idx) {
  if (confirm('Voulez-vous vraiment supprimer cette photo ?')) {
    supprimerPhoto(photo.id).then(() => {
      bien.photos.splice(idx, 1)
    })
  }
}
</script>

<template>
  <div>
    <h1>Galerie des photos des biens</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
    <div v-else>
      <div v-if="!biens.length" class="text-muted">Aucun bien trouvé.</div>
      <div v-else class="row g-4">
        <div v-for="bien in biens" :key="bien.id" class="col-12 mb-4">
          <h5 class="mb-2">{{ bien.titre }}</h5>
          <div class="galerie-horizontale">
            <div v-for="(photo, idx) in bien.photos" :key="photo.id || idx" class="photo-wrapper">
              <img :src="photo.url" alt="Photo du bien" class="photo-bien" @click="ouvrirLightbox(photo.url)" />
              <button class="btn btn-sm btn-danger btn-supprimer" @click="supprimerPhotoEtRetirer(bien, photo, idx)"><i class="fas fa-trash"></i></button>
            </div>
            <span v-if="!bien.photos || !bien.photos.length" class="text-muted">Aucune photo</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
h1 { font-size: 1.5rem; margin-bottom: 1.5rem; }
.galerie-horizontale {
  display: flex !important;
  flex-direction: row !important;
  align-items: center;
  gap: 16px;
  overflow-x: auto;
  padding-bottom: 8px;
  scrollbar-width: thin;
  width: 100%;
  min-height: 130px;
}
.photo-wrapper {
  position: relative;
  flex: 0 0 auto;
}
.photo-bien {
  width: 150px;
  height: 120px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 2px 8px #0001;
  cursor: pointer;
  transition: box-shadow 0.2s;
}
.photo-bien:hover {
  box-shadow: 0 4px 16px #0002;
}
.btn-supprimer {
  position: absolute;
  top: 6px;
  right: 6px;
  z-index: 2;
  padding: 2px 7px;
  font-size: 1rem;
  border-radius: 50%;
}
.lightbox-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.75);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
.lightbox-img {
  max-width: 90vw;
  max-height: 80vh;
  border-radius: 10px;
  box-shadow: 0 4px 32px #0008;
}
</style>