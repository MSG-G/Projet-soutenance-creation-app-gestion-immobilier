<template>
  <div class="dashboard container-fluid py-4 animate__animated animate__fadeIn">
    <!-- Message de bienvenue -->
    <div class="welcome-banner text-center mb-5 p-4 shadow-sm rounded">
      <h2 class="title-gradient">👋 Bienvenue sur votre espace client !</h2>
      <p class="text-muted mt-2">Découvrez vos réservations, messages, et biens favoris en un clin d’œil.</p>
    </div>

    <!-- Section Guides -->
    <div class="row g-3 mb-5">
      <div v-for="guide in guides" :key="guide.title" class="col-md-4">
        <div class="card h-100 shadow-sm guide-card animate__animated animate__zoomIn">
          <div class="card-body text-center">
            <component :is="guide.icon" class="guide-icon mb-3" />
            <h5 class="card-title">{{ guide.title }}</h5>
            <p class="card-text text-muted">{{ guide.text }}</p>
            <router-link :to="guide.link" class="btn btn-outline-primary btn-sm">En savoir plus</router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Résumé des métriques -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-4" v-for="metric in metrics" :key="metric.label">
        <div class="card metric-card text-center h-100 shadow-sm animate__animated animate__fadeInUp">
          <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <component :is="metric.icon" class="metric-icon mb-2" />
            <h4 class="mb-0">{{ metric.value }}</h4>
            <small class="text-muted">{{ metric.label }}</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Chargement -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
      </div>
    </div>

    <div v-else>
      <!-- Dernières réservations -->
      <section class="mb-5 animate__animated animate__fadeInLeft">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="section-title mb-0"><i class="fa fa-calendar-check me-2"></i> Mes dernières réservations</h3>
          <router-link to="/client/reservations" class="btn btn-outline-primary btn-sm">Tout voir</router-link>
        </div>

        <div v-if="lastReservations.length" class="list-group">
          <div v-for="resa in lastReservations" :key="resa.id" class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
              <img :src="resa.bien?.photos?.[0]?.url || '/img/placeholder-bien.jpg'" class="thumb-img rounded" alt="photo bien" />
              <div>
                <h6 class="mb-1">{{ resa.bien?.titre || resa.bien?.nom }}</h6>
                <small class="text-muted">{{ formatDate(resa.date_visite || resa.date) }} • {{ translateStatus(resa.etat || resa.status) }}</small>
              </div>
            </div>
            <router-link :to="`/client/biens/${resa.bien?.id}`" class="btn btn-sm btn-link"><i class="fa fa-search"></i></router-link>
          </div>
        </div>
        <div v-else class="alert alert-info">Aucune réservation pour le moment.</div>
      </section>

      <!-- Messages récents -->
      <section class="animate__animated animate__fadeInRight">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="section-title mb-0"><i class="fa fa-envelope me-2"></i> Messages récents</h3>
          <router-link to="/client/messagerie" class="btn btn-outline-primary btn-sm">Ouvrir la messagerie</router-link>
        </div>
        <ul v-if="lastMessages.length" class="list-group">
          <li v-for="msg in lastMessages" :key="msg.id" class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
              <div class="fw-semibold">{{ msg.from }}</div>
              {{ truncate(msg.content, 60) }}
            </div>
            <span class="badge bg-light text-muted small">{{ formatDate(msg.created_at) }}</span>
          </li>
        </ul>
        <div v-else class="alert alert-info">Aucun message.</div>
      </section>
    </div>

    <div v-if="error" class="alert alert-danger mt-3 animate__animated animate__shakeX">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/utils/api'
import { Heart, CalendarCheck, Inbox, HelpCircle, BookmarkCheck, Send } from 'lucide-vue-next'

const favoris = ref([])
const reservations = ref([])
const messages = ref([])
const loading = ref(true)
const error = ref('')

const translateStatus = s => {
  const map = { pending: 'En attente', planifiee: 'En attente', confirmed: 'Validée', confirmee: 'Validée', refused: 'Annulée', annulee: 'Annulée', passed: 'Passée' }
  return map[s] || s
}

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    const [fav, resa, msg] = await Promise.all([
      api.get('/client/favoris'),
      api.get('/client/reservations'),
      api.get('/client/messages?limit=5')
    ])
    favoris.value = fav.data
    reservations.value = resa.data
    messages.value = msg.data
  } catch (e) {
    error.value = "Erreur lors du chargement des données."
  } finally {
    loading.value = false
  }
})

// Résumé métriques
const metrics = computed(() => [
  { label: 'Favoris', value: favoris.value.length, icon: Heart },
  { label: 'Réservations', value: reservations.value.length, icon: CalendarCheck },
  { label: 'Messages', value: messages.value.length, icon: Inbox }
])

// Guides pratiques
const guides = [
  {
    title: "Comment réserver un bien ?",
    text: "Suivez les étapes simples pour organiser une visite.",
    link: "/client/guide/reservation",
    icon: CalendarCheck
  },
  {
    title: "Ajouter aux favoris",
    text: "Gérez vos biens préférés facilement.",
    link: "/client/guide/favoris",
    icon: BookmarkCheck
  },
  {
    title: "Contacter un agent",
    text: "Utilisez la messagerie intégrée pour toutes vos questions.",
    link: "/client/guide/messages",
    icon: Send
  }
]

const lastReservations = computed(() => reservations.value.slice(0, 4))
const lastMessages = computed(() => messages.value.slice(0, 4))

// Helpers
const formatDate = d => new Date(d).toLocaleDateString('fr-FR')
const truncate = (str, n) => str && str.length > n ? str.slice(0, n) + '…' : str
</script>

<style scoped>
@import 'animate.css';

.dashboard { min-height: 80vh; }
.title-gradient {
  background: linear-gradient(90deg,#3f51b5,#7c4dff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
}
.section-title { font-weight: 600; color:#3f51b5; }
.metric-card { border: none; border-radius: 14px; background:#fff; transition: transform 0.2s ease; }
.metric-card:hover { transform: translateY(-4px); }

.guide-card { border: none; border-radius: 14px; transition: all 0.3s ease; }
.guide-card:hover { transform: scale(1.02); background-color: #f8f9fa; }

.metric-icon, .guide-icon {
  width: 36px;
  height: 36px;
  color: #7c4dff;
}
.thumb-img { width:60px;height:60px;object-fit:cover; }
.welcome-banner {
  background: linear-gradient(to right, #f0f4ff, #f9f6ff);
}
</style>
