import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'

import '@fortawesome/fontawesome-free/css/all.min.css'

// Simuler un user connecté (pour test)
localStorage.setItem('user', JSON.stringify({ nom: 'Coumba', role: 'admin' })) // ou 'agent'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.mount('#app')
