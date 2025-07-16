<template>
  <div>
    <h1>Messagerie</h1>
    <form class="d-flex mb-3 gap-2" @submit.prevent="envoyerMessage">
      <input v-model="nouveauMessage" class="form-control" placeholder="Votre message..." required />
      <button class="btn btn-primary" :disabled="envoiEnCours">Envoyer</button>
    </form>
    <div v-if="chargement" class="text-muted">Chargement...</div>
    <div v-else-if="erreur" class="alert alert-danger">{{ erreur }}</div>
    <ul class="list-group mb-3">
      <li v-for="msg in messages" :key="msg.id" class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <strong>{{ msg.expediteur || 'Moi' }}</strong> : {{ msg.contenu }}
          <small class="text-muted ms-2">{{ formatDate(msg.created_at) }}</small>
        </span>
        <button class="btn btn-sm btn-outline-danger" @click="supprimerMessage(msg.id)"><i class="fas fa-trash"></i></button>
      </li>
      <li v-if="!messages.length" class="list-group-item text-muted">Aucun message.</li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { messagesApi } from '../../utils/apiResources'

const messages = ref([])
const chargement = ref(false)
const erreur = ref('')
const nouveauMessage = ref('')
const envoiEnCours = ref(false)

function formatDate(dateStr) {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleString('fr-FR', { dateStyle: 'short', timeStyle: 'short' })
}

async function chargerMessages() {
  chargement.value = true
  try {
    const res = await messagesApi.list()
    messages.value = res.data
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors du chargement des messages'
  } finally {
    chargement.value = false
  }
}

async function envoyerMessage() {
  if (!nouveauMessage.value.trim()) return
  envoiEnCours.value = true
  try {
    await messagesApi.send({ contenu: nouveauMessage.value })
    nouveauMessage.value = ''
    await chargerMessages()
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors de l\'envoi du message'
  } finally {
    envoiEnCours.value = false
  }
}

async function supprimerMessage(id) {
  if (!confirm('Supprimer ce message ?')) return
  try {
    await messagesApi.remove(id)
    await chargerMessages()
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors de la suppression'
  }
}

onMounted(chargerMessages)
</script>

<style scoped>
.list-group-item {
  font-size: 1.05rem;
}
form input.form-control {
  flex: 1 1 auto;
}
</style>

