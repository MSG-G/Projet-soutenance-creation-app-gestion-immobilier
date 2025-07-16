<template>
  <div class="container-fluid p-4 admin-dashboard">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <div>
        <h2 class="text-primary fw-bold">Gestion des locataires</h2>
        <p class="text-muted fs-6">Liste des locataires et leurs biens associés</p>
      </div>
      <button @click="openAddLocataireModal" class="btn btn-primary btn-lg shadow-sm">
        <i class="fas fa-user-plus me-2"></i> Ajouter un locataire
      </button>
    </div>
    <div class="filter-section mb-4 d-flex flex-wrap align-items-center gap-3">
      <input
        v-model="searchQuery"
        type="search"
        class="form-control shadow-sm"
        placeholder="Rechercher un locataire..."
        style="max-width: 300px;"
      />
    </div>
    <div v-if="loading" class="text-center py-5">
      <span class="spinner-border text-primary"></span>
    </div>
    <div v-else>
      <div v-if="locataires.length === 0" class="text-muted text-center py-5">
        Aucun locataire trouvé.
      </div>
      <div class="row">
        <div v-for="locataire in filteredLocataires" :key="locataire.id" class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="card shadow-sm p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-user text-info fa-2x me-3"></i>
              <div>
                <h5 class="mb-0">{{ locataire.name }}</h5>
                <div class="text-muted small">{{ locataire.email }}</div>
                <span class="badge bg-info text-uppercase small">Locataire</span>
              </div>
            </div>
            <div class="mt-2 mb-2">
              <strong>Biens associés :</strong>
              <ul class="list-group list-group-flush mt-1">
                <li v-for="bien in locataire.biens" :key="bien.id" class="list-group-item px-0 py-1">
                  <i class="fas fa-home me-2 text-primary"></i>{{ bien.titre }} <span class="text-muted small">({{ bien.statut }})</span>
                </li>
                <li v-if="!locataire.biens || locataire.biens.length === 0" class="text-muted small">Aucun bien associé</li>
              </ul>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-2">
              <button class="btn btn-sm btn-outline-info" @click="viewLocataire(locataire)"><i class="fas fa-eye"></i></button>
              <button class="btn btn-sm btn-outline-warning" @click="editLocataire(locataire)"><i class="fas fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(locataire)"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modales -->
    <ModalAjouterUtilisateur v-if="showAddModal" :roles="['Client']" @ajouter="addLocataire" @fermer="closeAddModal" />
    <ModalVoirUtilisateur v-if="showViewModal" :utilisateur="selectedLocataire" @fermer="showViewModal = false" />
    <ModalModifierUtilisateur v-if="showEditModal" :utilisateur="selectedLocataire" :roles="['Client']" @update="handleUpdate" @fermer="showEditModal = false" />
    <ModalSupprimerUtilisateur v-if="showDeleteModal" :utilisateur="selectedLocataire" @confirm="deleteLocataire(selectedLocataire.id)" @cancel="showDeleteModal = false" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import ModalAjouterUtilisateur from '@/components/utilisateurs/ModalAjouterUtilisateur.vue'
import ModalVoirUtilisateur from '@/components/utilisateurs/ModalVoirUtilisateur.vue'
import ModalModifierUtilisateur from '@/components/utilisateurs/ModalModifierUtilisateur.vue'
import ModalSupprimerUtilisateur from '@/components/utilisateurs/ModalSupprimerUtilisateur.vue'
import { usersApi, biensApi } from '../../utils/apiResources'

const locataires = ref([])
const loading = ref(true)
const searchQuery = ref('')
const showAddModal = ref(false)
const showViewModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedLocataire = ref(null)

const fetchLocataires = async () => {
  loading.value = true
  try {
    const usersRes = await usersApi.list()
    // Filtrer les clients (locataires)
    const clients = usersRes.data.filter(u => u.role === 'client' || u.role === 'Client')
    // Charger les biens associés pour chaque locataire (via contrats ou réservation, ici simplifié)
    for (const client of clients) {
      // On suppose une API biensApi.list({ client_id: client.id }) ou on filtre côté client
      const biensRes = await biensApi.list()
      client.biens = biensRes.data.filter(b => b.contrats && b.contrats.some(c => c.client_id === client.id))
    }
    locataires.value = clients
  } catch (err) {
    // Gérer l'erreur
    locataires.value = []
  } finally {
    loading.value = false
  }
}
onMounted(fetchLocataires)

const filteredLocataires = computed(() => {
  if (!searchQuery.value) return locataires.value
  return locataires.value.filter(l => l.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || l.email?.toLowerCase().includes(searchQuery.value.toLowerCase()))
})

const openAddLocataireModal = () => { showAddModal.value = true }
const closeAddModal = () => { showAddModal.value = false }
const addLocataire = async (user) => { try { await usersApi.create({ ...user, role: 'client' }); fetchLocataires(); closeAddModal() } catch (e) {} }
const viewLocataire = (locataire) => { selectedLocataire.value = locataire; showViewModal.value = true }
const editLocataire = (locataire) => { selectedLocataire.value = { ...locataire }; showEditModal.value = true }
const confirmDelete = (locataire) => { selectedLocataire.value = locataire; showDeleteModal.value = true }
const deleteLocataire = async (id) => { try { await usersApi.remove(id); fetchLocataires(); showDeleteModal.value = false } catch (e) {} }
const handleUpdate = async (updatedUser) => { try { await usersApi.update(updatedUser.id, updatedUser); fetchLocataires(); showEditModal.value = false } catch (e) {} }
</script>

<style scoped>
.card {
  border-radius: 14px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.25s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.1);
}
</style> 