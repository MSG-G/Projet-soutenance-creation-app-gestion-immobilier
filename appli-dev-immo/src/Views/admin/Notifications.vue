<script setup>
import { ref, onMounted } from 'vue'
import { notificationsApi } from '../../utils/apiResources'

const notifications = ref([])
const loading = ref(true)
const error = ref('')

const chargerNotifications = async () => {
  loading.value = true
  try {
    const response = await notificationsApi.list()
    notifications.value = response.data
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement des notifications'
  } finally {
    loading.value = false
  }
}

const marquerCommeLue = async (id) => {
  try {
    await notificationsApi.markRead(id)
    await chargerNotifications()
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du marquage comme lue'
  }
}

onMounted(chargerNotifications)
</script> 