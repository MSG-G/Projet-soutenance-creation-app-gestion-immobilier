<template>
    <div class="modal-overlay" @click.self="$emit('cancel')">
      <div class="modal-content p-4 text-center">
        <h4 class="text-danger mb-3">Confirmer la suppression</h4>
        <p>Voulez-vous vraiment supprimer <strong>{{ utilisateur.name }}</strong> ?</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
          <button class="btn btn-secondary" @click="$emit('cancel')">Annuler</button>
          <button class="btn btn-danger" @click="$emit('confirm')">Supprimer</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({ utilisateur: Object })
  defineEmits(['confirm', 'cancel'])
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1100;
  }
  .modal-content {
    background: white;
    border-radius: 12px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  }
  </style>
  