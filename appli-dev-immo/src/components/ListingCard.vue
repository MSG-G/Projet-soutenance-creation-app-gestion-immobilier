<template>
  <div class="col-md-4">
    <div class="listing-card bg-white p-2 rounded shadow-sm">
      <img :src="image" class="img-fluid rounded" :alt="titre" />
      <p class="mt-2 fw-bold">{{ titre }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  image: String,
  titre: String
})
</script>
