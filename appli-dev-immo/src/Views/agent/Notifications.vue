<template>
  <div>
    <h1>Notifications</h1>
    <div v-if="chargement" class="text-muted">Chargement...</div>
    <div v-else-if="erreur" class="alert alert-danger">{{ erreur }}</div>
    <ul class="list-group mb-3">
      <li v-for="notif in notifications" :key="notif.id" class="list-group-item d-flex justify-content-between align-items-center" :class="{ 'bg-light': !notif.lue }">
        <span>
          <strong v-if="!notif.lue" class="badge bg-warning me-2">Nouveau</strong>
          {{ notif.titre || 'Notification' }}<br />
          <small class="text-muted">{{ notif.contenu }}</small>
          <small class="text-muted ms-2">{{ formatDate(notif.created_at) }}</small>
        </span>
        <div class="d-flex gap-2 align-items-center">
          <button v-if="!notif.lue" class="btn btn-sm btn-outline-success" @click="marquerLue(notif.id)">Marquer comme lue</button>
          <button class="btn btn-sm btn-outline-danger" @click="supprimerNotification(notif.id)"><i class="fas fa-trash"></i></button>
        </div>
      </li>
      <li v-if="!notifications.length" class="list-group-item text-muted">Aucune notification.</li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { notificationsApi } from '../../utils/apiResources'

const notifications = ref([])
const chargement = ref(false)
const erreur = ref('')

async function supprimerNotification(id) {
  if (!confirm('Supprimer cette notification ?')) return
  try {
    await notificationsApi.remove(id)
    await chargerNotifications()
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors de la suppression'
  }
}

function formatDate(dateStr) {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleString('fr-FR', { dateStyle: 'short', timeStyle: 'short' })
}

async function chargerNotifications() {
  chargement.value = true
  try {
    const res = await notificationsApi.list()
    notifications.value = res.data
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors du chargement des notifications'
  } finally {
    chargement.value = false
  }
}

async function marquerLue(id) {
  try {
    await notificationsApi.markRead(id)
    await chargerNotifications()
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors de la mise à jour'
  }
}

onMounted(chargerNotifications)
</script>

<style scoped>
.list-group-item {
  font-size: 1.05rem;
}
.badge.bg-warning {
  font-size: 0.85em;
}
</style>

