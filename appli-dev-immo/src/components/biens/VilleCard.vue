<template>
  <div class="card ville-card shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="card-title mb-0">{{ ville.nom }}</h5>
        <button class="btn btn-sm btn-outline-primary" @click="$emit('voir', ville)">
          <i class="fas fa-eye"></i>
        </button>
      </div>
      <div class="mb-1"><strong>Région :</strong> {{ ville.region || '-' }}</div>
      <div><strong>Code postal :</strong> {{ ville.code_postal || '-' }}</div>
    </div>
  </div>
</template>
<script setup>
defineProps({ ville: Object })
defineEmits(['voir'])
</script>
<style scoped>
.ville-card {
  border-radius: 14px;
  transition: box-shadow 0.2s;
  cursor: pointer;
}
.ville-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.13);
}
.card-title {
  font-size: 1.2rem;
}
</style>
