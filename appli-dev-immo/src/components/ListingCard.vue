<template>
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm listing-card">
      <img :src="bien.photos.length > 0 ? bien.photos[0].url : '/placeholder.jpg'" class="card-img-top" :alt="bien.titre">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ bien.titre }}</h5>
        <p class="card-text text-muted">{{ bien.adresse }}</p>
        <h6 class="text-primary fw-bold">{{ bien.prix }} € / mois</h6>
        <button @click="onReserve" class="btn btn-primary mt-auto">Réserver une visite</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  bien: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['reserve']);

const onReserve = () => {
  console.log('Bouton Réserver cliqué dans ListingCard. Bien:', props.bien);
  emit('reserve', props.bien);
};
</script>

<style scoped>
.listing-card {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.listing-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.card-img-top {
  height: 200px;
  object-fit: cover;
}
</style>