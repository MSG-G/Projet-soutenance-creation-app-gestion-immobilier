<template>
    <div class="modal-overlay" @click.self="$emit('fermer')">
      <div class="modal-content p-4">
        <h4 class="mb-3 fw-bold text-primary">Détails de l'utilisateur</h4>
        <p><strong>Nom :</strong> {{ utilisateur.name }}</p>
        <p><strong>Rôle :</strong> {{ utilisateur.role }}</p>
        <button @click="$emit('fermer')" class="btn btn-secondary mt-3">Fermer</button>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({ utilisateur: Object })
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
  