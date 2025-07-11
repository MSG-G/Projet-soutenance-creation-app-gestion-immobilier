<template>
  <div class="container-fluid py-5 reservation-page">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Gestion des visites</h2>
        <p class="text-muted fs-6">Planifiez, consultez et gérez les visites de biens immobiliers</p>
      </div>
      <button @click="openModal()" class="btn btn-primary btn-lg shadow-sm">
        <i class="fas fa-calendar-plus me-2"></i> Programmer une visite
      </button>
    </div>

    <!-- Filtres -->
    <div class="mb-4 d-flex align-items-center gap-3 flex-wrap">
      <label class="fw-semibold mb-0 me-2">Filtrer par statut :</label>
      <select v-model="selectedStatus" class="form-select w-auto shadow-sm">
        <option value="">Tous</option>
        <option value="pending">En attente</option>
        <option value="confirmed">Confirmée</option>
        <option value="refused">Refusée</option>
      </select>
    </div>

    <!-- Liste des visites -->
    <transition-group name="list" tag="div" class="d-flex flex-column gap-4">
      <div
        v-for="visit in filteredVisits"
        :key="visit.id"
        class="visit-row position-relative d-flex justify-content-between align-items-center p-4 rounded shadow-sm"
      >
        <div
          class="status-top position-absolute top-0 end-0 mt-2 me-3 fw-semibold"
          :class="statusTextClass(visit.status)"
        >
          {{ statusLabel(visit.status) }}
        </div>

        <div class="flex-grow-1">
          <h5 class="fw-bold mb-1">{{ visit.title }}</h5>
          <div class="text-muted small">{{ visit.date }} à {{ visit.time }} — {{ visit.location }}</div>
          <div class="text-muted small">Client : {{ visit.client }}</div>
          <div v-if="visit.note" class="text-muted small fst-italic">Note : {{ visit.note }}</div>
        </div>

        <div class="text-end d-flex gap-2 flex-wrap ms-3">
          <button
            @click="confirmVisit(visit.id)"
            class="btn btn-outline-success btn-sm shadow-sm"
            title="Confirmer"
          >
            <i class="fas fa-check"></i>
          </button>
          <button
            @click="refuseVisit(visit.id)"
            class="btn btn-outline-danger btn-sm shadow-sm"
            title="Refuser"
          >
            <i class="fas fa-times"></i>
          </button>
          <button
            @click="openModal(visit)"
            class="btn btn-outline-secondary btn-sm shadow-sm"
            title="Modifier"
          >
            <i class="fas fa-edit"></i>
          </button>
          <button
            @click="contactClient(visit.client)"
            class="btn btn-outline-primary btn-sm shadow-sm"
            title="Contacter"
          >
            <i class="fas fa-envelope"></i>
          </button>
        </div>
      </div>
    </transition-group>

    <div v-if="!filteredVisits.length" class="text-center text-muted mt-5 fs-5">
      <i class="fas fa-calendar-times fa-3x mb-3"></i>
      <p>Aucune visite disponible pour le moment.</p>
    </div>

    <!-- Modal de programmation -->
    <transition name="modal-fade">
      <div
        v-if="showModal"
        class="modal-overlay"
        @click.self="closeModal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalTitle"
      >
        <div class="modal-content p-4 bg-white rounded-4 shadow-lg">
          <h4 id="modalTitle" class="mb-3 fw-bold">
            {{ isEditing ? 'Modifier la visite' : 'Programmer une visite' }}
          </h4>
          <button @click="closeModal" class="btn btn-close btn-danger shadow-sm" aria-label="Fermer modal">
            ×
          </button>

          <form @submit.prevent="submitForm" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold" for="title">Titre (bien visité)</label>
              <input
                id="title"
                v-model="newVisit.title"
                type="text"
                class="form-control shadow-sm"
                required
                autocomplete="off"
                placeholder="Ex: Appartement centre-ville"
                autofocus
              />
            </div>

            <div class="mb-3 d-flex gap-3 flex-wrap">
              <div class="flex-fill">
                <label class="form-label fw-semibold" for="date">Date</label>
                <input
                  id="date"
                  v-model="newVisit.date"
                  type="date"
                  class="form-control shadow-sm"
                  required
                />
              </div>
              <div class="flex-fill">
                <label class="form-label fw-semibold" for="time">Heure</label>
                <input
                  id="time"
                  v-model="newVisit.time"
                  type="time"
                  class="form-control shadow-sm"
                  required
                />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold" for="location">Lieu</label>
              <input
                id="location"
                v-model="newVisit.location"
                type="text"
                class="form-control shadow-sm"
                required
                autocomplete="off"
              />
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold" for="client">Client</label>
              <input
                id="client"
                v-model="newVisit.client"
                type="text"
                class="form-control shadow-sm"
                required
                autocomplete="off"
              />
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold" for="note">Note (optionnel)</label>
              <textarea
                id="note"
                v-model="newVisit.note"
                class="form-control shadow-sm"
                rows="3"
                placeholder="Informations complémentaires"
              ></textarea>
            </div>

            <button
              type="submit"
              class="btn btn-primary w-100 btn-lg shadow"
              :disabled="!newVisit.title.trim() || !newVisit.date || !newVisit.time || !newVisit.location.trim() || !newVisit.client.trim()"
              aria-disabled="true"
            >
              {{ isEditing ? 'Enregistrer les modifications' : 'Enregistrer' }}
            </button>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const visits = ref([
  {
    id: 1,
    title: 'Appartement centre-ville',
    date: '2025-07-10',
    time: '14:00',
    location: 'Dakar Plateau',
    client: 'Fatou Ndiaye',
    note: 'Souhaite une visite rapide',
    status: 'pending'
  }
])

const selectedStatus = ref('')
const showModal = ref(false)

const filteredVisits = computed(() => {
  if (!selectedStatus.value) return visits.value
  return visits.value.filter(v => v.status === selectedStatus.value)
})

const newVisit = ref({
  id: null,
  title: '',
  date: '',
  time: '',
  location: '',
  client: '',
  note: ''
})

const isEditing = ref(false)

function resetNewVisit() {
  newVisit.value = {
    id: null,
    title: '',
    date: '',
    time: '',
    location: '',
    client: '',
    note: ''
  }
}

const openModal = (visit = null) => {
  if (visit) {
    newVisit.value = { ...visit }
    isEditing.value = true
  } else {
    resetNewVisit()
    isEditing.value = false
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const submitForm = () => {
  if (!newVisit.value.title || !newVisit.value.date || !newVisit.value.time || !newVisit.value.location || !newVisit.value.client) {
    alert('Veuillez remplir tous les champs obligatoires.')
    return
  }

  if (isEditing.value) {
    const index = visits.value.findIndex(v => v.id === newVisit.value.id)
    if (index !== -1) visits.value[index] = { ...newVisit.value }
  } else {
    const newId = visits.value.length ? Math.max(...visits.value.map(v => v.id)) + 1 : 1
    visits.value.push({
      id: newId,
      title: newVisit.value.title,
      date: newVisit.value.date,
      time: newVisit.value.time,
      location: newVisit.value.location,
      client: newVisit.value.client,
      note: newVisit.value.note,
      status: 'pending'
    })
  }

  closeModal()
}

const confirmVisit = id => {
  const v = visits.value.find(v => v.id === id)
  if (v) v.status = 'confirmed'
}

const refuseVisit = id => {
  const v = visits.value.find(v => v.id === id)
  if (v) v.status = 'refused'
}

const contactClient = client => {
  alert(`Contacter le client : ${client} (fonction à implémenter)`)
}

const statusLabel = status => {
  switch (status) {
    case 'pending': return 'En attente'
    case 'confirmed': return 'Confirmée'
    case 'refused': return 'Refusée'
    default: return status
  }
}

const statusTextClass = status => {
  return {
    'text-secondary': status === 'pending',
    'text-success': status === 'confirmed',
    'text-danger': status === 'refused'
  }
}
</script>
<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

.reservation-page {
  background-color: #f9fafb;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
  color: #2e3a59;
}

.text-primary {
  color: #4a90e2;
}

.visit-row {
  background-color: white;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  border-left: 5px solid #dee2e6;
  cursor: pointer;
  position: relative;
  border-radius: 8px;
}

.visit-row:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgb(74 144 226 / 0.25);
  border-left-color: #4a90e2;
}

.status-top {
  font-size: 0.9rem;
  white-space: nowrap;
}

.text-secondary {
  color: #6c757d !important;
}

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(46, 58, 89, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1100;
  padding: 20px;
  backdrop-filter: blur(5px);
}

.modal-content {
  max-width: 450px;
  width: 100%;
  background: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgb(74 144 226 / 0.3);
  position: relative;
}

.btn-close {
  position: absolute;
  top: 12px;
  right: 12px;
  font-size: 1.7rem;
  line-height: 1;
  border: none;
  background: transparent;
  color: #e74c3c;
  cursor: pointer;
  transition: color 0.3s ease;
}

.btn-close:hover {
  color: #c0392b;
}

.form-control,
.form-select,
textarea.form-control {
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 1rem;
  border: 1.5px solid #cbd5e1;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 1px 4px rgb(0 0 0 / 0.05);
}

.form-control:focus,
.form-select:focus,
textarea.form-control:focus {
  outline: none;
  border-color: #4a90e2;
  box-shadow: 0 0 10px rgb(74 144 226 / 0.5);
}

.btn-primary {
  background-color: #4a90e2;
  border-color: #4a90e2;
  font-weight: 600;
  box-shadow: 0 4px 8px rgb(74 144 226 / 0.4);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
  background-color: #357abd;
  border-color: #357abd;
  box-shadow: 0 6px 15px rgb(53 122 189 / 0.6);
}

.btn:disabled,
.btn[aria-disabled='true'] {
  cursor: not-allowed;
  opacity: 0.65;
}

/* Transition liste */
.list-enter-active,
.list-leave-active {
  transition: all 0.3s ease;
}

.list-enter-from {
  opacity: 0;
  transform: translateY(15px);
}

.list-enter-to {
  opacity: 1;
}
</style>