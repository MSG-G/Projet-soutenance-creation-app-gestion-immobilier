<template>
  <div class="container-fluid ps-4" style="padding-top: 20px;">
    <!-- Ligne 1 : Admins / Clients -->
    <div class="row mb-4 justify-content-around ms-5">
      <div class="col-md-5 col-lg-5 mb-3">
        <div class="card d-flex flex-row align-items-center p-3 shadow rounded-1 ps-5">
          <img :src="adminIcon" alt="icon représentant un admin" class="me-3" width="40" />
          <div>
            <h5>Admins</h5>
            <p class="mb-0 text-primary">{{stats.admins}}</p>
          </div>
        </div>
      </div>

      <div class="col-md-5 col-lg-5 mb-3">
        <div class="card d-flex flex-row align-items-center p-3 shadow rounded-1 ps-5">
          <img :src="clientIcon" alt="icon représentant un client" class="me-3" width="40" />
          <div>
            <h5>Clients</h5>
            <p class="mb-0 text-primary">{{stats.clients}}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Ligne 2 : Visites / Approbation -->
    <div class="row mb-4 justify-content-around ms-4">
      <div class="col-md-5 col-lg-5 mb-3">
        <div class="card d-flex flex-row align-items-center p-3 ps-5 shadow rounded-1">
          <img :src="visiteIcon" alt="icon pour visite" class="me-3" width="40" />
          <div>
            <h5>Visites</h5>
            <p class="mb-0 text-primary">{{stats.visites}}</p>
          </div>
        </div>
      </div>

      <div class="col-md-5 col-lg-5 mb-3">
        <div class="card d-flex flex-row align-items-center p-3 shadow rounded-1 ps-5">
          <img :src="approbationIcon" alt="icon représentant une approbation" class="me-3" width="40" />
          <div>
            <h5>Approbation</h5>
            <p class="mb-0 text-primary">{{stats.approbation}}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Biens récents -->
    <section class="bg-white shadow rounded p-3 ms-5 me-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
          <img :src="recentIcon" alt="icon représentant des biens récents" width="22" class="me-2" />
          <h6 class="mb-0">Biens récents</h6>
        </div>
        <span class="badge bg-primary">+3 nouveaux</span>
      </div>

      <div class="row">
        <div class="col">
          <BiensRecents />
        </div>
      </div>
    </section>
  </div>
</template>


<script setup>

const stats = {
  admins:"",
  clients:"" ,
  visites: "",
  approbation:""
};


import BiensRecents from '../components/BiensRecents.vue';
import adminIcon from '../assets/admin.svg'
import clientIcon from '../assets/client.svg'
import visiteIcon from '../assets/visite.svg'
import approbationIcon from '../assets/approbation.svg'
import recentIcon from '../assets/récent.svg'



</script>

<style scoped>
.card{
border: none;
}
</style>
