<template>
  <div class="modal-overlay" @click.self="$emit('fermer')">
    <div class="modal-content p-4">
      <h4 class="mb-3 fw-bold text-success">Ajouter une location</h4>
      <form @submit.prevent="valider">
        <div class="mb-3">
  <label class="form-label">Bien</label>
  <select v-model="form.bien_id" class="form-select" required>
    <option value="" disabled>Choisir un bien</option>
    <option v-for="bien in biens" :key="bien.id" :value="bien.id">{{ bien.titre }}</option>
  </select>
  <!-- Affichage structuré des infos du bien sélectionné -->
  <div v-if="form.bien_id">
    <div v-for="bien in biens" :key="bien.id" v-if="bien.id === form.bien_id" class="mt-2 p-2 border rounded bg-light">
      <div class="row g-2 align-items-center">
        <div class="col-auto">
          <img v-if="(bien.photos && bien.photos.length)" :src="bien.photos[0].url + '?t=' + (bien.updated_at || Date.now())" alt="Photo" style="max-width:90px;max-height:60px;object-fit:cover;" />
          <img v-else-if="bien.image" :src="bien.image" alt="Photo" style="max-width:90px;max-height:60px;object-fit:cover;" />
        </div>
        <div class="col">
          <div><strong>Titre :</strong> {{ bien.titre }}</div>
          <div><strong>Description :</strong> {{ bien.description }}</div>
          <div><strong>Adresse :</strong> {{ bien.adresse }}</div>
          <div><strong>Prix :</strong> {{ bien.prix ? Number(bien.prix).toLocaleString() + ' FCFA' : '' }}</div>
          <div><strong>Surface :</strong> {{ bien.surface }} m²</div>
          <div><strong>Statut :</strong> {{ bien.statut }}</div>
          <div><strong>Ville :</strong> {{ bien.ville?.nom }}</div>
          <div><strong>Type :</strong> {{ bien.type_bien?.nom }}</div>
          <div><strong>Propriétaire :</strong> {{ bien.proprietaire?.nom }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
        <div class="mb-3">
          <label class="form-label">Locataire</label>
          <select v-model="form.locataire_id" class="form-select" required>
            <option value="" disabled>Choisir un locataire</option>
            <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Prix de location</label>
          <input v-model.number="form.prix" type="number" class="form-control" required min="0" />
        </div>
        <div class="mb-3">
          <label class="form-label">Date début</label>
          <input v-model="form.date_debut" type="date" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Date fin</label>
          <input v-model="form.date_fin" type="date" class="form-control" required />
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button type="button" class="btn btn-secondary" @click="$emit('fermer')">Annuler</button>
          <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import { biensApi, usersApi } from '../../utils/apiResources'
const emit = defineEmits(['ajouter', 'fermer'])
const form = ref({ bien_id: '', locataire_id: '', prix: '', date_debut: '', date_fin: '' })
const biens = ref([])
const clients = ref([])

// Watcher pour mettre à jour le prix automatiquement
watch(() => form.value.bien_id, (newId) => {
  if (newId) {
    // Forcer la comparaison sur l'id numérique
    const bien = biens.value.find(b => String(b.id) === String(newId))
    if (bien && bien.prix != null) {
      form.value.prix = bien.prix
    }
  } else {
    form.value.prix = ''
  }
})

const valider = () => {
  // Récupération de l'utilisateur connecté (depuis localStorage)
  const user = JSON.parse(localStorage.getItem('user'))
  // Construction du payload conforme au backend
  const payload = {
    bien_id: form.value.bien_id,
    client_id: form.value.locataire_id, // correspond à 'client_id' backend
    agent_id: user?.id || '', // id de l'agent connecté
    prix: form.value.prix,
    date_visite: form.value.date_debut, // mapping date début => date_visite
    date_debut: form.value.date_debut,  // on envoie aussi pour usage éventuel
    date_fin: form.value.date_fin,
    etat: 'planifiee' // valeur par défaut
  }
  // Vérification minimale
  if (payload.bien_id && payload.client_id && payload.agent_id && payload.prix && payload.date_visite && payload.date_fin) {
    emit('ajouter', payload)
  }
}
onMounted(async () => {
  const biensRes = await biensApi.list()
  biens.value = biensRes.data.filter(b => b.statut !== 'loué')
  const usersRes = await usersApi.list()
  clients.value = usersRes.data.filter(u => u.role === 'client' || u.role === 'Client')
})
watch(
  () => form.bien_id,
  (newBienId) => {
    const bien = biens.value?.find(b => b.id === newBienId) || biens.find(b => b.id === newBienId);
    if (bien && bien.prix !== undefined) {
      form.prix = bien.prix;
    }
  }
);

</script>
<style scoped>
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 2000; }
.modal-content { background: white; border-radius: 14px; max-width: 420px; width: 100%; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
</style> 