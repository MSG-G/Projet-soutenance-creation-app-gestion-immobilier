import { defineStore } from 'pinia'

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
 