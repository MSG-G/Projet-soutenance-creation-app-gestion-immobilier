<template>
  <div class="container-fluid p-4 admin-dashboard">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Gestion des utilisateurs</h2>
        <p class="text-muted fs-6">Gérez les profils, permissions et accès du personnel</p>
      </div>
      <button @click="openAddUserModal" class="btn btn-primary btn-lg shadow-sm">
        <UserPlus class="me-2" :size="18" /> Ajouter un utilisateur
      </button>
    </div>

    <!-- Filtres -->
    <div class="filter-section mb-4 d-flex flex-wrap align-items-center gap-3">
      <select v-model="selectedRole" class="form-select w-auto shadow-sm">
        <option value="">Tous les rôles</option>
        <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
      </select>
      <input
        v-model="searchQuery"
        type="search"
        class="form-control shadow-sm"
        placeholder="Rechercher un utilisateur..."
        style="max-width: 300px;"
      />
    </div>

    <!-- Liste utilisateurs -->
    <transition-group name="list" tag="div" class="user-table shadow-sm p-3 bg-white rounded-4">
      <div
        v-for="user in filteredUsers"
        :key="user.id"
        class="user-card d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 shadow-sm"
      >
        <div>
          <h5 class="mb-1 fw-semibold">{{ user.name }}</h5>
          <p class="text-muted mb-0 fst-italic fs-6">
            Rôle : <span class="role-badge">{{ user.role }}</span>
          </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          <button @click="viewUser(user)" class="btn btn-outline-info btn-sm" title="Voir">
            <Eye class="icon" />
          </button>
          <button @click="editUser(user)" class="btn btn-outline-warning btn-sm" title="Modifier">
            <PencilLine class="icon" />
          </button>
          <button @click="confirmDelete(user)" class="btn btn-outline-danger btn-sm" title="Supprimer">
            <Trash2 class="icon" />
          </button>
        </div>
      </div>
    </transition-group>

    <div v-if="!filteredUsers.length" class="text-center text-muted py-5 fs-5">
      <i class="fas fa-users-slash fa-3x mb-3"></i>
      <p>Aucun utilisateur à afficher.</p>
    </div>

    <!-- Modal création -->
    <ModalAjouterUtilisateur
      v-if="showModal"
      :roles="roles"
      @ajouter="addUser"
      @fermer="closeModal"
    />

    <!-- Modales actions -->
    <ModalVoirUtilisateur
      v-if="modalVoir"
      :utilisateur="utilisateurSelectionne"
      @fermer="modalVoir = false"
    />
    <ModalModifierUtilisateur
      v-if="modalModifier"
      :utilisateur="utilisateurSelectionne"
      :roles="roles"
      @update="handleUpdate"
      @fermer="modalModifier = false"
    />
    <ModalSupprimerUtilisateur
      v-if="modalSupprimer"
      :utilisateur="utilisateurSelectionne"
      @confirm="deleteUser(utilisateurSelectionne.id)"
      @cancel="modalSupprimer = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  Eye, PencilLine, Trash2, UserPlus
} from 'lucide-vue-next'

import ModalAjouterUtilisateur from '@/components/utilisateurs/ModalAjouterUtilisateur.vue'
import ModalVoirUtilisateur from '@/components/utilisateurs/ModalVoirUtilisateur.vue'
import ModalModifierUtilisateur from '@/components/utilisateurs/ModalModifierUtilisateur.vue'
import ModalSupprimerUtilisateur from '@/components/utilisateurs/ModalSupprimerUtilisateur.vue'

const users = ref([
  { id: 1, name: 'Marie Dupont', role: 'Administrateur' },
  { id: 2, name: 'Jean Martin', role: 'Coordinateur' },
  { id: 3, name: 'Sophie Leclerc', role: 'Superviseur' }
])

const roles = ['Administrateur', 'Coordinateur', 'Superviseur', 'Agent', 'Opérateur', 'Assistant']
const selectedRole = ref('')
const searchQuery = ref('')
const showModal = ref(false)
const newUser = ref({ name: '', role: '' })

const utilisateurSelectionne = ref(null)
const modalVoir = ref(false)
const modalModifier = ref(false)
const modalSupprimer = ref(false)

const filteredUsers = computed(() =>
  users.value.filter(user => {
    const matchesRole = !selectedRole.value || user.role === selectedRole.value
    const matchesSearch = !searchQuery.value || user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    return matchesRole && matchesSearch
  })
)

const openAddUserModal = () => {
  newUser.value = { name: '', role: '' }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const addUser = (user) => {
  users.value.push({ id: Date.now(), ...user })
  closeModal()
}

const viewUser = (user) => {
  utilisateurSelectionne.value = user
  modalVoir.value = true
}

const editUser = (user) => {
  utilisateurSelectionne.value = { ...user }
  modalModifier.value = true
}

const confirmDelete = (user) => {
  utilisateurSelectionne.value = user
  modalSupprimer.value = true
}

const deleteUser = (id) => {
  users.value = users.value.filter(u => u.id !== id)
  modalSupprimer.value = false
}

const handleUpdate = (updatedUser) => {
  const index = users.value.findIndex(u => u.id === updatedUser.id)
  if (index !== -1) users.value[index] = updatedUser
  modalModifier.value = false
}
</script>

<style scoped>
.icon {
  width: 18px;
  height: 18px;
}
.role-badge {
  background-color: #2a7de1;
  color: white;
  padding: 3px 10px;
  font-size: 0.8rem;
  border-radius: 12px;
  font-weight: 600;
}
</style>
