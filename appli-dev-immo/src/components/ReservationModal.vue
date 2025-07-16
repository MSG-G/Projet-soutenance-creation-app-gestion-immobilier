<template>
  <div v-if="visible" class="modal-backdrop" @click="closeModal">
    <div class="modal-container" @click.stop>
      <div class="modal-header">
        <h5 class="modal-title">Réserver une visite</h5>
        <button type="button" class="btn-close" @click="closeModal"></button>
      </div>
      <div class="modal-body">
        <div v-if="bien" class="row">
          <!-- Colonne Infos du bien -->
          <div class="col-md-6 bien-details">
            <h6 class="text-primary">{{ bien.titre }}</h6>
            <img :src="bien.image_url" class="img-fluid rounded mb-3" alt="Image du bien">
            <p><strong>Adresse :</strong> {{ bien.adresse }}</p>
            <p><strong>Prix :</strong> {{ bien.prix_formate }}</p>
            <p><strong>Type :</strong> {{ bien.type_bien?.nom }}</p>
            <p>{{ bien.description }}</p>
          </div>

          <!-- Colonne Formulaire -->
          <div class="col-md-6">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label for="nom" class="form-label">Nom complet</label>
                <input type="text" class="form-control" id="nom" v-model="formData.nom" readonly>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="formData.email" readonly>
              </div>
              <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" v-model="formData.telephone" readonly>
              </div>
              <div class="mb-3">
                <label for="date_visite" class="form-label">Date de visite souhaitée</label>
                <input type="date" class="form-control" id="date_visite" v-model="formData.date_visite" required>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message (facultatif)</label>
                <textarea class="form-control" id="message" rows="3" v-model="formData.message"></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100">Envoyer la demande</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  visible: Boolean,
  bien: Object
});

const emit = defineEmits(['close', 'submit']);

const formData = ref({
  nom: '', 
  email: '', 
  telephone: '', 
  date_visite: '',
  message: '',
  bien_id: null
});

watch(() => props.bien, (newBien) => {
  if (newBien) {
    formData.value.bien_id = newBien.id;
    if (newBien.user) {
      formData.value.nom = newBien.user.nom;
      formData.value.email = newBien.user.email;
      formData.value.telephone = newBien.user.telephone;
    }
  }
}, { immediate: true, deep: true });

function closeModal() {
  emit('close');
}

function submitForm() {
  emit('submit', formData.value);
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}

.modal-container {
  background: white;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,.5);
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #dee2e6;
}

.modal-body {
  padding: 1.5rem;
  overflow-y: auto;
}

.bien-details img {
  max-height: 200px;
  object-fit: cover;
}
</style>
