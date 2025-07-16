<template>
  <transition name="modal-fade">
    <div v-if="bien" class="modal-backdrop" @click.self="fermer">
      <div class="modal-content animate-pop">
        <h4 class="mb-3 fw-bold text-center text-primary">Détail du bien</h4>
        <div class="mb-3 text-center">
          <img
  :src="(bien.photos && bien.photos.length) ? (bien.photos[0].url + '?t=' + Date.now()) : (bien.image ? (bien.image + '?t=' + Date.now()) : '/images/placeholder.png')"
  alt="Aperçu"
  class="img-thumbnail img-preview mb-3 shadow"
  style="max-width:260px;max-height:180px;width:100%;height:auto;object-fit:cover;display:block;margin-left:auto;margin-right:auto;transition:box-shadow 0.2s;"
/>
        </div>
        <ul class="list-group mb-3">
          <li class="list-group-item"><strong>Titre :</strong> {{ bien.titre }}</li>
          <li class="list-group-item"><strong>Description :</strong> {{ bien.description }}</li>
          <li class="list-group-item"><strong>Prix :</strong> {{ bien.prix ? Number(bien.prix).toLocaleString() : '' }} FCFA</li>
          <li class="list-group-item"><strong>Surface :</strong> {{ bien.surface }} m²</li>
          <li class="list-group-item"><strong>Adresse :</strong> {{ bien.adresse }}</li>
          <li class="list-group-item"><strong>Statut :</strong> {{ bien.statut }}</li>
          <li class="list-group-item"><strong>Ville :</strong> {{ bien.ville?.nom }}</li>
          <li class="list-group-item"><strong>Type :</strong> {{ bien.type_bien?.nom }}</li>
          <li class="list-group-item"><strong>Propriétaire :</strong> {{ bien.proprietaire?.nom }} {{ bien.proprietaire?.prenom }}</li>
        </ul>
        <div class="d-flex justify-content-end mt-3">
          <button class="btn btn-outline-secondary" @click="fermer">Fermer</button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({ bien: Object })
const emit = defineEmits(['fermer'])
function fermer() { emit('fermer') }
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.55);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  padding: 0;
}

@media (max-width: 600px) {
  .modal-backdrop {
    align-items: flex-start;
    padding: 1rem 0.2rem;
  }
}

.modal-content {
  background: #fff;
  border-radius: 14px;
  padding: 2rem 1.5rem;
  width: 100%;
  max-width: 520px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

@media (max-width: 600px) {
  .modal-content {
    padding: 1rem 0.3rem;
    max-width: 98vw;
  }
}

.modal-content:hover {
  transform: scale(1.01);
}

.img-preview {
  max-width: 200px;
  max-height: 140px;
  border-radius: 6px;
  object-fit: cover;
}
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.3s;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
</style> 