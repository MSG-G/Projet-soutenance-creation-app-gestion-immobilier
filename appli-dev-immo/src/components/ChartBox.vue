<template>
  <div class="chart-box p-3 rounded bg-white shadow-sm" style="min-height: 350px;">
    <div class="d-flex justify-content-between mb-3">
      <h6>{{ titre }}</h6>
      <slot name="select">
        <select class="form-select form-select-sm w-auto">
          <option>Le mois dernier</option>
          <option>Ce mois-ci</option>
        </select>
      </slot>
    </div>

    <!-- Si revenu est fourni, on affiche un graphique en barres -->
    <div v-if="revenu">
      <h4>{{ revenu }}</h4>
      <p class="small text-muted">{{ texte }}</p>
      <GraphiqueBarres
        :donneesGraphique="donneesGraphiqueBarres"
        :optionsGraphique="optionsGraphique"
      />
    </div>

    <!-- Sinon, on affiche le graphique des ventes -->
    <div v-else>
      <p>Total ventes : <strong>{{ totalVentes }}</strong></p>
      <p>Profit : <strong>{{ profit }}</strong></p>
      <p>Coût : <strong>{{ cout }}</strong></p>
      <GraphiqueLigne
        :donneesGraphique="donneesGraphiqueLigne"
        :optionsGraphique="optionsGraphique"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import GraphiqueLigne from './GraphiqueLigne.vue'
import GraphiqueBarres from './GraphiqueBarres.vue'

defineProps({
  titre: { type: String, required: true },
  revenu: { type: [String, Array], required: false },
  texte: { type: String, required: false },
  totalVentes: { type: [String, Number], required: false },
  profit: { type: [String, Number], required: false },
  cout: { type: [String, Number], required: false },
  data: { type: [Array, Object], required: false },
  type: { type: String, required: false }
})

// ✅ Données pour le graphique en ligne
const donneesGraphiqueLigne = ref({
  labels: ['Janv', 'Févr', 'Mars', 'Avr', 'Mai', 'Juin'],
  datasets: [
    {
      label: 'Ventes',
      data: [12000, 19000, 3000, 5000, 20000, 30000],
      borderColor: 'rgb(75, 192, 192)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      tension: 0.3
    }
  ]
})

// ✅ Données pour le graphique en barres
const donneesGraphiqueBarres = ref({
  labels: ['2020', '2021', '2022', '2023'],
  datasets: [
    {
      label: 'Revenus annuels',
      data: [120000, 150000, 180000, 220000],
      backgroundColor: 'rgba(54, 162, 235, 0.7)'
    }
  ]
})

// ✅ Options communes
const optionsGraphique = ref({
  responsive: true,
  maintainAspectRatio: false
})
</script>
