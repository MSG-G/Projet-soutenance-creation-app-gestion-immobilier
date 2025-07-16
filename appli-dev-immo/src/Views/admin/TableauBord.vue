<template>
  <div class="admin-dashboard p-4">
    <!-- En-tête -->
    <div class="header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 animate-fade">
      <div>
        <h2 class="fw-bold text-primary">Bienvenue, Admin</h2>
        <p class="text-muted">Vue d'ensemble de l'agence immobilière</p>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" @click="exporterDonnees">Exporter Données</button>
      </div>
    </div>

    <!-- Statistiques clés -->
    <div class="row g-4 mb-4 animate-slide-up">
      <div class="col-sm-6 col-lg-3" v-for="(item, i) in statCards" :key="i">
        <div class="stat-card card shadow-sm p-3 text-center">
          <div class="stat-icon mb-2" :class="item.iconBg">
            <i :class="item.icon"></i>
          </div>
          <h6 class="fw-bold mb-1">{{ item.titre }}</h6>
          <div class="fs-3 fw-bold mb-1">{{ formatNumber(item.valeur) }}</div>
          <span class="badge" :class="item.variation >= 0 ? 'bg-success' : 'bg-danger'">
            <i :class="item.variation >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'"></i>
            {{ Math.abs(item.variation) }}%
          </span>
        </div>
      </div>
      <!-- Chiffre d'affaires -->
      <div class="col-sm-6 col-lg-3">
        <div class="stat-card card shadow-sm p-3 text-center bg-gradient bg-light">
          <div class="stat-icon mb-2 bg-dark text-white"><i class="fas fa-coins"></i></div>
          <h6 class="fw-bold mb-1">Chiffre d'affaires total</h6>
          <div class="fs-3 fw-bold mb-1">{{ formatNumber(chiffreAffairesTotal) }} FCFA</div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="stat-card card shadow-sm p-3 text-center bg-gradient bg-light">
          <div class="stat-icon mb-2 bg-info text-white"><i class="fas fa-calendar-alt"></i></div>
          <h6 class="fw-bold mb-1">CA ce mois</h6>
          <div class="fs-3 fw-bold mb-1">{{ formatNumber(chiffreAffairesMois) }} FCFA</div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="stat-card card shadow-sm p-3 text-center bg-gradient bg-light">
          <div class="stat-icon mb-2 bg-warning text-white"><i class="fas fa-percentage"></i></div>
          <h6 class="fw-bold mb-1">Taux d'occupation</h6>
          <div class="fs-3 fw-bold mb-1">{{ tauxOccupation }}%</div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="stat-card card shadow-sm p-3 text-center bg-gradient bg-light">
          <div class="stat-icon mb-2 bg-success text-white"><i class="fas fa-user-plus"></i></div>
          <h6 class="fw-bold mb-1">Nouveaux clients ce mois</h6>
          <div class="fs-3 fw-bold mb-1">{{ nouveauxClientsMois }}</div>
        </div>
      </div>
    </div>

    <!-- Top villes et agents -->
    <div class="row g-4 mb-4 animate-slide-up">
      <div class="col-lg-6">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="mb-3"><i class="fas fa-city me-2"></i>Top villes (biens)</h5>
          <ol class="list-group list-group-numbered">
            <li v-for="(ville, i) in topVilles" :key="ville.nom" class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ ville.nom }}</span>
              <span class="badge bg-primary rounded-pill">{{ ville.count }}</span>
            </li>
            <li v-if="!topVilles.length" class="list-group-item text-muted">Aucune donnée</li>
          </ol>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="mb-3"><i class="fas fa-user-tie me-2"></i>Top agents (ventes/locations)</h5>
          <ol class="list-group list-group-numbered">
            <li v-for="(agent, i) in topAgents" :key="agent.nom" class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ agent.nom }}</span>
              <span class="badge bg-success rounded-pill">{{ agent.count }}</span>
            </li>
            <li v-if="!topAgents.length" class="list-group-item text-muted">Aucune donnée</li>
          </ol>
        </div>
      </div>
    </div>

    <!-- Graphiques -->
    <div class="row g-4 mb-4">
      <div class="col-lg-8 animate-slide-left">
        <ChartBox titre="Revenus Mensuels" :revenu="revenusMois" />
      </div>
      <div class="col-lg-4 animate-slide-right">
        <ChartBox titre="Répartition des Biens" type="pie" :data="repartitionTypes" />
      </div>
    </div>

    <!-- Visites planifiées et derniers biens -->
    <div class="row g-4">
      <div class="col-lg-6 animate-slide-up">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3">Visites à venir</h5>
          <ul class="list-group">
            <li class="list-group-item d-flex align-items-center" v-for="visit in visites" :key="visit.id">
              <i class="fas fa-calendar-alt text-primary me-2"></i>
              <div>
                <strong>{{ visit.bien }}</strong> avec {{ visit.client }}<br>
                <span class="text-muted small">le {{ formatDate(visit.date) }}</span>
              </div>
            </li>
            <li v-if="!visites.length" class="list-group-item text-muted">Aucune visite à venir.</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6 animate-slide-up">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3">Derniers biens ajoutés</h5>
          <div class="row g-2">
            <div v-for="bien in biensRecents" :key="bien.id" class="col-6">
              <div class="listing-card card p-2 h-100">
                <img
  :src="(bien.photos && bien.photos.length)
    ? (bien.photos[0].url + '?t=' + (bien.updated_at || Date.now()))
    : (bien.image ? (bien.image + '?t=' + (bien.updated_at || Date.now())) : '/images/placeholder.png')"
  class="img-fluid rounded mb-2"
  style="height:90px;object-fit:cover;"
/>
                <div class="fw-semibold small mb-1">{{ bien.titre }}</div>
                <div class="text-muted small">Ajouté le {{ formatDate(bien.created_at) }}</div>
              </div>
            </div>
            <div v-if="!biensRecents.length" class="text-muted ps-3">Aucun bien récent.</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bannière info -->
    <div class="alert alert-info mt-5 animate-fade">
      <i class="fas fa-info-circle me-2"></i>
      Des biens nécessitent une validation. Consultez l'onglet "Modération".
    </div>
  </div>
</template>

<script setup>
import ChartBox from '@/components/ChartBox.vue'
import { ref, onMounted } from 'vue'
import { biensApi, usersApi, reservationsApi } from '../../utils/apiResources'

const statCards = ref([
  { titre: 'Biens disponibles', valeur: 0, variation: 0, icon: 'fas fa-home', iconBg: 'bg-primary text-white' },
  { titre: 'Ventes ce mois', valeur: 0, variation: 0, icon: 'fas fa-handshake', iconBg: 'bg-success text-white' },
  { titre: 'Locations actives', valeur: 0, variation: 0, icon: 'fas fa-key', iconBg: 'bg-warning text-white' },
  { titre: 'Clients inscrits', valeur: 0, variation: 0, icon: 'fas fa-users', iconBg: 'bg-info text-white' }
])
const chiffreAffairesTotal = ref(0)
const chiffreAffairesMois = ref(0)
const tauxOccupation = ref(0)
const nouveauxClientsMois = ref(0)
const topVilles = ref([])
const topAgents = ref([])
const revenusMois = ref([])
const repartitionTypes = ref([])
const visites = ref([])
const biensRecents = ref([])
const loading = ref(true)
const error = ref('')

function formatNumber(val) {
  if (val == null) return ''
  return val.toLocaleString('fr-FR')
}
function formatDate(date) {
  if (!date) return ''
  return new Date(date).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' })
}

function exporterDonnees() {
  // Préparer les données à exporter
  const lignes = [
    ['Statistique', 'Valeur'],
    ['Biens disponibles', statCards.value[0].valeur],
    ['Ventes ce mois', statCards.value[1].valeur],
    ['Locations actives', statCards.value[2].valeur],
    ['Clients inscrits', statCards.value[3].valeur],
    ["Chiffre d'affaires total", chiffreAffairesTotal.value],
    ["Chiffre d'affaires du mois", chiffreAffairesMois.value],
    ["Taux d'occupation", tauxOccupation.value + '%'],
    ['Nouveaux clients ce mois', nouveauxClientsMois.value],
  ]
  // Générer le CSV
  const csv = lignes.map(ligne => ligne.map(val => '"' + String(val).replace(/"/g, '""') + '"').join(',')).join('\n')
  // Créer un blob et déclencher le téléchargement
  const blob = new Blob([csv], { type: 'text/csv' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = 'statistiques-immobilier.csv'
  document.body.appendChild(a)
  a.click()
  document.body.removeChild(a)
  URL.revokeObjectURL(url)
}

const chargerStats = async () => {
  loading.value = true
  try {
    const [biensRes, usersRes, reservationsRes] = await Promise.all([
      biensApi.list(),
      usersApi.list(),
      reservationsApi.list()
    ])
    const biens = biensRes.data
    const users = usersRes.data
    const reservations = reservationsRes.data
    // Statistiques clés
    statCards.value[0].valeur = biens.filter(b => b.statut === 'disponible').length
    statCards.value[1].valeur = biens.filter(b => b.statut === 'vendu').length
    statCards.value[2].valeur = biens.filter(b => b.statut === 'loue').length
    statCards.value[3].valeur = users.filter(u => u.role === 'client' || u.role === 'Client').length
    // Chiffre d'affaires total (ventes + locations)
    chiffreAffairesTotal.value = biens.filter(b => b.statut === 'vendu' || b.statut === 'loue').reduce((sum, b) => sum + (b.prix || 0), 0)
    // Chiffre d'affaires du mois
    const now = new Date()
    const mois = now.getMonth()
    const annee = now.getFullYear()
    chiffreAffairesMois.value = biens.filter(b => (b.statut === 'vendu' || b.statut === 'loue') && b.updated_at && new Date(b.updated_at).getMonth() === mois && new Date(b.updated_at).getFullYear() === annee).reduce((sum, b) => sum + (b.prix || 0), 0)
    // Taux d'occupation
    const nbLoues = biens.filter(b => b.statut === 'loue').length
    const nbDispo = biens.filter(b => b.statut === 'disponible').length
    tauxOccupation.value = nbDispo + nbLoues > 0 ? Math.round((nbLoues / (nbDispo + nbLoues)) * 100) : 0
    // Nouveaux clients ce mois
    nouveauxClientsMois.value = users.filter(u => (u.role === 'client' || u.role === 'Client') && u.created_at && new Date(u.created_at).getMonth() === mois && new Date(u.created_at).getFullYear() === annee).length
    // Top villes (par nombre de biens)
    const villeCounts = {}
    biens.forEach(b => {
      const ville = b.ville?.nom || 'Autre'
      villeCounts[ville] = (villeCounts[ville] || 0) + 1
    })
    topVilles.value = Object.entries(villeCounts).map(([nom, count]) => ({ nom, count })).sort((a, b) => b.count - a.count).slice(0, 5)
    // Top agents (par nombre de ventes/locations)
    const agentCounts = {}
    biens.filter(b => (b.statut === 'vendu' || b.statut === 'loue') && b.agent?.nom).forEach(b => {
      const nom = b.agent.nom
      agentCounts[nom] = (agentCounts[nom] || 0) + 1
    })
    topAgents.value = Object.entries(agentCounts).map(([nom, count]) => ({ nom, count })).sort((a, b) => b.count - a.count).slice(0, 5)
    // Graphique revenus mensuels (exemple fictif, à remplacer par vrai calcul)
    revenusMois.value = [500000, 700000, 900000, 1000000, 1200000, 950000]
    // Répartition des biens par type
    const typeCounts = {}
    biens.forEach(b => {
      const type = b.type_bien?.nom || 'Autre'
      typeCounts[type] = (typeCounts[type] || 0) + 1
    })
    repartitionTypes.value = Object.entries(typeCounts).map(([name, value]) => ({ name, value }))
    // Visites à venir (à partir des réservations avec date future)
    visites.value = reservations
      .filter(r => new Date(r.date) > now)
      .map(r => ({
        id: r.id,
        bien: r.bien?.titre || 'Bien',
        client: r.client?.nom || 'Client',
        date: r.date
      }))
      .sort((a, b) => new Date(a.date) - new Date(b.date))
      .slice(0, 5)
    // Derniers biens ajoutés (par date de création)
    biensRecents.value = [...biens]
      .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
      .slice(0, 4)
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement du tableau de bord'
  } finally {
    loading.value = false
  }
}

onMounted(chargerStats)
</script>

<style scoped>
.admin-dashboard {
  background-color: #f8f9fc;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
}
.stat-card {
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.07);
  transition: box-shadow 0.2s;
}
.stat-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.13);
}
.stat-icon {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  border-radius: 50%;
  margin: 0 auto 0.5rem auto;
}
.listing-card {
  border-radius: 10px;
  background: #f8f9fa;
  box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  transition: box-shadow 0.2s;
}
.listing-card:hover {
  box-shadow: 0 4px 16px rgba(0,0,0,0.09);
}
.animate-fade {
  animation: fadeIn 0.8s ease-in-out;
}
.animate-slide-up {
  animation: slideUp 0.8s ease-in-out;
}
.animate-slide-left {
  animation: slideLeft 0.8s ease-in-out;
}
.animate-slide-right {
  animation: slideRight 0.8s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; } to { opacity: 1; }
}
@keyframes slideUp {
  from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; }
}
@keyframes slideLeft {
  from { transform: translateX(-20px); opacity: 0; } to { transform: translateX(0); opacity: 1; }
}
@keyframes slideRight {
  from { transform: translateX(20px); opacity: 0; } to { transform: translateX(0); opacity: 1; }
}
</style>
