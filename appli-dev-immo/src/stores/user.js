import { defineStore } from 'pinia'
import api from '../utils/api'

function getValidUser() {
  const user = JSON.parse(localStorage.getItem('user'))
  if (!user || !user.role) return null
  return user
}

export const useUserStore = defineStore('user', {
  state: () => ({
    user: getValidUser()
  }),
  actions: {
    async login(email, password) {
      try {
        const response = await api.post(
          '/login',
          { email, password },
          { headers: { 'Content-Type': 'application/json' } }
        )
        const { user, token } = response.data;
        const userData = { ...user, token };
        this.user = userData
        localStorage.setItem('user', JSON.stringify(userData))
        return userData
      } catch (error) {
        throw error.response?.data?.message || 'Erreur de connexion'
      }
    },

    async register(name, email, password, phone) {
      try {
        const response = await api.post('/register', {
          name,
          email,
          password,
          password_confirmation: password, // Le backend attend une confirmation
          phone
        });
        const { user, token } = response.data;
        const userData = { ...user, token };
        this.user = userData;
        localStorage.setItem('user', JSON.stringify(userData));
        return userData;
      } catch (error) {
        throw error.response?.data?.message || 'Erreur lors de l`inscription';
      }
    },

    setUser(user) {
      this.user = user
      localStorage.setItem('user', JSON.stringify(user))
    },
    logout() {
      this.user = null
      localStorage.removeItem('user')
    }
  }
})
 