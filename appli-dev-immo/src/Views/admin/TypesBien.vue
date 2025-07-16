<template>
  <div class="container py-4">
    <h2 class="mb-4 fw-semibold">Gestion des types de bien</h2>
    <div class="d-flex gap-2 mb-3 align-items-center">
      <input v-model="recherche" type="search" class="form-control w-auto" placeholder="Rechercher un type..." style="max-width: 260px;" />
      <button class="btn btn-success ms-auto" @click="ouvrirFormulaire()"><i class="fas fa-plus me-1"></i> Nouveau type</button>
    </div>
    <div v-if="erreur" class="alert alert-danger">{{ erreur }}</div>
    <div v-if="loading" class="text-center my-4"><span class="spinner-border"></span></div>
    <div v-if="!loading && typesFiltrees.length" class="row g-3">
  <div class="col-12 col-md-6 col-lg-4" v-for="type in typesFiltrees" :key="type.id">
    <TypeBienCard :typeBien="type" @show="voirTypeBien" @edit="ouvrirFormulaire" />
    <div class="mt-2 d-flex gap-2">
      <button class="btn btn-sm btn-outline-danger" @click="confirmerSuppression(type)"><i class="fas fa-trash"></i></button>
    </div>
  </div>
</div>
    <div v-else-if="!loading" class="alert alert-warning text-center">Aucun type trouvé.</div>
    <ModalTypeBien :visible="formulaireVisible" :typeBien="typeEdit" @close="fermerFormulaire" @saved="refreshTypes" />
    <ModalVoirTypeBien :visible="voirTypeBienVisible" :typeBien="typeBienAConsulter" @close="voirTypeBienVisible = false" />
    <ModalVoirBiensType :visible="voirBiensTypeVisible" :typeBien="typeBienSelectionne" @close="voirBiensTypeVisible = false" />
    <ModalConfirmation :visible="suppressionVisible" :message="`Supprimer le type '${typeSuppression?.nom}' ?`" @confirmer="supprimerType" @annuler="suppressionVisible = false" :loading="suppressionLoading" />
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import { useTypesBienStore } from '../../stores/useTypesBienStore'
import TypeBienCard from '../../components/biens/TypeBienCard.vue'
import ModalVoirTypeBien from '../../components/biens/ModalVoirTypeBien.vue'
import ModalVoirBiensType from '../../components/biens/ModalVoirBiensType.vue'
import ModalTypeBien from '../../components/biens/ModalTypeBien.vue'
import ModalConfirmation from '../../components/ui/ModalConfirmation.vue'

const store = useTypesBienStore()
const loading = ref(false)
const erreur = ref('')
const recherche = ref('')
const formulaireVisible = ref(false)
const typeEdit = ref(null)
const suppressionVisible = ref(false)
const typeSuppression = ref(null)
const suppressionLoading = ref(false)
const voirTypeBienVisible = ref(false)
const typeBienAConsulter = ref(null)
const voirBiensTypeVisible = ref(false)
const typeBienSelectionne = ref(null)

const typesFiltrees = computed(() => {
  return store.typesBien.filter(t =>
    t.nom.toLowerCase().includes(recherche.value.toLowerCase()) ||
    (t.description || '').toLowerCase().includes(recherche.value.toLowerCase())
  )
})

function ouvrirFormulaire(type = null) {
  typeEdit.value = type ? { ...type } : null
  formulaireVisible.value = true
}

function voirTypeBien(type) {
  typeBienAConsulter.value = type
  voirTypeBienVisible.value = true
}

function afficherBiensType(type) {
  typeBienSelectionne.value = type
  voirBiensTypeVisible.value = true
}
function fermerFormulaire() {
  formulaireVisible.value = false
  typeEdit.value = null
}
async function refreshTypes() {
  await store.fetchTypesBien()
  fermerFormulaire()
}
function confirmerSuppression(type) {
  typeSuppression.value = type
  suppressionVisible.value = true
}
async function supprimerType() {
  suppressionLoading.value = true
  try {
    await store.deleteTypeBien(typeSuppression.value.id)
    suppressionVisible.value = false
    typeSuppression.value = null
    await store.fetchTypesBien()
  } catch (e) {
    erreur.value = e?.response?.data?.message || 'Erreur lors de la suppression.'
  } finally {
    suppressionLoading.value = false
  }
}
onMounted(store.fetchTypesBien)
</script> 