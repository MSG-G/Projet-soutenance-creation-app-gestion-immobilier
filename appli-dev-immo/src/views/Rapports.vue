<template>
  <div class="rapport container-fluid py-4">
    
    <div class="row mb-4">
    <div class="col-lg-11 col-md-8">
      <div class="d-flex flex-column flex-md-row gap-2">
        <input type="date" class="form-control" v-model="dateDebut" />
        <input type="date" class="form-control" v-model="dateFin" />
        <select class="form-select" v-model="filtreAgent">
          <option value="">Tous les agents</option>
          <option value="agent1">Agent 1</option>
          <option value="agent2">Agent 2</option>
        </select>
        <button class="btn btn-primary" @click="genererRapport">Générer</button>
      </div>
      </div>
    </div> 

    <div class="row g-4 mb-4">
      <div class="col-md-3 col-sm-6" v-for="stat in statistiques" :key="stat.label">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">{{ stat.label }}</h6>
            <h4>{{ stat.valeur }}</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Bien</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Agent</th>
            <th>Montant</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(ligne, index) in lignesRapport" :key="index">
            <td>{{ ligne.date }}</td>
            <td>{{ ligne.bien }}</td>
            <td>{{ ligne.type }}</td>
            <td>{{ ligne.statut }}</td>
            <td>{{ ligne.agent }}</td>
            <td>{{ ligne.montant }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3 d-flex justify-content-end gap-2">
      <button class="btn btn-outline-primary">Exporter PDF</button>
      <button class="btn btn-outline-success">Exporter Excel</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const dateDebut = ref('')
const dateFin = ref('')
const filtreAgent = ref('')

const statistiques = ref([
  { label: 'Total Biens', valeur: "" },
  { label: 'Vendus ce mois', valeur: "" },
  { label: 'Loués ce mois', valeur: "" },
  { label: 'Revenus estimés', valeur: ' FCFA' },
  { label: 'Visites planifiées', valeur: "" },
  { label: 'Réservations confirmées', valeur:"" }
])

const lignesRapport = ref([
  {
    date: '',
    bien: '',
    type: '',
    statut: '',
    agent: '',
    montant: ''
  },
  {
    date: '',
    bien: '',
    type: '',
    statut: '',
    agent: '',
    montant: ''
  }
])

function genererRapport () {
  // logiques de filtre / API à ajouter
  console.log('Génération du rapport avec :', dateDebut.value, dateFin.value, filtreAgent.value)
}
</script>

<style scoped>
.rapport {
  margin-left: 60px;
}
.card h4 {
  color: #0d6efd;
}
@media (max-width: 768px) {
  .rapport .d-flex.flex-md-row {
    flex-direction: column !important;
  }
  .rapport .d-flex.flex-md-row > * {
    width: 100% !important;
  }
}
</style>




