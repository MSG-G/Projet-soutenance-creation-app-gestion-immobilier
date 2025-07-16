import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../utils/api'

export const useVillesStore = defineStore('villes', () => {
  const villes = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchVilles() {
    loading.value = true
    try {
      const res = await api.get('/villes')
      villes.value = res.data
    } catch (e) {
      error.value = e
    } finally {
      loading.value = false
    }
  }

  async function addVille(data) {
    loading.value = true
    try {
      await api.post('/villes', data)
      await fetchVilles()
    } catch (e) {
      error.value = e
      throw e
    } finally {
      loading.value = false
    }
  }

  async function deleteVille(id) {
    loading.value = true
    try {
      await api.delete(`/villes/${id}`)
      await fetchVilles()
    } catch (e) {
      error.value = e
      throw e
    } finally {
      loading.value = false
    }
  }

  return { villes, loading, error, fetchVilles, addVille, deleteVille }
}) 