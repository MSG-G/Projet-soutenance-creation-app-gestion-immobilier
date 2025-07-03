<template>
    <div class="container p-3">
    <div class="row ms-5">
    <!-- Champ de recherche -->
     <div class="col-12 col-md-10 col-lg-11">
    <div class="mb-3 d-flex flex-wrap bar-search">
      <div class="position-relative w-100 me-2" style="max-width: 45rem;">
  <input
    type="text"
    v-model="recherche"
    class="form-control ps-5"
    placeholder="Rechercher..."
  />
  <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
</div>

        <button type="button" class="btn btn-primary ms-0">rechercher</button>
        </div>
      </div>
        
       <div class="col-12 col-md-10 col-lg-11 d-flex">
      <select v-model="filtreLieu" class="form-select ms-4">
        <option value="" disabled selected>Lieux</option>
        <option value="Thiès">Thiès</option>
        <option value="Saint-Louis">Saint-Louis</option>
        <option value="Mbour">Mbour</option>
        <option value="Dakar">Dakar</option>
        <option value="kedougou">kédougou</option>
        <option value="Ziguinchor">Ziguinchor </option>
        <option value="Kaolack">Kaolack</option>
        
      </select>

      <select v-model="filtreType" class="form-select ms-5 me-5">
        <option value="" disabled selected>Type</option>
        <option value="Appartement">Appartement</option>
        <option value="Villa">Villa</option>
        <option value="Maison">Maison</option>
        <option value="Terrain">Terrain</option>
      </select>

      <select v-model="filtreStatut" class="form-select ms-5">
        <option value=""disabled selected>Statut</option>
        <option value="Disponible">Disponible</option>
        <option value="Vendu">Vendu</option>
      </select>
      </div>
  
    <div class="row g-4">
      <div
        v-for="bien in biensFiltres"
        :key="bien.id"
        class="col-11"
      >
        <div class="cardBien d-flex align-items-center shadow-sm">
          <img
            :src="bien.image"
            class="img-bien me-3"
            alt="image"
          />
          <div class="flex-grow-1">
            <h5 class="mb-1">{{ bien.nom }}</h5>
            <small class="text-muted d-block">
              <i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ bien.lieu }} 
            </small>
            <small class="text-muted d-block">
              <i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ bien.prix}} Fcfa
            </small>

          </div>
          <div class="ms-auto text-end">
             <i class="far fa-heart" aria-hidden="true"></i>
            <span class="text-primary fw-bold">{{ bien.statut }}</span><br />
           
          </div>
        </div>
      </div>
    </div>
 </div>
 </div>
</template>

<script setup>
import { ref } from 'vue'
const filtreLieu = ref("")
const filtreType = ref("")
const filtreStatut = ref("")
const recherche = ref("")

import { computed } from 'vue'

const biensFiltres = computed(() => {
  return biens.filter((bien) => {
    const correspondLieu = !filtreLieu.value || bien.lieu === filtreLieu.value
    const correspondType = !filtreType.value || bien.type === filtreType.value
    const correspondStatut = !filtreStatut.value || bien.statut === filtreStatut.value
    const correspondRecherche = !recherche.value || bien.nom.toLowerCase().includes(recherche.value.toLowerCase())

    return correspondLieu && correspondType && correspondStatut && correspondRecherche
  })
})


const biens = [
  {
    id: null,
    nom: "",
    image: "",
    lieu: "",
    prix: "",
    statut: "",
  },
  {
    id: null,
    nom: "",
    image: "",
    lieu: "",
    prix: "",
    statut: "",
  },
  {
    id:null ,
    nom: "",
    image: "",
    lieu: "",
   prix: "",
    statut: "",
  },
];
</script>

<style scoped>
.cardBien {
  background-color: white;
  padding: 15px;
  border-radius: 12px;
  border: none;
}
.img-bien {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}
.form-select {
  width:170px;
  height:8vh;
  }
  .form-control{
width: 45rem;
}
</style>



