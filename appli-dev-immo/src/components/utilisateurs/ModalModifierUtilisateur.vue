<template>
    <div class="modal-overlay" @click.self="$emit('fermer')">
      <div class="modal-content p-4">
        <h4 class="mb-3 fw-bold text-warning">Modifier l'utilisateur</h4>
        <form @submit.prevent="updateUser">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nom complet</label>
            <input v-model="edited.name" type="text" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Rôle</label>
            <select v-model="edited.role" class="form-select" required>
              <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
            </select>
          </div>
          <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-secondary" @click="$emit('fermer')">Annuler</button>
            <button type="submit" class="btn btn-warning text-white">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const props = defineProps({ utilisateur: Object })
  const emit = defineEmits(['update', 'fermer'])
  
  const edited = ref({ ...props.utilisateur })
  const roles = ['Administrateur', 'Coordinateur', 'Superviseur', 'Agent', 'Opérateur', 'Assistant']
  
  function updateUser() {
    emit('update', edited.value)
    emit('fermer')
  }
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
    max-width: 450px;
    width: 100%;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  }
  </style>
  