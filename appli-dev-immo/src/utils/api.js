import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // À adapter selon ton backend
  withCredentials: false // Important pour éviter l'erreur 419
})

// Ajout automatique du token Bearer si présent
api.interceptors.request.use(config => {
  const user = JSON.parse(localStorage.getItem('user'))
  if (user && user.token) {
    config.headers.Authorization = `Bearer ${user.token}`
  }
  return config
})

export default {
  get: (url, config = {}) => api.get(url, config),
  post: (url, data, config = {}) => api.post(url, data, config),
  put: (url, data, config = {}) => api.put(url, data, config),
  delete: (url, config = {}) => api.delete(url, config)
} 