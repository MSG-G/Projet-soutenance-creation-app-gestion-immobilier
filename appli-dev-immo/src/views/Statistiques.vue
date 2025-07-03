<template>
  <div class="main container-fluid">
    
    <!-- En-tête : barre de recherche et filtre -->
    <div class="row mb-4">
      <div class="col-11 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <h4 class="fw-bold m-0">Aperçu</h4>
        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
          <input type="text" class="form-control" placeholder="Rechercher un bien..." />
          <input type="date" class="form-control" />
          <button class="btn btn-primary">Exporter</button>
        </div>
      </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-4">
      <div
        v-for="(item, index) in statCards"
        :key="index"
        class="col-8 col-sm-4"
      >
        <StatCard
          :titre="item.titre"
          :valeur="item.valeur"
          :variation="item.variation"
          :type="item.type"
        />
      </div>
    </div>

    <!-- Info bannière -->
    <div class="row mb-4">
      <div class="col-11">
        <div class="info-banner d-flex flex-column flex-md-row align-items-start justify-content-between gap-2 p-3 bg-light rounded">
          <div>
            <strong>{{ infoBanner.count }} locataires</strong> ont été soumis récemment.<br />
            <small class="text-muted">{{ infoBanner.message }}</small>
          </div>
          <button class="btn btn-primary">Revoir</button>
        </div>
      </div>
    </div>

    <!-- Statistiques des ventes + croissance -->
    <div class="row g-4 mb-4">
      <div class="col-12 col-lg-6">
        <ChartBox 
          titre="Statistiques de ventes"
          :totalVentes="stats.totalVentes"
          :profit="stats.profit"
          :cout="stats.cout"
        />
      </div>
      <div class="col-12 col-lg-4">
        <ChartBox 
          titre="Croissance Annuelle"
          :revenu="growth.revenu"
          :texte="growth.texte"
          type="bar"
        />
      </div>
    </div>

    <!-- Listing Board -->
    <div>
      <h5>Biens en Vitrine </h5>
      <div class="row g-3">
        <div
          v-for="(listing, index) in listings"
          :key="index"
          class="col-12 col-sm-6 col-md-4"
        >
          <ListingCard 
            :titre="listing.titre"
            :image="listing.image"
          />
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import StatCard from '../components/StatCard.vue'
import ChartBox from '../components/ChartBox.vue'
import ListingCard from '../components/ListingCard.vue'

const statCards = ref([
  { titre: "Total Propriétés", valeur: "", variation: "", type: "danger" },
  { titre: "Total Vendu", valeur: "", variation: "", type: "success" },
  { titre: "Total Louer", valeur: "", variation: "", type: "success" },
  { titre: "Total Revenue", valeur: "", variation: "", type: "success" }
])

const infoBanner = ref({
  count: "",
  message: "Des problèmes ont été détectés, veuillez vérifier."
})

const stats = ref({
  totalVentes: "",
  profit: "",
  cout: ""
})

const growth = ref({
  revenu: "",
  texte: "Revenus issus des ventes et locations"
})

const listings = ref([
  { titre: "", image: "" },
  { titre: " ", image: "" },
  { titre: "", image: "" }
])
</script>

<style scoped>
.main {
  margin-left: 60px;
  padding: 20px;
  overflow-x: hidden;
}
.card-stats {
  border-radius: 1rem;
  background-color: white;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}
.info-banner {
  background-color: #e0f0ff;
  padding: 15px;
  border-radius: 10px;
}
.chart-box {
  background-color: white;
  border-radius: 1rem;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}
.listing-card img {
  border-radius: 0.5rem;
}
.btn-primary {
  background-color: #0d6efd;
  border: none;
}
</style>
