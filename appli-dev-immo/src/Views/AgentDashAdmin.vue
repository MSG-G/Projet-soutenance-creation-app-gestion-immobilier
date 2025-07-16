<template>
  <div class="container-fluid mt-4">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-11">
        <div class="card shadow rounded bg-white p-3">
          <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h5 class="mb-0">Liste des agents</h5>
            <button class="btn btn-outline-primary btn-sm mt-2 mt-md-0">
              <i class="fas fa-user-plus me-2"></i> Ajouter un agent
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-hover text-center align-middle">
              <thead class="table-light">
                <tr>
                  <th>Nom complet</th>
                  <th>Email</th>
                  <th>Statut</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="agent in agents" :key="agent.id">
                  <td>{{ agent.nom }}</td>
                  <td>{{ agent.email }}</td>
                  <td>
                    <span class="badge bg-success">{{ agent.statut }}</span>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-outline-warning me-2">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
                <tr v-if="agents.length === 0">
                  <td colspan="4">Aucun agent disponible</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const agents = ref([
  { id: "", nom: '', email: '', statut: 'Actif' },
  { id: "", nom: '', email: '', statut: 'Actif' },
])
</script>

<style scoped>
.table-responsive {
  overflow-x: auto;
  border-radius: 12px;
}
table th, table td {
  white-space: nowrap;
}
</style>
