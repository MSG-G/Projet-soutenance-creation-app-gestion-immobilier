<template>
    <transition name="modal-fade">
      <div class="modal-overlay" @click.self="$emit('fermer')">
        <div class="modal-content p-4 bg-white rounded-4 shadow-lg">
          <h3 class="mb-4 fw-bold text-primary">Ajouter un utilisateur</h3>
          <button class="btn-close" @click="$emit('fermer')" aria-label="Fermer modal">×</button>
  
          <form @submit.prevent="valider" novalidate>
            <div class="mb-4">
              <label for="nom" class="form-label fw-semibold">Nom complet</label>
              <input
                id="nom"
                v-model="form.nom"
                type="text"
                class="form-control shadow-sm"
                placeholder="Ex : Alice Diouf"
                required
                autofocus
              />
            </div>
  
            <div class="mb-4">
              <label for="role" class="form-label fw-semibold">Rôle</label>
              <select
                id="role"
                v-model="form.role"
                class="form-select shadow-sm"
                required
              >
                <option value="" disabled>Choisissez un rôle</option>
                <option v-for="role in roles" :key="role" :value="role">
                  {{ role }}
                </option>
              </select>
            </div>
  
            <button
              type="submit"
              class="btn btn-primary w-100 btn-lg shadow"
              :disabled="!form.nom.trim() || !form.role"
            >
              <i class="fas fa-check me-2"></i> Ajouter
            </button>
          </form>
        </div>
      </div>
    </transition>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  defineProps({
    roles: Array
  })
  const emit = defineEmits(['ajouter', 'fermer'])
  
  const form = ref({ nom: '', role: '' })
  
  const valider = () => {
    if (form.value.nom.trim() && form.value.role) {
      emit('ajouter', { name: form.value.nom, role: form.value.role })
    }
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2000;
    padding: 20px;
    backdrop-filter: blur(3px);
  }
  
  .modal-content {
    position: relative;
    width: 100%;
    max-width: 450px;
    background-color: white;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  }
  
  .btn-close {
    position: absolute;
    top: 12px;
    right: 12px;
    font-size: 1.5rem;
    background: none;
    border: none;
    color: #e74c3c;
    cursor: pointer;
  }
  
  .btn-close:hover {
    color: #c0392b;
  }
  
  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity 0.25s ease;
  }
  
  .modal-fade-enter-from,
  .modal-fade-leave-to {
    opacity: 0;
  }
  
  .modal-fade-enter-to,
  .modal-fade-leave-from {
    opacity: 1;
  }
  </style>
  