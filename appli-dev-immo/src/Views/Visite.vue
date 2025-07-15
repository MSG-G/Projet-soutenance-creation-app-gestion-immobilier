<template>
<div class="container-fluid mt-4">

<!-- Bloc : Visites à venir -->

    
    <div class="row ms-5 mt-3">
      <div class="col-12 col-md-10 col-lg-10">
      <div class="card shadow rounded bg-white">
      <div class="card-header d-flex justify-content-between align-items-center pb-3">
        <h5 class="mb-0">Visites à venir</h5>
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle">Tri</button>
      </div>
      <div class="table-responsive">
        <table class="table table-striped text-center m-0">
          <thead>
  <tr>
    <th scope="col">Date</th>
    <th scope="col">Mois</th>
    <th scope="col">Action</th>
  </tr>
</thead>

          <tbody>
            <tr v-for="visite in visites" :key="visite.id">
              <td>{{ visite.date }}</td>
              <td>{{ visite.mois }}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary">Planifier la visite</button>
              </td>
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
const visites = [
  { id:null, date: "", mois: "" },
  { id:null, date: "", mois: "" },
  { id:null, date: "", mois: "" },
];
</script>

<style scoped>
@media (max-width: 768px) {
  table {
    font-size: 0.85rem;
  }
  .card-header h5 {
    font-size: 1rem;
  }
  
}
.card {
border: none;
  border-radius: 12px;
  overflow: hidden;
}

.table {
  margin: 0;
}


</style>