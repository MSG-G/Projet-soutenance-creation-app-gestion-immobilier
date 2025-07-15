<template>
  <div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h2 class="fw-bold text-primary">Tableau de bord</h2>
        <p class="text-muted">Vue d'ensemble des activités de l'agence immobilière</p>
        <div v-if="dateDebut && dateFin" class="text-secondary small mt-1">
          Période du <strong>{{ formatDate(dateDebut) }}</strong> au <strong>{{ formatDate(dateFin) }}</strong>
        </div>
      </div>
      <div class="d-flex flex-wrap gap-2 align-items-center">
        <input v-model="dateDebut" type="date" class="form-control shadow-sm" style="max-width: 150px;">
        <span class="mx-1">à</span>
        <input v-model="dateFin" type="date" class="form-control shadow-sm" style="max-width: 150px;">
        <button class="btn btn-outline-primary shadow-sm" @click="exporterDonnees">Exporter rapport</button>
      </div>
    </div>

    <!-- Détail du rapport -->
    <div class="card shadow-sm p-3 mb-4">
      <h5 class="fw-bold mb-2">Détail du rapport</h5>
      <ul class="list-unstyled mb-0">
        <li><strong>Total propriétés :</strong> {{ statCards[0].valeur }}</li>
        <li><strong>Biens vendus :</strong> {{ statCards[1].valeur }}</li>
        <li><strong>Biens loués :</strong> {{ statCards[2].valeur }}</li>
        <li><strong>Revenus sur la période :</strong> {{ statCards[3].valeur }}</li>
        <li><strong>Nouveaux locataires :</strong> {{ locatairesRecents.length }}</li>
      </ul>
      <div class="text-muted small mt-2">Rapport généré le {{ formatDate(new Date()) }}</div>
    </div>

    <!-- Statistiques principales -->
    <div class="row g-4 mb-4">
      <div v-for="(item, index) in statCards" :key="index" class="col-12 col-md-6 col-lg-3">
        <StatCard :titre="item.titre" :valeur="item.valeur" :variation="item.variation" :type="item.type" />
      </div>
    </div>

    <!-- Bande info -->
    <div class="alert alert-info d-flex justify-content-between align-items-center shadow-sm rounded">
      <div>
        <strong>{{ locatairesRecents.length }} locataires</strong> ont été ajoutés sur la période. <br />
        <small class="text-muted">{{ infoBannerMessage }}</small>
      </div>
      <button class="btn btn-sm btn-primary">Revoir</button>
    </div>

    <!-- Graphiques -->
    <div class="row g-4 mb-4">
      <div class="col-lg-7">
        <ChartBox titre="Statistiques de ventes" :totalVentes="stats.totalVentes" :profit="stats.profit" :cout="stats.cout" />
      </div>
      <div class="col-lg-5">
        <ChartBox titre="Croissance Annuelle" :revenu="growth.revenu" :texte="growth.texte" type="bar" />
      </div>
    </div>

    <!-- Biens en vitrine -->
    <div class="mb-3">
      <h4 class="fw-bold mb-3">Biens en vitrine</h4>
      <div class="row g-4">
        <div v-for="(listing, index) in listings" :key="index" class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm">
            <img v-if="listing.photos && listing.photos.length" :src="listing.photos[0].url" class="card-img-top" style="height:180px;object-fit:cover;" alt="Photo du bien" />
            <img v-else-if="listing.image" :src="listing.image" class="card-img-top" style="height:180px;object-fit:cover;" alt="Photo du bien" />
            <div class="card-body">
              <h6 class="card-title fw-bold">{{ listing.titre }}</h6>
            </div>
          </div>
        </div>
        <div v-if="!listings.length" class="text-muted ps-3">Aucun bien en vitrine.</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { biensApi, usersApi, reservationsApi } from '../../utils/apiResources'
import StatCard from '@/components/StatCard.vue'
import ChartBox from '@/components/ChartBox.vue'
import ListingCard from '@/components/ListingCard.vue'

const dateDebut = ref('')
const dateFin = ref('')
const biens = ref([])
const users = ref([])
const reservations = ref([])
const statCards = ref([
  { titre: 'Total Propriétés', valeur: 0, variation: '+0%', type: 'info' },
  { titre: 'Biens Vendus', valeur: 0, variation: '+0%', type: 'success' },
  { titre: 'Biens Loués', valeur: 0, variation: '+0%', type: 'warning' },
  { titre: 'Revenus sur la période', valeur: '0 FCFA', variation: '+0%', type: 'primary' }
])
const locatairesRecents = ref([])
const infoBannerMessage = ref('')
const stats = ref({ totalVentes: 0, profit: 0, cout: 0 })
const growth = ref({ revenu: 0, texte: '' })
const listings = ref([])

function formatNumber(val) {
  if (val == null) return ''
  return val.toLocaleString('fr-FR')
}
function formatDate(date) {
  if (!date) return ''
  const d = new Date(date)
  return d.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' })
}

const filtrerParDate = (arr, champ = 'created_at') => {
  if (!dateDebut.value && !dateFin.value) return arr
  return arr.filter(item => {
    const d = new Date(item[champ])
    if (dateDebut.value && d < new Date(dateDebut.value)) return false
    if (dateFin.value && d > new Date(dateFin.value + 'T23:59:59')) return false
    return true
  })
}

const chargerDonnees = async () => {
  const [biensRes, usersRes, reservationsRes] = await Promise.all([
    biensApi.list(),
    usersApi.list(),
    reservationsApi.list()
  ])
  biens.value = biensRes.data
  users.value = usersRes.data
  reservations.value = reservationsRes.data
  calculerStats()
}

function calculerStats() {
  // Filtrage par date
  const biensFiltres = filtrerParDate(biens.value, 'created_at')
  const biensVendus = biensFiltres.filter(b => b.statut === 'vendu')
  const biensLoues = biensFiltres.filter(b => b.statut === 'loue')
  // Statistiques principales
  statCards.value[0].valeur = biensFiltres.length
  statCards.value[1].valeur = biensVendus.length
  statCards.value[2].valeur = biensLoues.length
  // Revenus sur la période
  const revenus = [...biensVendus, ...biensLoues].reduce((sum, b) => sum + (b.prix || 0), 0)
  statCards.value[3].valeur = formatNumber(revenus) + ' FCFA'
  // Locataires récents (utilisateurs rôle client créés dans la période)
  locatairesRecents.value = filtrerParDate(users.value.filter(u => (u.role === 'client' || u.role === 'Client') && u.created_at), 'created_at')
  infoBannerMessage.value = locatairesRecents.value.length ? 'Des documents manquent pour certains dossiers.' : 'Aucun nouveau locataire sur la période.'
  // Stats pour graphiques (exemple)
  stats.value.totalVentes = biensVendus.length
  stats.value.profit = biensVendus.reduce((sum, b) => sum + (b.prix || 0), 0)
  stats.value.cout = biensVendus.reduce((sum, b) => sum + (b.cout || 0), 0)
  growth.value.revenu = biensVendus.reduce((sum, b) => sum + (b.prix || 0), 0)
  growth.value.texte = "Croissance des revenus sur la période"
  // Biens en vitrine : les 6 derniers biens filtrés
  listings.value = [...biensFiltres]
    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    .slice(0, 6)
    .map(b => ({
      ...b, // toutes les propriétés du bien, dont photos
      titre: b.titre, // pour compatibilité
      image: b.image // pour compatibilité
    }))
}

onMounted(chargerDonnees)
watch([dateDebut, dateFin], calculerStats)

function exporterDonnees() {
  // Export détaillé avec période
  const lignes = [
    ['Rapport immobilier'],
    ['Période', dateDebut.value ? formatDate(dateDebut.value) : '', dateFin.value ? formatDate(dateFin.value) : ''],
    [],
    ['Statistique', 'Valeur'],
    ['Total Propriétés', statCards.value[0].valeur],
    ['Biens Vendus', statCards.value[1].valeur],
    ['Biens Loués', statCards.value[2].valeur],
    ['Revenus sur la période', statCards.value[3].valeur],
    ['Nouveaux locataires', locatairesRecents.value.length],
    []
  ]
  const csv = lignes.map(ligne => ligne.map(val => '"' + String(val).replace(/"/g, '""') + '"').join(',')).join('\n')
  const blob = new Blob([csv], { type: 'text/csv' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `rapport-immobilier-${dateDebut.value || 'debut'}-au-${dateFin.value || 'fin'}.csv`
  document.body.appendChild(a)
  a.click()
  document.body.removeChild(a)
  URL.revokeObjectURL(url)
}
</script>

<style scoped>
.container-fluid {
  background-color: #f9fbfd;
  min-height: 100vh;
}
.alert {
  border-radius: 12px;
}
.btn-primary {
  background-color: #1e40af;
  border-color: #1e40af;
}
.btn-outline-primary {
  border-color: #1e40af;
  color: #1e40af;
}
.btn-outline-primary:hover {
  background-color: #1e40af;
  color: white;
}
</style>
