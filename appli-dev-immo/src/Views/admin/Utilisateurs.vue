<template>
  <div class="container-fluid p-4 admin-dashboard">
    <!-- En-tête et filtres -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Gestion des utilisateurs</h2>
        <p class="text-muted fs-6">Gérez les profils, permissions et accès du personnel</p>
      </div>
      <button @click="openAddUserModal" class="btn btn-primary btn-lg shadow-sm">
        <UserPlus class="me-2" :size="18" /> Ajouter un utilisateur
      </button>
    </div>
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
    <!-- Section ADMIN -->
    <div class="user-section mb-5">
      <h3 class="section-title admin mb-4"><i class="fas fa-user-shield me-2"></i> Administrateurs</h3>
      <div class="row">
        <div v-for="user in admins" :key="user.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card-user shadow-sm p-3 text-center animate__animated animate__fadeIn">
            <i class="fas fa-user-shield text-primary role-icon mb-3"></i>
            <h5 class="mb-1">{{ user.name }}</h5>
            <p class="mb-1 text-muted">{{ user.email }}</p>
            <span class="badge bg-primary mb-2 text-uppercase small">Administrateur</span>
            <div class="d-flex justify-content-center gap-2 mt-2">
              <button class="btn btn-sm btn-outline-info" @click="viewUser(user)"><i class="fas fa-eye"></i></button>
              <button class="btn btn-sm btn-outline-warning" @click="editUser(user)"><i class="fas fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(user)"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>
        <div v-if="admins.length === 0" class="text-muted ps-3">Aucun administrateur.</div>
      </div>
    </div>
    <!-- Section AGENT -->
    <div class="user-section mb-5">
      <h3 class="section-title agent mb-4"><i class="fas fa-user-tie me-2"></i> Agents</h3>
      <div class="row">
        <div v-for="user in agents" :key="user.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card-user shadow-sm p-3 text-center animate__animated animate__fadeIn">
            <i class="fas fa-user-tie text-success role-icon mb-3"></i>
            <h5 class="mb-1">{{ user.name }}</h5>
            <p class="mb-1 text-muted">{{ user.email }}</p>
            <span class="badge bg-success mb-2 text-uppercase small">Agent</span>
            <div class="d-flex justify-content-center gap-2 mt-2">
              <button class="btn btn-sm btn-outline-info" @click="viewUser(user)"><i class="fas fa-eye"></i></button>
              <button class="btn btn-sm btn-outline-warning" @click="editUser(user)"><i class="fas fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(user)"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>
        <div v-if="agents.length === 0" class="text-muted ps-3">Aucun agent.</div>
      </div>
    </div>
    <!-- Section CLIENT -->
    <div class="user-section mb-5">
      <h3 class="section-title client mb-4"><i class="fas fa-user me-2"></i> Clients</h3>
      <div class="row">
        <div v-for="user in clients" :key="user.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card-user shadow-sm p-3 text-center animate__animated animate__fadeIn">
            <i class="fas fa-user text-info role-icon mb-3"></i>
            <h5 class="mb-1">{{ user.name }}</h5>
            <p class="mb-1 text-muted">{{ user.email }}</p>
            <span class="badge bg-info mb-2 text-uppercase small">Client</span>
            <div class="d-flex justify-content-center gap-2 mt-2">
              <button class="btn btn-sm btn-outline-info" @click="viewUser(user)"><i class="fas fa-eye"></i></button>
              <button class="btn btn-sm btn-outline-warning" @click="editUser(user)"><i class="fas fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(user)"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>
        <div v-if="clients.length === 0" class="text-muted ps-3">Aucun client.</div>
      </div>
    </div>
    <div v-if="!filteredUsers.length" class="text-center text-muted py-5 fs-5">
      <i class="fas fa-users-slash fa-3x mb-3"></i>
      <p>Aucun utilisateur à afficher.</p>
    </div>
    <!-- Modales -->
    <ModalAjouterUtilisateur v-if="showModal" :roles="roles" @ajouter="addUser" @fermer="closeModal" />
    <ModalVoirUtilisateur v-if="modalVoir" :utilisateur="utilisateurSelectionne" @fermer="modalVoir = false" />
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
import { ref, onMounted, computed } from 'vue'
import { UserPlus } from 'lucide-vue-next'
import ModalAjouterUtilisateur from '@/components/utilisateurs/ModalAjouterUtilisateur.vue'
import ModalVoirUtilisateur from '@/components/utilisateurs/ModalVoirUtilisateur.vue'
import ModalModifierUtilisateur from '@/components/utilisateurs/ModalModifierUtilisateur.vue'
import ModalSupprimerUtilisateur from '@/components/utilisateurs/ModalSupprimerUtilisateur.vue'
import { usersApi } from '../../utils/apiResources'
const utilisateurs = ref([])
const loading = ref(true)
const error = ref('')
const recherche = ref('')
const roles = ['Administrateur', 'Agent', 'Client']
const selectedRole = ref('')
const searchQuery = ref('')
const showModal = ref(false)
const utilisateurSelectionne = ref(null)
const modalVoir = ref(false)
const modalModifier = ref(false)
const modalSupprimer = ref(false)
const chargerUtilisateurs = async () => {
  loading.value = true
  try {
    const response = recherche.value
      ? await usersApi.search(recherche.value)
      : await usersApi.list()
    utilisateurs.value = response.data
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement des utilisateurs'
  } finally {
    loading.value = false
  }
}
onMounted(chargerUtilisateurs)
const filteredUsers = computed(() =>
  utilisateurs.value.filter(user => {
    const matchesRole = !selectedRole.value || user.role === selectedRole.value
    const matchesSearch = !searchQuery.value || user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    return matchesRole && matchesSearch
  })
)
const admins = computed(() => filteredUsers.value.filter(u => u.role === 'Administrateur' || u.role === 'admin'))
const agents = computed(() => filteredUsers.value.filter(u => u.role === 'Agent' || u.role === 'agent'))
const clients = computed(() => filteredUsers.value.filter(u => u.role === 'Client' || u.role === 'client'))
const openAddUserModal = () => { showModal.value = true }
const closeModal = () => { showModal.value = false }
const addUser = async (user) => { try { const response = await usersApi.create(user); utilisateurs.value.push(response.data); closeModal() } catch (err) { error.value = err.response?.data?.message || 'Erreur lors de l\'ajout de l\'utilisateur' } }
const viewUser = (user) => { utilisateurSelectionne.value = user; modalVoir.value = true }
const editUser = (user) => { utilisateurSelectionne.value = { ...user }; modalModifier.value = true }
const confirmDelete = (user) => { utilisateurSelectionne.value = user; modalSupprimer.value = true }
const deleteUser = async (id) => { try { await usersApi.remove(id); utilisateurs.value = utilisateurs.value.filter(u => u.id !== id); modalSupprimer.value = false } catch (err) { error.value = err.response?.data?.message || 'Erreur lors de la suppression de l\'utilisateur' } }
const handleUpdate = async (updatedUser) => { try { const response = await usersApi.update(updatedUser.id, updatedUser); const index = utilisateurs.value.findIndex(u => u.id === updatedUser.id); if (index !== -1) utilisateurs.value[index] = response.data; modalModifier.value = false } catch (err) { error.value = err.response?.data?.message || 'Erreur lors de la mise à jour de l\'utilisateur' } }
</script>
<style scoped>
.section-title.admin { color: #2a7de1; }
.section-title.agent { color: #198754; }
.section-title.client { color: #0dcaf0; }
.card-user {
  background-color: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.25s ease-in-out;
}
.card-user:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.1);
}
.role-icon {
  font-size: 2.2rem;
}
.page {
  background: #f8f9fa;
}
.action-bar {
  border-radius: 10px;
  position: sticky;
  top: 10px;
  z-index: 10;
}
.search-container {
  position: relative;
}
.search-icon {
  position: absolute;
  top: 50%;
  left: 1rem;
  transform: translateY(-50%);
  color: #888;
}
.form-control {
  border-radius: 10px;
  padding-left: 2.5rem;
  transition: border-color 0.2s;
}
.card-user {
  background-color: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.25s ease-in-out;
}
.card-user:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.1);
}
.role-icon {
  font-size: 2.2rem;
}
</style>
