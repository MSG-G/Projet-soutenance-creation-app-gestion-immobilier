<script setup>
import { ref } from 'vue'
import { photosApi } from '../../utils/apiResources'

const loading = ref(false)
const error = ref('')

const ajouterPhoto = async (formData) => {
  loading.value = true
  try {
    await photosApi.add(formData)
    // Rafraîchir la liste des photos si besoin
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de l\'ajout de la photo'
  } finally {
    loading.value = false
  }
}

const supprimerPhoto = async (id) => {
  loading.value = true
  try {
    await photosApi.remove(id)
    // Rafraîchir la liste des photos si besoin
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de la suppression de la photo'
  } finally {
    loading.value = false
  }
}
</script> 