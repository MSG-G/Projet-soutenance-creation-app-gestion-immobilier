<template>
    <div class="layout">
      <main class="page p-4">
  
        <!-- En-tête -->
        <div class="header mb-4">
          <h2 class="fw-semibold mb-1 text-primary">👤 Gestion des propriétaires</h2>
          <p class="text-muted mb-0">Consultez, ajoutez ou modifiez les informations des propriétaires.</p>
        </div>
  
        <!-- Barre d’actions -->
        <div class="action-bar sticky-top d-flex flex-wrap gap-3 align-items-center py-3 bg-white shadow-sm px-3 rounded mb-4">
          <div class="search-container position-relative flex-grow-1">
            <input
              v-model="recherche"
              class="form-control ps-5"
              placeholder="🔍 Rechercher un propriétaire..."
              @input="pageActuelle = 1"
            />
            <i class="fas fa-search search-icon"></i>
          </div>
  
          <button @click="resetRecherche" class="btn btn-light border shadow-sm" title="Réinitialiser">
            <i class="fas fa-sync-alt"></i>
          </button>
  
          <button @click="ouvrirFormulaire()" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Ajouter
          </button>
        </div>
  
        <!-- États -->
        <ErrorAlert v-if="erreur" :message="erreur" />
        <Loader v-if="chargement" />
  
        <!-- Affichage par section avec cartes animées -->
        <div v-if="!chargement && proprietairesFiltres.length">
          <div v-for="(groupe, index) in groupes" :key="index" class="mb-5">
            <div class="col-12">
              <h4 class="section-title">
                <i :class="groupe.icone + ' me-2'" :style="{ color: groupe.couleur }"></i> {{ groupe.titre }}
              </h4>
            </div>
            <div class="row">
              <div
                v-for="p in groupe.liste"
                :key="p.id"
                class="col-12 col-md-6 col-lg-4 mb-4"
              >
                <div class="card-proprio animated-card shadow-sm p-4 d-flex flex-column align-items-center">
                  <i :class="groupe.icone + ' fa-2x mb-2'" :style="{ color: groupe.couleur }"></i>
                  <h5 class="mb-1">{{ p.nom }} {{ p.prenom }}</h5>
                  <p class="mb-1 text-muted">{{ p.email }}</p>
                  <p class="mb-1"><i class="fas fa-phone me-1"></i> {{ p.telephone }}</p>
                  <span class="badge" :style="{ backgroundColor: groupe.couleur }">{{ groupe.role }}</span>
                  <div class="d-flex gap-2 mt-3">
                    <button @click="ouvrirFormulaire(p)" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>
                    <button @click="confirmerSuppression(p)" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else-if="!chargement" class="alert alert-warning text-center">Aucun propriétaire trouvé.</div>
  
        <!-- Modals -->
        <ModalProprietaire
          v-if="modalVisible"
          :proprietaire="proprietaireEdit"
          @fermer="fermerFormulaire"
          @enregistrer="handleEnregistrer"
        />
        <ModalConfirmation
          v-if="modalSuppressionVisible"
          :message="`Supprimer le propriétaire '${proprietaireSuppression?.nom}' ?`"
          @confirmer="supprimerProprietaire"
          @annuler="modalSuppressionVisible = false"
        />
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, watch } from 'vue'
  import Loader from '@/components/Loader.vue'
  import ErrorAlert from '@/components/ErrorAlert.vue'
  import ModalProprietaire from '@/components/proprietaires/ModalProprietaire.vue'
  import ModalConfirmation from '@/components/ui/ModalConfirmation.vue'
  import { proprietairesApi } from '../../utils/apiResources'
  
  const recherche = ref('')
  const proprietaires = ref([])
  const chargement = ref(false)
  const erreur = ref('')
  const pageActuelle = ref(1)
  const itemsParPage = 10
  const modalVisible = ref(false)
  const modalSuppressionVisible = ref(false)
  const proprietaireEdit = ref(null)
  const proprietaireSuppression = ref(null)
  
  const chargerProprietaires = async () => {
    chargement.value = true
    try {
      const response = recherche.value
        ? await proprietairesApi.search(recherche.value)
        : await proprietairesApi.list()
      proprietaires.value = response.data
    } catch (err) {
      erreur.value = err.response?.data?.message || 'Erreur lors du chargement des propriétaires'
    } finally {
      chargement.value = false
    }
  }
  
  const proprietairesFiltres = computed(() =>
    proprietaires.value.filter(p =>
      p.nom.toLowerCase().includes(recherche.value.toLowerCase())
    )
  )
  
  const groupes = computed(() => [
    {
      role: 'Admin',
      titre: 'Administrateurs',
      icone: 'fas fa-user-shield',
      couleur: '#0d6efd',
      liste: proprietairesFiltres.value.filter(p => p.role === 'admin')
    },
    {
      role: 'Agent',
      titre: 'Agents',
      icone: 'fas fa-user-tie',
      couleur: '#198754',
      liste: proprietairesFiltres.value.filter(p => p.role === 'agent')
    },
    {
      role: 'Client',
      titre: 'Clients',
      icone: 'fas fa-user',
      couleur: '#6c757d',
      liste: proprietairesFiltres.value.filter(p => !p.role || p.role === 'client')
    }
  ])
  
  function ouvrirFormulaire(p = null) {
    proprietaireEdit.value = p ? { ...p } : null
    modalVisible.value = true
  }
  function fermerFormulaire() {
    modalVisible.value = false
  }
  async function handleEnregistrer(p) {
    if (p.id) {
      await proprietairesApi.update(p.id, p)
    } else {
      await proprietairesApi.create(p)
    }
    fermerFormulaire()
    await chargerProprietaires()
  }
  function confirmerSuppression(p) {
    proprietaireSuppression.value = p
    modalSuppressionVisible.value = true
  }
  async function supprimerProprietaire() {
    await proprietairesApi.remove(proprietaireSuppression.value.id)
    modalSuppressionVisible.value = false
    await chargerProprietaires()
  }
  function resetRecherche() {
    recherche.value = ''
    pageActuelle.value = 1
  }
  onMounted(chargerProprietaires)
  watch(recherche, () => (pageActuelle.value = 1))
  </script>
  
  <style scoped>
  .page {
    background-color: #f9fafc;
  }
  .action-bar {
    border-radius: 10px;
    position: sticky;
    top: 10px;
    z-index: 999;
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
    transition: all 0.2s ease-in-out;
  }
  .section-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
  }
  .card-proprio {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    min-height: 260px;
    text-align: center;
  }
  .card-proprio:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
  }
  .animated-card {
    animation: fadeInUp 0.6s ease;
  }
  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(20px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
  </style>
  