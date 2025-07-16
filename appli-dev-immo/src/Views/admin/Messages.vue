<template>
  <div>
    <h1>Messages</h1>
    <div v-if="loading">Chargement des messages...</div>
    <div v-if="error">{{ error }}</div>
    <div v-if="messages.length === 0">Aucun message trouvé.</div>
    <div v-else>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Contenu</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="message in messages" :key="message.id">
            <td>{{ message.id }}</td>
            <td>{{ message.content }}</td>
            <td>
              <button @click="supprimerMessage(message.id)">Supprimer</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { messagesApi } from '../../utils/apiResources'

const messages = ref([])
const loading = ref(true)
const error = ref('')

const chargerMessages = async () => {
  loading.value = true
  try {
    const response = await messagesApi.list()
    messages.value = response.data
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement des messages'
  } finally {
    loading.value = false
  }
}

const envoyerMessage = async (data) => {
  loading.value = true
  try {
    await messagesApi.send(data)
    await chargerMessages()
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de l\'envoi du message'
  } finally {
    loading.value = false
  }
}

const supprimerMessage = async (id) => {
  loading.value = true
  try {
    await messagesApi.remove(id)
    await chargerMessages()
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de la suppression du message'
  } finally {
    loading.value = false
  }
}

onMounted(chargerMessages)
</script> 