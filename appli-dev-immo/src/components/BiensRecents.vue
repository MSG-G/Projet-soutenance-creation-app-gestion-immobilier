<template>

  <div class="row g-3 p-2">
    <div v-for="bien in biens" :key="bien.id" class="col-12">
      <div class="d-flex shadow rounded p-2  shadow-sm align-items-center carte">
        <img :src="bien.image" alt="bien" class="img-thumbnail me-5" style="width: 80px; height: 80px;" />
        <div>
          <h4 class="mb-1">{{ bien.titre }}</h4>
          <small class="text-muted">{{ bien.ville?.nom }}</small><br/>
          <div class="d-flex justify-content-between align-items-center">
            <span>
            <strong>{{ bien.prix }} FCFA</strong>
            </span>

          <span class="badge" :class="(bien.statut ?? (bien.disponible ? 'bg-primary' : 'bg-secondary'))">
            {{ bien.statut ?? (bien.disponible ? 'Disponible' : 'Vendu') }}
          </span>
         </div>
        </div>
      </div>
    </div>
  </div>
 
</template>

<script setup>
const biens = [
  { id:"", nom: '', image: '', localisation: '', prix: '', disponible: true },
  { id: "", nom: '', image: '', localisation: '', prix: '', disponible: false },
  { id:"", nom: '', image: '', localisation: '', prix: '', disponible: true }
]
</script>

<style scoped>
.carte{
background-color:#E9E9E9;
}


</style>

