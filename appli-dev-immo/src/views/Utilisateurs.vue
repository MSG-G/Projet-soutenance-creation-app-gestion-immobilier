<template>
  <div class="container-fluid mt-4">
    <div class="row ms-5">
      <div class="col-12 col-md-10 col-lg-11">
        <div class="table-responsive shadow rounded">
          <table class="table bg-white ">
            <thead class="table-light">
              <tr>
                <th scope="col">Prénom - Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Statut</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in utilisateurs" :key="user.id">
                <td>{{user.nom}}</td>
                <td>{{user.email}}</td>
                <td>
                  <span :class="{
                    'badge bg-success': user.statut === 'Admin',
                    'badge bg-warning text-dark': user.statut === 'Client',
                    'badge bg-info': user.statut === 'Visiteur'
                  }">
                  {{user.statut}}
                </span>
                </td>
                <td><i class="far fa-bell text-end " aria-hidden="true" title="Notification"></i></td>

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

const utilisateurs= ref([
  { id: "", nom: '', email: '', statut: '' },
  { id: "", nom: '', email: '', statut: '' },
  { id: "", nom: '', email: '', statut: '' },
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
