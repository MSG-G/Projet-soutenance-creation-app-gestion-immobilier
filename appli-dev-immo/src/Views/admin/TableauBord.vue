<template>
  <div class="admin-dashboard p-4">
    <!-- En-tête -->
    <div class="header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 animate-fade">
      <div>
        <h2 class="fw-bold text-primary">Bienvenue, Admin</h2>
        <p class="text-muted">Vue d'ensemble de l'agence immobilière</p>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-primary">Exporter Données</button>
        
      </div>
    </div>

    <!-- Statistiques clés -->
    <div class="row g-4 mb-4 animate-slide-up">
      <div class="col-sm-6 col-lg-3" v-for="(item, i) in statCards" :key="i">
        <StatCard :titre="item.titre" :valeur="item.valeur" :variation="item.variation" :type="item.type" />
      </div>
    </div>

    <!-- Graphiques -->
    <div class="row g-4 mb-4">
      <div class="col-lg-8 animate-slide-left">
        <ChartBox titre="Revenus Mensuels" :revenu="chartData" />
      </div>
      <div class="col-lg-4 animate-slide-right">
        <ChartBox titre="Répartition des Biens" type="pie" :data="pieData" />
      </div>
    </div>

    <!-- Visites planifiées et derniers biens -->
    <div class="row g-4">
      <div class="col-lg-6 animate-slide-up">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3">Visites à venir</h5>
          <ul class="list-group">
            <li class="list-group-item" v-for="visit in visites" :key="visit.id">
              <strong>{{ visit.bien }}</strong> avec {{ visit.client }} le {{ visit.date }}
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6 animate-slide-up">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3">Derniers biens ajoutés</h5>
          <ListingCard v-for="bien in biensRecents" :key="bien.id" :titre="bien.titre" :image="bien.image" />
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
import StatCard from '@/components/StatCard.vue'
import ChartBox from '@/components/ChartBox.vue'
import ListingCard from '@/components/ListingCard.vue'
import { ref } from 'vue'

const statCards = ref([
  { titre: "Biens disponibles", valeur: 120, variation: "+5%", type: "primary" },
  { titre: "Ventes ce mois", valeur: 25, variation: "+12%", type: "success" },
  { titre: "Locations actives", valeur: 56, variation: "-3%", type: "warning" },
  { titre: "Clients inscrits", valeur: 240, variation: "+7%", type: "info" }
])

const chartData = ref([500000, 700000, 900000, 1000000, 1200000, 950000])
const pieData = ref([
  { name: 'Appartements', value: 40 },
  { name: 'Maisons', value: 30 },
  { name: 'Villas', value: 20 },
  { name: 'Studios', value: 10 }
])

const visites = ref([
  { id: 1, bien: 'Villa à Ngor', client: 'M. Ba', date: '12/07/2025 à 14h' },
  { id: 2, bien: 'Appartement Mermoz', client: 'Mme Ndiaye', date: '13/07/2025 à 10h' }
])

const biensRecents = ref([
  { id: 1, titre: 'Studio Plateau', image: '/images/studio.jpg' },
  { id: 2, titre: 'Villa aux Almadies', image: '/images/villa.jpg' }
])
</script>

<style scoped>
.admin-dashboard {
  background-color: #f8f9fc;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
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
