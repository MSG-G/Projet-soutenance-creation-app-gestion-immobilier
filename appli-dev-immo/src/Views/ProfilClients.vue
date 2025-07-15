<template>
  <div class="container-fluid mt-4">
    <div class="row ms-5">
      <div class="col-12 col-md-10 col-lg-11">
        <div class="table-responsive shadow rounded">
          <table class="table bg-white">
            <thead class="table-light">
              <tr>
                <th scope="col">Prénom - Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Statut</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="compte in comptes" :key="compte.id">
                <td>{{ compte.nom }}</td>
                <td>{{ compte.email }}</td>
                <td>{{ compte.statut }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const comptes = ref([
  { id: 1, nom: 'Moussa Diallo', email: 'moussa@mail.com', statut: 'Admin' },
  { id: 2, nom: 'Fatou Ndiaye', email: 'fatou@mail.com', statut: 'Client' },
  { id: 3, nom: 'Omar Ba', email: 'omar@mail.com', statut: 'Visiteur' },
])
</script>

<style scoped>
.table-responsive {

  border-radius: 12px;
  overflow: hidden;
}

.table {
  margin: 0;

}
</style>