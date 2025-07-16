<template>
  <div class="container py-4">
    <h2 class="mb-4 fw-semibold">Gestion des villes</h2>
    <div class="d-flex gap-2 mb-3 align-items-center">
      <input v-model="recherche" type="search" class="form-control w-auto" placeholder="Rechercher une ville..." style="max-width: 260px;" />
      <button class="btn btn-success ms-auto" @click="ouvrirFormulaire()"><i class="fas fa-plus me-1"></i> Nouvelle ville</button>
    </div>
    <div v-if="erreur" class="alert alert-danger">{{ erreur }}</div>
    <div v-if="loading" class="text-center my-4"><span class="spinner-border"></span></div>
    <div v-if="!loading && villesFiltrees.length" class="row g-3">
      <div class="col-12 col-md-6 col-lg-4" v-for="ville in villesFiltrees" :key="ville.id">
        <VilleCard :ville="ville" @voir="voirVille" />
        <div class="mt-2 d-flex gap-2">
          <button class="btn btn-sm btn-outline-primary" @click="ouvrirFormulaire(ville)"><i class="fas fa-edit"></i></button>
          <button class="btn btn-sm btn-outline-danger" @click="confirmerSuppression(ville)"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
    <div v-else-if="!loading" class="alert alert-warning text-center">Aucune ville trouvée.</div>
    <ModalVilleForm :visible="formulaireVisible" :ville="villeEdit" @close="fermerFormulaire" @saved="refreshVilles" />
    <ModalVoirVille :visible="voirVilleVisible" :ville="villeAConsulter" @fermer="voirVilleVisible = false" />
    <ModalConfirmation :visible="suppressionVisible" :message="`Supprimer la ville '${villeSuppression?.nom}' ?`" @confirmer="supprimerVille" @annuler="suppressionVisible = false" :loading="suppressionLoading" />
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import { useVillesStore } from '../../stores/useVillesStore'
import VilleCard from '../../components/biens/VilleCard.vue'
import ModalVoirVille from '../../components/biens/ModalVoirVille.vue'
import ModalVilleForm from '../../components/biens/ModalVille.vue'
import ModalConfirmation from '../../components/ui/ModalConfirmation.vue'

const store = useVillesStore()
const loading = ref(false)
const erreur = ref('')
const recherche = ref('')
const formulaireVisible = ref(false)
const villeEdit = ref(null)
const suppressionVisible = ref(false)
const villeSuppression = ref(null)
const suppressionLoading = ref(false)
const voirVilleVisible = ref(false)
const villeAConsulter = ref(null)

const villesFiltrees = computed(() => {
  return store.villes.filter(v =>
    v.nom.toLowerCase().includes(recherche.value.toLowerCase()) ||
    (v.region || '').toLowerCase().includes(recherche.value.toLowerCase()) ||
    (v.code_postal || '').toLowerCase().includes(recherche.value.toLowerCase())
  )
})

function ouvrirFormulaire(ville = null) {
  villeEdit.value = ville ? { ...ville } : null
  formulaireVisible.value = true
}

function voirVille(ville) {
  villeAConsulter.value = ville
  voirVilleVisible.value = true
}

function fermerFormulaire() {
  formulaireVisible.value = false
  villeEdit.value = null
}

async function refreshVilles() {
  await store.fetchVilles()
  fermerFormulaire()
}

function confirmerSuppression(ville) {
  villeSuppression.value = ville
  suppressionVisible.value = true
}
async function supprimerVille() {
  suppressionLoading.value = true
  try {
    await store.deleteVille(villeSuppression.value.id)
    suppressionVisible.value = false
    villeSuppression.value = null
    await store.fetchVilles()
  } catch (e) {
    erreur.value = e?.response?.data?.message || 'Erreur lors de la suppression.'
  } finally {
    suppressionLoading.value = false
  }
}
onMounted(store.fetchVilles)
</script> 