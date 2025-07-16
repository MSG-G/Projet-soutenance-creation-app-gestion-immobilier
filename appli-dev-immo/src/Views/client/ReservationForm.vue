<template>
    <HeaderDash />
  <div>
    <h1>Réserver une visite</h1>
    <div v-if="bienSelectionne">
      <div class="card p-3 mb-3">
        <h5>{{ bienSelectionne.titre }}</h5>
        <p class="mb-1"><strong>Adresse :</strong> {{ bienSelectionne.adresse }}</p>
        <p class="mb-1"><strong>Prix :</strong> {{ bienSelectionne.prix ? Number(bienSelectionne.prix).toLocaleString() : '' }} FCFA</p>
        <p class="mb-1"><strong>Ville :</strong> {{ bienSelectionne.ville?.nom }}</p>
        <p class="mb-1"><strong>Type :</strong> {{ bienSelectionne.type_bien?.nom }}</p>
        <p class="mb-1"><strong>Description :</strong> {{ bienSelectionne.description }}</p>
      </div>
    </div>
    <form @submit.prevent="submitReservation">
      <div v-if="!bienSelectionne">
        <label for="bien">Bien :</label>
        <select v-model="bienId" required>
          <option value="">-- Sélectionner un bien --</option>
          <option v-for="bien in biens" :value="bien.id" :key="bien.id">{{ bien.titre }}</option>
        </select>
      </div>
      <div>
        <label for="date">Date de visite :</label>
        <input type="date" v-model="date" required />
      </div>
      <div>
        <label for="prix">Prix :</label>
        <input type="text" v-model="prix" readonly />
      </div>
      <button type="submit" :disabled="loading">Réserver</button>
    </form>
    <div v-if="success" class="alert alert-success mt-3">
  Réservation enregistrée avec succès !<br>
  Vous allez être redirigé vers vos réservations...
</div>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/utils/api'

const biens = ref([])
const bienId = ref('')
const bienSelectionne = ref(null)
const date = ref('')
const prix = ref('')
const loading = ref(false)
const error = ref('')
const success = ref(false)

const route = useRoute()

onMounted(async () => {
  try {
    const res = await api.get('/biens')
    biens.value = res.data
    // Pré-remplissage si bienId fourni en query ou props
    const id = route.query.bienId || route.params.bienId || ''
    if (id) {
      bienId.value = id
      bienSelectionne.value = biens.value.find(b => b.id == id)
      if (!bienSelectionne.value) {
        // Si le bien n'est pas dans la liste, on le charge directement
        try {
          const r = await api.get(`/biens/${id}`)
          bienSelectionne.value = r.data
        } catch (e) {
          error.value = "Impossible de charger le bien sélectionné.";
        }
      }
      prix.value = bienSelectionne.value?.prix || ''
    }
  } catch (e) {
    error.value = 'Impossible de charger les biens.'
  }
})

watch(bienId, (newId) => {
  bienSelectionne.value = biens.value.find(b => b.id == newId) || null
  prix.value = bienSelectionne.value?.prix || ''
})

const submitReservation = async () => {
  loading.value = true
  error.value = ''
  success.value = false
  try {
    await api.post('/reservations', {
      bien_id: bienSelectionne.value?.id || bienId.value,
      date: date.value
    })
    success.value = true
    if (!route.query.bienId && !route.params.bienId) {
      bienId.value = ''
      bienSelectionne.value = null
    }
    date.value = ''
    prix.value = ''
    setTimeout(() => {
      router.push({ name: 'ReservationsClient' })
    }, 2000)
  } catch (e) {
    error.value = 'Erreur lors de la réservation.'
  } finally {
    loading.value = false
  }
}
import HeaderDash from '@/components/HeaderDash.vue';
</script>

<style scoped>
.success { color: green; margin-top: 1rem; }
.error { color: red; margin-top: 1rem; }
form > div { margin-bottom: 1rem; }
.card { background: #f8f9fa; }
</style>

