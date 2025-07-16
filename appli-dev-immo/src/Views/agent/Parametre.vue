<template>
    <div :class="['settings-page', { dark: isDark }]">
      <div class="container py-4">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold mb-0">Paramètres</h2>
            <p class="text-muted">Gérez votre profil, sécurité et préférences</p>
          </div>
          <button @click="toggleDarkMode" class="btn btn-outline-secondary">
            <i :class="isDark ? 'fas fa-sun' : 'fas fa-moon'"></i>
            {{ isDark ? 'Mode clair' : 'Mode sombre' }}
          </button>
        </div>
  
        <!-- Photo de profil -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-light fw-semibold">Photo de profil</div>
          <div class="card-body d-flex align-items-center gap-3 flex-wrap">
            <img :src="profilePreview || defaultProfile" alt="Avatar" class="rounded-circle border" style="width: 90px; height: 90px; object-fit: cover;" />
            <div>
              <input type="file" @change="previewProfile" accept="image/*" class="form-control" />
              <small class="text-muted">Format recommandé : JPG, PNG (max 2 Mo)</small>
            </div>
          </div>
        </div>
  
        <!-- Préférences -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-light fw-semibold">Préférences générales</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Langue</label>
              <select v-model="langue" class="form-select">
                <option value="fr">Français</option>
                <option value="en">Anglais</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Notifications</label>
              <div class="form-check">
                <input type="checkbox" v-model="notifications" id="notif" class="form-check-input" />
                <label class="form-check-label" for="notif">Recevoir des notifications par e-mail</label>
              </div>
            </div>
            <button class="btn btn-primary" @click="sauvegarderPreferences">Sauvegarder</button>
          </div>
        </div>
  
        <!-- Sécurité -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-light fw-semibold">Sécurité</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Nouveau mot de passe</label>
              <input type="password" v-model="motDePasse" class="form-control" placeholder="********" />
            </div>
            <button class="btn btn-danger" @click="changerMotDePasse">Changer le mot de passe</button>
          </div>
        </div>
  
        <!-- Suppression de compte -->
        <div class="card shadow-sm mb-5">
          <div class="card-header bg-light fw-semibold text-danger">Supprimer mon compte</div>
          <div class="card-body">
            <p class="text-muted">Cette action est irréversible. Toutes vos données seront supprimées.</p>
            <button class="btn btn-outline-danger" @click="confirmerSuppression">Supprimer mon compte</button>
          </div>
        </div>
  
        <!-- Message de feedback -->
        <div v-if="message" class="alert alert-success mt-3 shadow-sm">
          <i class="fas fa-check-circle me-2"></i> {{ message }}
        </div>
        <div v-if="error" class="alert alert-danger mt-3 shadow-sm">
          <i class="fas fa-exclamation-triangle me-2"></i> {{ error }}
        </div>
      </div>
    </div>

</template>

<style scoped>
.settings-page {
  background-color: #f9fbfd;
  min-height: 100vh;
  transition: background-color 0.3s ease, color 0.3s ease;
  font-family: 'Inter', sans-serif;
}
.settings-page.dark {
  background-color: #1e1e2f;
  color: #f4f4f4;
}
.settings-page.dark .card {
  background-color: #2a2a3d;
  color: #e0e0e0;
  border: none;
}
.settings-page.dark .form-control,
.settings-page.dark .form-select {
  background-color: #3c3c50;
  color: #f0f0f0;
  border-color: #555;
}
.settings-page.dark .btn-outline-secondary {
  color: #f0f0f0;
  border-color: #888;
}
</style>


<script setup>
import { ref, onMounted } from 'vue'
import { usersApi } from '../../utils/apiResources'

// Récupère l'utilisateur connecté
let user = null
try {
  user = JSON.parse(localStorage.getItem('user'))
} catch (e) {}

const profil = ref({})
const loading = ref(false)
const error = ref('')
const message = ref('')
const isDark = ref(false)
const langue = ref('fr')
const notifications = ref(true)
const motDePasse = ref('')
const profilePreview = ref(null)
const defaultProfile = '/images/default-avatar.png'

// Charger le profil réel depuis l'API
const chargerProfil = async () => {
  if (!user || !user.id) return
  loading.value = true
  try {
    const response = await usersApi.get(user.id)
    profil.value = response.data
    // Préremplir les champs de préférences
    langue.value = profil.value.langue || 'fr'
    notifications.value = !!profil.value.notifications
    if (profil.value.photo) {
      profilePreview.value = profil.value.photo
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement du profil'
  } finally {
    loading.value = false
  }
}

// Sauvegarder les préférences réelles
const sauvegarderPreferences = async () => {
  if (!user || !user.id) return
  loading.value = true
  try {
    await usersApi.update(user.id, {
      langue: langue.value,
      notifications: notifications.value
    })
    message.value = 'Préférences mises à jour.'
    setTimeout(() => (message.value = ''), 3000)
    await chargerProfil()
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de la sauvegarde'
  } finally {
    loading.value = false
  }
}

// Changer le mot de passe (exemple basique)
const changerMotDePasse = async () => {
  if (!user || !user.id) return
  if (motDePasse.value.trim().length < 6) {
    alert('Le mot de passe doit contenir au moins 6 caractères.')
    return
  }
  loading.value = true
  try {
    await usersApi.update(user.id, { password: motDePasse.value })
    message.value = 'Mot de passe changé avec succès.'
    motDePasse.value = ''
    setTimeout(() => (message.value = ''), 3000)
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du changement de mot de passe'
  } finally {
    loading.value = false
  }
}

// Suppression de compte
const confirmerSuppression = async () => {
  if (!user || !user.id) return
  const confirmation = confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')
  if (!confirmation) return
  loading.value = true
  try {
    await usersApi.remove(user.id)
    alert('Compte supprimé. Déconnexion...')
    window.location.href = '/login'
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de la suppression du compte'
  } finally {
    loading.value = false
  }
}

// Gestion de la photo de profil (upload non inclus ici)
const previewProfile = (event) => {
  const file = event.target.files[0]
  if (file && file.type.startsWith('image/')) {
    profilePreview.value = URL.createObjectURL(file)
    // TODO : envoyer le fichier au backend si tu veux l'enregistrer
  }
}

onMounted(chargerProfil)
</script>

<style scoped>
.settings-page {
  background-color: #f9fbfd;
  min-height: 100vh;
  transition: background-color 0.3s ease, color 0.3s ease;
  font-family: 'Inter', sans-serif;
}
.settings-page.dark {
  background-color: #1e1e2f;
  color: #f4f4f4;
}
.settings-page.dark .card {
  background-color: #2a2a3d;
  color: #e0e0e0;
  border: none;
}
.settings-page.dark .form-control,
.settings-page.dark .form-select {
  background-color: #3c3c50;
  color: #f0f0f0;
  border-color: #555;
}
.settings-page.dark .btn-outline-secondary {
  color: #f0f0f0;
  border-color: #888;
}
</style>