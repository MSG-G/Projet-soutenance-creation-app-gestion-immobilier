import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../utils/api'

export const useTypesBienStore = defineStore('typesBien', () => {
  const typesBien = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchTypesBien() {
    loading.value = true
    try {
      const res = await api.get('/types-bien')
      typesBien.value = res.data
    } catch (e) {
      error.value = e
    } finally {
      loading.value = false
    }
  }

  async function addTypeBien(data) {
    loading.value = true
    try {
      await api.post('/types-bien', data)
      await fetchTypesBien()
    } catch (e) {
      error.value = e
      throw e
    } finally {
      loading.value = false
    }
  }

  async function deleteTypeBien(id) {
    loading.value = true
    try {
      await api.delete(`/types-bien/${id}`)
      await fetchTypesBien()
    } catch (e) {
      error.value = e
      throw e
    } finally {
      loading.value = false
    }
  }

  async function updateTypeBien(id, data) {
    loading.value = true
    try {
      await api.put(`/types-bien/${id}`, data)
      await fetchTypesBien()
    } catch (e) {
      error.value = e
      throw e
    } finally {
      loading.value = false
    }
  }

  return { typesBien, loading, error, fetchTypesBien, addTypeBien, updateTypeBien, deleteTypeBien }
}) 