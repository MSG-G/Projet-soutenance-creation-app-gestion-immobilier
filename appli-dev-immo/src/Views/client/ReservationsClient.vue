<template>
    <HeaderDash />
  <div class="reservations-page py-4">
    <h2 class="mb-4 title-gradient">Mes réservations</h2>
    <div v-if="loading" class="text-center">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
      </div>
    </div>
    <div v-else>
      <div class="mb-3 text-center">
        <span class="badge bg-primary me-2">Total : {{ reservations.length }}</span>
        <span class="badge bg-warning me-2">En attente : {{ reservations.filter(r => r.statut === 'En attente').length }}</span>
        <span class="badge bg-success me-2">Validées : {{ reservations.filter(r => r.statut === 'Validée').length }}</span>
        <span class="badge bg-danger me-2">Annulées : {{ reservations.filter(r => r.statut === 'Annulée').length }}</span>
        <span class="badge bg-secondary me-2">Passées : {{ reservations.filter(r => r.statut === 'Passée').length }}</span>
      </div>
      <div v-if="reservations.length" class="row g-4">
        <div v-for="resa in reservations" :key="resa.id" class="col-12 col-md-6 col-lg-4">
          <div class="resa-card card h-100 shadow-lg animate__animated animate__fadeInUp">
            <!-- Image du bien -->
            <div class="resa-img-wrapper position-relative">
              <img :src="resa.bien?.photos?.[0]?.url || '/img/placeholder-bien.jpg'"
                   class="resa-img-top" :alt="resa.bien?.titre || 'Photo bien'" />
              <span :class="['resa-status-badge', badgeStatut(resa.statut)]">
                <i v-if="resa.statut === 'En attente'" class="fa fa-hourglass-half me-1"></i>
                <i v-else-if="resa.statut === 'Validée'" class="fa fa-check-circle me-1"></i>
                <i v-else-if="resa.statut === 'Annulée'" class="fa fa-times-circle me-1"></i>
                <i v-else-if="resa.statut === 'Passée'" class="fa fa-history me-1"></i>
                {{ resa.statut }}
              </span>
            </div>
            <!-- Contenu -->
            <div class="resa-header mb-2">
              
              <div class="flex-grow-1">
                <h5 class="mb-1 resa-title">{{ resa.bien?.titre || resa.bien?.nom }}</h5>
                <div class="mb-1 text-secondary"><i class="fa fa-home"></i> {{ resa.bien?.type }}</div>
              </div>
              <span class="ms-auto text-muted small">{{ formatDate(resa.date) }}</span>
            </div>
            <div class="resa-body">
              <p class="resa-desc">{{ truncate(resa.bien?.description, 80) }}</p>
              <ul class="resa-infos list-unstyled mb-2">
                <li><i class="fa fa-map-marker-alt text-success"></i> <strong>Adresse :</strong> {{ resa.bien?.adresse }}, {{ resa.bien?.ville }}</li>
                <li><i class="fa fa-euro-sign text-warning"></i> <strong>Prix :</strong> {{ formatPrix(resa.bien?.prix) }} FCFA</li>
              </ul>
            </div>
            <div class="d-flex justify-content-between gap-2 mt-auto">
              <router-link :to="`/client/biens/${resa.bien?.id}`" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-search"></i> Voir le bien
              </router-link>
              <button v-if="resa.statut === 'En attente' || resa.statut === 'Validée'"
                @click="annulerReservation(resa)"
                class="btn btn-danger btn-sm resa-btn-anim"
                :aria-label="`Annuler la réservation pour ${resa.bien?.titre}`">
                <i class="fa fa-times"></i> Annuler
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="no-reservation text-center animate__animated animate__fadeIn">
        <img src="/img/empty-reservation.svg" alt="Aucune réservation" style="max-width:180px;opacity:.8;" class="mb-3" />
        <div class="alert alert-info">
          Vous n'avez encore effectué aucune réservation.<br>
          <router-link to="/client/biens" class="btn btn-gradient mt-2">Voir les biens disponibles</router-link>
        </div>
      </div>
    </div>
    <div v-if="error" class="alert alert-danger mt-3 animate__animated animate__shakeX">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/utils/api'

const reservations = ref([])

function translateStatus(apiStatus) {
  const map = {
    pending: 'En attente',
    planifiee: 'En attente',
    confirmed: 'Validée',
    confirmee: 'Validée',
    refused: 'Annulée',
    annulee: 'Annulée',
    passed: 'Passée'
  }
  return map[apiStatus] || 'En attente'
}
const loading = ref(true)
const error = ref('')

const fetchReservations = async () => {
  loading.value = true
  error.value = ''
  try {
    let res
    try {
      res = await api.get('/client/reservations')
    } catch (err) {
      // Si la route spécifique client n'existe pas, on tente la route générique
      if (err.response?.status === 404) {
        console.warn("/client/reservations introuvable, tentative sur /reservations")
        res = await api.get('/reservations')
      } else {
        throw err
      }
    }
    console.log('Réponse API réservations:', res.data)
    reservations.value = res.data.map(r => {
      // Certaines API renvoient le statut en anglais ou sous la clé `status`
      const apiStatut = r.etat || r.statut || r.status
      return {
        ...r,
        statut: translateStatus(apiStatut)
      }
    })
  } catch (e) {
    if (e.response?.status === 403) {
      error.value = "Vous n'êtes pas autorisé à accéder à ces réservations.";
    } else {
      error.value = "Erreur lors du chargement de vos réservations.";
    }
  } finally {
    loading.value = false
  }
}

onMounted(fetchReservations)

async function annulerReservation(resa) {
  if (!confirm('Annuler cette réservation ?')) return
  try {
    await api.delete(`/reservations/${resa.id}`)
    await fetchReservations()
  } catch (e) {
    error.value = "Erreur lors de l'annulation."
  }
}

function badgeStatut(statut) {
  return [
    'resa-badge',
    {
      'bg-warning text-dark': statut === 'En attente',
      'bg-success': statut === 'Validée',
      'bg-danger': statut === 'Annulée',
      'bg-secondary': statut === 'Passée',
      'pulse-badge': statut === 'En attente'
    }
  ]
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
}
function formatPrix(prix) {
  return prix ? Number(prix).toLocaleString() : ''
}
function truncate(str, n) {
  return str && str.length > n ? str.slice(0, n) + '…' : str
}
import HeaderDash from '@/components/HeaderDash.vue';
</script>

<style scoped>
/* Les animations sont importées globalement dans main.js : import 'animate.css'; */
.reservations-page {
  min-height: 80vh;
  background: linear-gradient(135deg,#f8f9ff 60%,#e6eaff 100%);
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(60,60,180,0.05);
  padding-bottom: 50px;
}
.title-gradient {
  background: linear-gradient(90deg,#3f51b5,#7c4dff);
  /* -webkit-background-clip: text; */
  -webkit-text-fill-color: transparent;
  font-weight: 700;
  letter-spacing: 1px;
  font-size: 2.1rem;
}
.resa-card {
  border: none;
  border-radius: 16px;
  background: #fff;
  transition: transform .16s cubic-bezier(.4,2,.6,1), box-shadow .2s;
  box-shadow: 0 6px 32px rgba(60,60,180,0.07);
  display: flex;
  flex-direction: column;
  min-height: 320px;
  position: relative;
  overflow: hidden;
}
.resa-card:hover {
  transform: translateY(-3px) scale(1.025);
  box-shadow: 0 10px 32px rgba(76,110,255,0.09);
}
.resa-header {
  border-bottom: 1px solid #f0f0f8;
  padding-bottom: 6px;
}
.resa-img {
  width: 52px;
  height: 52px;
  object-fit: cover;
  border-radius: 10px;
  border: 2px solid #e3e6ff;
  background: #f8f9ff;
  margin-right: 8px;
}
.resa-title {
  font-size: 1.12rem;
  font-weight: 600;
  color: #3f51b5;
  margin-bottom: 0;
}
.resa-body {
  margin: 10px 0 0 0;
  flex: 1 1 auto;
}
.resa-desc {
  font-size: 0.97rem;
  color: #555;
  margin-bottom: 0.5rem;
  min-height: 36px;
}
.resa-infos li {
  font-size: 0.96rem;
  margin-bottom: 0.2rem;
  color: #333;
  display: flex;
  align-items: center;
  gap: 6px;
}
.resa-img-top {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.resa-status-badge {
  position: absolute;
  bottom: 12px;
  left: 12px;
  z-index: 2;
  font-size: 0.85rem;
  padding: 0.35em 0.8em;
  border-radius: 0.6rem;
  box-shadow: 0 2px 6px rgba(60,60,180,0.1);
}

.resa-badge {
  display: inline-block;
  font-weight: 600;
  font-size: 0.98rem;
  padding: 0.4em 0.85em;
  border-radius: 0.7rem;
  margin-top: 2px;
  margin-left: 2px;
  box-shadow: 0 1px 6px rgba(60,60,180,0.07);
  letter-spacing: 0.5px;
  transition: background .18s;
}
.pulse-badge {
  animation: pulse 1.2s infinite cubic-bezier(.4,0,.6,1);
}
@keyframes pulse {
  0% { box-shadow: 0 0 0 0 #ffd60055; }
  70% { box-shadow: 0 0 0 8px #ffd60011; }
  100% { box-shadow: 0 0 0 0 #ffd60011; }
}
.resa-btn-anim {
  transition: background .18s, transform .16s;
}
.resa-btn-anim:hover {
  background: linear-gradient(90deg,#ff1744,#ff8a65);
  color: #fff;
  transform: scale(1.07);
  border: none;
  box-shadow: 0 2px 8px #ff174422;
}
.no-reservation img {
  filter: drop-shadow(0 4px 18px #b3b3ff44);
}
.btn-gradient {
  background: linear-gradient(90deg,#3f51b5,#7c4dff);
  color: #fff;
  border: none;
  font-weight: 600;
  border-radius: 24px;
  padding: 8px 22px;
  box-shadow: 0 2px 10px #7c4dff22;
  transition: background .18s, transform .16s;
}
.btn-gradient:hover {
  background: linear-gradient(90deg,#7c4dff,#3f51b5);
  transform: scale(1.07);
}
@media (max-width: 800px) {
  .resa-card { min-height: 260px; }
  .resa-title { font-size: 1.01rem; }
}
@media (max-width: 600px) {
  .resa-card { min-height: 180px; }
  .resa-header { flex-direction: column; align-items: flex-start; }
  .resa-img { margin-bottom: 8px; }
}
</style>
