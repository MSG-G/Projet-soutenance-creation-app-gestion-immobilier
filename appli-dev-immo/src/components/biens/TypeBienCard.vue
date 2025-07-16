<template>
  <div class="card typebien-card shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-2">
  <h5 class="card-title mb-0">{{ typeBien.nom }}</h5>
  <div class="d-flex gap-1">
    <button class="btn btn-sm btn-outline-primary" @click="$emit('show', typeBien)" title="Voir"><i class="fas fa-eye"></i></button>
    <button class="btn btn-sm btn-outline-secondary" @click="$emit('edit', typeBien)" title="Modifier"><i class="fas fa-edit"></i></button>
  </div>
</div>
      <div class="mb-1"><strong>Description :</strong> {{ typeBien.description || '-' }}</div>
    </div>
  </div>
</template>
<script setup>
defineProps({ typeBien: Object })
defineEmits(['show', 'edit'])
</script>
<style scoped>
.typebien-card {
  border-radius: 14px;
  transition: box-shadow 0.2s;
  cursor: pointer;
}
.typebien-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.13);
}
.card-title {
  font-size: 1.2rem;
}
</style>
