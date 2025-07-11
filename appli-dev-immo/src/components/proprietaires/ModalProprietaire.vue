<template>
  <div class="modal fade show d-block" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded-4 shadow">

        <!-- Header -->
        <div class="modal-header bg-gradient text-white">
          <h5 class="modal-title">
            {{ proprietaire?.id ? '✏️ Modifier un propriétaire' : '➕ Nouveau propriétaire' }}
          </h5>
          <button type="button" class="btn-close btn-close-white" aria-label="Fermer" @click="$emit('fermer')"></button>
        </div>

        <!-- Form -->
        <form @submit.prevent="validerFormulaire" novalidate>
          <div class="modal-body px-5 py-4">
            <div class="row g-4">

              <div class="col-md-6">
                <label for="nom" class="form-label">Nom complet <span class="text-danger">*</span></label>
                <div class="input-group has-icon">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input
                    v-model="form.nom"
                    type="text"
                    id="nom"
                    class="form-control"
                    :class="{ 'is-invalid': erreurs.nom }"
                    placeholder="Ex : Fatou Ndiaye"
                    required
                  />
                  <div v-if="erreurs.nom" class="invalid-feedback">{{ erreurs.nom }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <div class="input-group has-icon">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="form-control"
                    :class="{ 'is-invalid': erreurs.email }"
                    placeholder="exemple@email.com"
                  />
                  <div v-if="erreurs.email" class="invalid-feedback">{{ erreurs.email }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                <div class="input-group has-icon">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  <input
                    v-model="form.telephone"
                    type="tel"
                    id="telephone"
                    class="form-control"
                    :class="{ 'is-invalid': erreurs.telephone }"
                    placeholder="77 123 45 67"
                    required
                  />
                  <div v-if="erreurs.telephone" class="invalid-feedback">{{ erreurs.telephone }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <label for="adresse" class="form-label">Adresse</label>
                <div class="input-group has-icon">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input
                    v-model="form.adresse"
                    type="text"
                    id="adresse"
                    class="form-control"
                    placeholder="Dakar, Sénégal"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="modal-footer px-5 py-3 bg-light">
            <button type="button" class="btn btn-outline-secondary" @click="$emit('fermer')">Annuler</button>
            <button type="submit" class="btn btn-primary">
              {{ proprietaire?.id ? '✅ Mettre à jour' : '✅ Ajouter' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue'
import { isEmail } from '../../utils/validators'

const props = defineProps({
  proprietaire: Object
})

const emit = defineEmits(['fermer', 'enregistrer'])

const form = reactive({
  nom: '',
  email: '',
  telephone: '',
  adresse: ''
})

const erreurs = reactive({
  nom: '',
  email: '',
  telephone: ''
})

watch(
  () => props.proprietaire,
  (val) => {
    if (val) {
      Object.assign(form, val)
    } else {
      Object.assign(form, { nom: '', email: '', telephone: '', adresse: '' })
    }
  },
  { immediate: true }
)

function validerFormulaire() {
  erreurs.nom = form.nom ? '' : 'Le nom est requis.'
  erreurs.email = form.email && !isEmail(form.email) ? 'Email invalide' : ''
  erreurs.telephone = form.telephone ? '' : 'Le téléphone est requis.'

  if (!erreurs.nom && !erreurs.email && !erreurs.telephone) {
    emit('enregistrer', { ...form })
  }
}
</script>

<style scoped>
.modal {
  background-color: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(2px);
}

.modal-content {
  border-radius: 1rem;
}

.modal-header.bg-gradient {
  background: linear-gradient(90deg, #007bff, #4a90e2);
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}

.input-group.has-icon .form-control {
  border-left: 0;
}

.input-group-text {
  background-color: #f1f3f5;
  border-right: 0;
  border-radius: 0.375rem 0 0 0.375rem;
}

.input-group .form-control:focus {
  z-index: 2;
  border-color: #4a90e2;
  box-shadow: 0 0 0 0.15rem rgba(74, 144, 226, 0.3);
}

.invalid-feedback {
  font-size: 0.85rem;
}
</style>
