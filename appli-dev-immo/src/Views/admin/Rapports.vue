<template>
  <div class="rapport container-fluid py-4">

    <!-- Filtres Dates -->
    <div class="row mb-4">
      <div class="col-md-10 d-flex flex-column flex-md-row gap-3 align-items-start align-items-md-end">
        <div class="w-100">
          <label class="form-label fw-semibold">Date de début</label>
          <input type="date" class="form-control" v-model="dateDebut" />
        </div>
        <div class="w-100">
          <label class="form-label fw-semibold">Date de fin</label>
          <input type="date" class="form-control" v-model="dateFin" />
        </div>
        <div class="mt-3 mt-md-0">
          <button class="btn btn-primary w-100" @click="genererRapport">
            <i class="fas fa-chart-line me-2"></i> Générer
          </button>
        </div>
      </div>
    </div>

    <!-- Cartes Statistiques -->
    <div class="row g-4 mb-4">
      <div class="col-md-3 col-sm-6" v-for="stat in statistiques" :key="stat.label">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">{{ stat.label }}</h6>
            <h4 class="text-primary fw-bold">{{ stat.valeur }}</h4>
          </div>
        </div>
      </div>
    </div>

    <!-- Tableau Résultats -->
    <div class="table-responsive mb-4">
      <table class="table table-bordered table-hover bg-white shadow-sm">
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
            <td>
              <span :class="['badge', getStatusBadgeClass(ligne.statut)]">
                {{ ligne.statut }}
              </span>
            </td>
            <td>{{ ligne.agent }}</td>
            <td>{{ ligne.montant }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Boutons Export -->
    <div class="d-flex justify-content-end gap-2">
      <button class="btn btn-outline-primary">
        <i class="fas fa-file-pdf me-1"></i> Exporter PDF
      </button>
      <button class="btn btn-outline-success">
        <i class="fas fa-file-excel me-1"></i> Exporter Excel
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const dateDebut = ref('')
const dateFin = ref('')

const statistiques = ref([
  { label: 'Total Biens', valeur: '50' },
  { label: 'Vendus ce mois', valeur: '15' },
  { label: 'Loués ce mois', valeur: '20' },
  { label: 'Revenus estimés', valeur: '7 500 000 FCFA' },
  { label: 'Visites planifiées', valeur: '12' },
  { label: 'Réservations confirmées', valeur: '18' }
])

const lignesRapport = ref([
  {
    date: '2025-07-05',
    bien: 'Appartement F3 - Ouakam',
    type: 'Location',
    statut: 'Confirmé',
    agent: 'Jean Fall',
    montant: '350 000 FCFA'
  },
  {
    date: '2025-07-08',
    bien: 'Villa Almadies',
    type: 'Vente',
    statut: 'En cours',
    agent: 'Sophie Ndiaye',
    montant: '45 000 000 FCFA'
  },
  {
    date: '2025-07-09',
    bien: 'Studio Mermoz',
    type: 'Location',
    statut: 'Annulé',
    agent: 'Alioune Ba',
    montant: '0 FCFA'
  }
])

const getStatusBadgeClass = (statut) => {
  switch (statut) {
    case 'Confirmé':
      return 'bg-success text-white'
    case 'En cours':
      return 'bg-warning text-dark'
    case 'Annulé':
      return 'bg-danger text-white'
    default:
      return 'bg-secondary text-white'
  }
}

function genererRapport() {
  console.log('Rapport généré pour :', dateDebut.value, dateFin.value)
}
</script>

<style scoped>
.rapport {
  min-height: 100vh;
  background-color: #f9fbfd;
  padding-left: 60px;
  font-family: 'Inter', sans-serif;
}

.table th,
.table td {
  vertical-align: middle;
}

.card h4 {
  font-size: 1.5rem;
}

.badge {
  padding: 0.4em 0.75em;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
}

@media (max-width: 768px) {
  .rapport .d-flex {
    flex-direction: column !important;
  }
}
</style>
