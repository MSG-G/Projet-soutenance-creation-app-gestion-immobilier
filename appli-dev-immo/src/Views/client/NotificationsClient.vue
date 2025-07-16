<template>
    <HeaderDash />
  <div>
    <h1>Notifications</h1>
    <div v-if="loading">Chargement...</div>
    <ul v-else>
      <li v-for="notif in notifications" :key="notif.id">
        {{ notif.message }} <span v-if="!notif.lue" style="color:orange;">(non lue)</span>
      </li>
    </ul>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/utils/api'

const notifications = ref([])
const loading = ref(true)
const error = ref('')

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get('/client/notifications')
    notifications.value = res.data
  } catch (e) {
    error.value = 'Erreur lors du chargement des notifications.'
  } finally {
    loading.value = false
  }
})
import HeaderDash from '@/components/HeaderDash.vue';
</script>

<style scoped>
.error { color: red; margin-top: 1rem; }
</style>
