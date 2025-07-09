<template>
  <div class="container p-3">
    <div class="row ms-5">
      <!-- Filtrage + Bouton ajout -->
      <div class="col-md-10 mb-5">
        <div class="body-champs1 d-flex justify-content-between align-items-center mt-4 rounded shadow-sm">
          <select v-model="statut">
            <option value="">Tous les statuts</option>
            <option value="En-attente">En-attente</option>
            <option value="Confirmee">Confirmée</option>
            <option value="Annulee">Annulée</option>
            <option value="Terminee">Terminée</option>
          </select>
            <button type="button" class="btn btn-primary P-visite">+ Programmer une visite</button>
        </div>
      </div>

      <!-- Boucle complète sur toute la réservation -->
      <div
        class="col-12 mb-4"
        v-for="res in reservationsFiltres"
        :key="res.id"
      >
        <div class="body-champs2 bg-white ps-2 pe-2 pb-3">
          <!-- Bien + statut -->
          <div class="nombiens d-flex justify-content-between align-items-center ms-5 mb-4 pt-1">
            <h5>
                <img :src="houseIcon" alt="" class="icon-img1 me-2">
                {{ res.bien }}</h5>
            <span class="badge bg-secondary">{{res.statut}}</span>
          </div>

          <!-- Les 4 cartes -->
          <div class="row text-center mb-3">
            <div class="col-12 col-md-6 col-lg-3 mb-3">
              <div class="card" style="background-color: #FFF7CA;">
                <div class="card-body">
                    <img :src="calendrierIcon" alt=""class="icon-img1 me-2">
                  <strong>Date</strong>
                  <p>{{res.date}}</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
              <div class="card" style="background-color: #DBFFCA;">
                <div class="card-body">
                    <img :src="horlogeIcon" alt="" class="icon-img1 me-2">
                  <strong>Heure</strong>
                  <p>{{res.heure}}</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
              <div class="card" style="background-color: #EDE9FF;">
                <div class="card-body">
                    <i class="fas fa-location-dot text-primary fs-2 me-2"></i>

                  <strong>Lieux</strong>
                  <p>{{res.lieu}}</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
              <div class="card" style="background-color:#EDE9FF;">
                <div class="card-body">
                    <img :src="cvisitIcon" alt=""class="icon-img1 me-2">
                  <strong>Client</strong>
                  <p>{{res.client}}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Notes -->
          <div class="notes p-3 rounded bg-secondary text-white">
            <strong>Notes</strong>
            <p  v-if="res.note">{{res.note}}</p>
          </div>

          <!-- Actions -->
          <div class="actions my-3 ms-4">
            <button type="button" class="btn btn-sm me-3 " style="background-color:#69F627">
              <img :src="confirmerIcon" alt="" class="icon-img">
              Confirmer</button>
            <button type="button" class="btn  btn-sm me-3" style="background-color: #FF9A9A;">
              <img :src="refuserIcon" alt="" class="icon-img">
              Refuser</button>
            <button type="button" class="btn btn-secondary btn-sm me-3">Modifier</button>
            <button type="button" class="btn btn-secondary btn-sm">Contacter le client</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, computed } from "vue";

import houseIcon from '../assets/domicile (1).svg'
import calendrierIcon from '../assets/calendrier.svg'
import horlogeIcon from '../assets/lhorloge.svg'
import cvisitIcon from '../assets/gestionnaire-de-mots-de-passe (1).svg'
import confirmerIcon from '../assets/verifier.svg'
import refuserIcon from '../assets/effacer.svg'



const statut = ref("");

// ⚠ Simule les données qu’on récupérera depuis une API ou un backend
const reservations = ref([
  {
    id: null,
    bien: "",
    date: "",
    heure: "",
    lieu: "",
    client: "",
    note: "",
    statut: "En-attente",
  },
]);

const reservationsFiltres = computed(() => {
  if (!statut.value) return reservations.value;
  return reservations.value.filter((r) => r.statut === statut.value);
});
</script>

<style scoped>
.body-champs1 select {
  padding: 6px 12px;
  border-radius:5px;
  border: none;
  height:52px;
}
.body-champs1 {
  background-color: gray;
}
.P-visite {
  min-width: 250px;
  height: 8vh;
}
.body-champs2 {
  height: auto;
  border-radius:10px;
}
.card {
    width: 12rem;
  border: none;
}
.notes {
  height: auto;
  background-color:#F2F2F2;
}
.icon-img1{
width: 40px;
height: 40px;
}
.icon-img{
width: 30px;
height: 30px;
}
</style>