<template>
    <HeaderDash />
  <div>
    <h1>Messagerie</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else>
      <ul>
        <li v-for="msg in messages" :key="msg.id">
          <strong>{{ msg.from }}</strong> : {{ msg.content }}
        </li>
      </ul>
      <form @submit.prevent="sendMessage">
        <input v-model="newMessage" placeholder="Votre message..." required />
        <button type="submit" :disabled="sending">Envoyer</button>
      </form>
      <div v-if="error" class="error">{{ error }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/utils/api'

const messages = ref([])
const newMessage = ref('')
const loading = ref(true)
const sending = ref(false)
const error = ref('')

onMounted(async () => {
  await fetchMessages()
})

const fetchMessages = async () => {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get('/client/messages')
    messages.value = res.data
  } catch (e) {
    error.value = 'Erreur lors du chargement des messages.'
  } finally {
    loading.value = false
  }
}

const sendMessage = async () => {
  if (!newMessage.value.trim()) return
  sending.value = true
  error.value = ''
  try {
    await api.post('/client/messages', { content: newMessage.value })
    newMessage.value = ''
    await fetchMessages()
  } catch (e) {
    error.value = 'Erreur lors de l\'envoi du message.'
  } finally {
    sending.value = false
  }
}
import HeaderDash from '@/components/HeaderDash.vue';
</script>

<style scoped>
.error { color: red; margin-top: 1rem; }
form { margin-top: 1rem; }
input { padding: 0.5rem; margin-right: 0.5rem; }
</style>
