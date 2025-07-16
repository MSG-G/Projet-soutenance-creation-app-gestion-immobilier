<template>
    <HeaderDash />
  <div class="detail-bien-page py-4">
    <div v-if="loading" class="text-center">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
      </div>
    </div>
    <div v-else-if="bien">
      <!-- Header visuel avec overlay et titre flottant -->
      <div class="header-bien position-relative animate__animated animate__fadeInDown">
        <img :src="bien.photos?.[0]?.url || '/img/placeholder-bien.jpg'" :alt="bien.titre || 'Photo bien'" class="header-img" />
        <div class="header-overlay"></div>
        <div class="header-content px-3 px-md-5">
          <div class="d-flex align-items-center gap-3 mb-2">
            <h1 class="bien-title mb-0">{{ bien.titre || bien.nom }}</h1>
            <span v-if="isNewBien" class="badge bg-gradient-pulse ms-2 animate__animated animate__pulse animate__infinite">Nouveau</span>
            <span class="badge ms-1" :class="{
              'bg-success': bien.statut === 'Disponible',
              'bg-secondary': bien.statut !== 'Disponible'
            }">
              <i v-if="bien.statut === 'Disponible'" class="fa fa-check-circle me-1"></i>
              <i v-else class="fa fa-ban me-1"></i>
              {{ bien.statut }}
            </span>
          </div>
          <div class="header-infos mt-2 d-flex flex-wrap gap-3">
            <div class="info-card animate__animated animate__fadeInLeft"><i class="fa fa-home"></i> {{ bien.type_bien?.nom || bien.type }}</div>
            <div class="info-card animate__animated animate__fadeInLeft animate__delay-1s"><i class="fa fa-map-marker-alt text-success"></i> {{ bien.adresse }}, {{ bien.ville?.nom || bien.ville }}</div>
            <div class="info-card animate__animated animate__fadeInLeft animate__delay-2s"><i class="fa fa-euro-sign text-warning"></i> {{ formatPrix(bien.prix) }} FCFA</div>
            <div class="info-card animate__animated animate__fadeInLeft animate__delay-3s"><i class="fa fa-ruler-combined text-info"></i> {{ bien.surface || '?' }} m²</div>
            <div class="info-card animate__animated animate__fadeInLeft animate__delay-4s"><i class="fa fa-th-large text-secondary"></i> {{ bien.nb_pieces || '?' }} pièces</div>
          </div>
        </div>
      </div>
      <!-- Galerie photo -->
      <div class="gallery-scroll animate__animated animate__fadeInUp" v-if="bien.photos && bien.photos.length > 1">
        <div class="gallery-track">
          <img v-for="photo in bien.photos" :src="photo.url" :alt="bien.titre" :key="photo.id" class="gallery-thumb" />
        </div>
      </div>
      <!-- Bloc description -->
      <div class="bien-desc card shadow animate__animated animate__fadeInUp animate__delay-1s">
        <h5><i class="fa fa-align-left me-2 text-gradient"></i>Description</h5>
        <p>{{ bien.description }}</p>
      </div>
      <!-- Bouton Réserver -->
      <button
  @click="onClickReservation"
  class="btn btn-gradient-glow w-100 my-4 animate__animated animate__pulse animate__infinite"
  :disabled="!bien || bien.statut !== 'Disponible' || !bien.id"
  :aria-disabled="!bien || bien.statut !== 'Disponible' || !bien.id"
  aria-label="Réserver une visite pour ce bien"
>
  <i class="fa fa-calendar-plus"></i> Réserver une visite
</button>
      <div v-if="showAlerte" class="alert alert-danger mt-2 animate__animated animate__shakeX">Ce bien n'est plus disponible à la réservation.</div>
    </div>
    <div v-if="error" class="alert alert-danger mt-3 animate__animated animate__shakeX">{{ error }}</div>
  </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/utils/api'

const route = useRoute()
const router = useRouter()
const bien = ref({})
const loading = ref(true)
const error = ref('')
const showAlerte = ref(false)

const fetchBien = async () => {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get(`/biens/${route.params.id}`)
    bien.value = res.data
  } catch (e) {
    error.value = "Erreur lors du chargement du bien."
  } finally {
    loading.value = false
  }
}

onMounted(fetchBien)

function onClickReservation() {
  if (!bien.value || !bien.value.id) {
    error.value = "Bien introuvable ou données incomplètes.";
    return;
  }
  if (bien.value.statut !== 'Disponible') {
    showAlerte.value = true;
    return;
  }
  showAlerte.value = false;
  try {
    router.push({ name: 'ReservationForm', query: { bienId: bien.value.id } });
  } catch (e) {
    error.value = "Erreur lors de la redirection vers la réservation.";
  }
}
function formatPrix(prix) {
  return prix ? Number(prix).toLocaleString() : ''
}
// Bien récent : moins de 30 jours depuis created_at
const isNewBien = computed(() => {
  if (!bien.value.created_at) return false
  const now = new Date()
  const created = new Date(bien.value.created_at)
  const diff = (now - created) / (1000 * 60 * 60 * 24)
  return diff <= 30
})
import HeaderDash from '@/components/HeaderDash.vue';
</script>

<style scoped>
.detail-bien-page {
  min-height: 80vh;
  background: linear-gradient(135deg,#f8f9ff 60%,#e6eaff 100%);
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(60,60,180,0.05);
  overflow-x: hidden;
}
.header-bien {
  position: relative;
  margin-bottom: 2.5rem;
  border-radius: 18px;
  overflow: hidden;
  min-height: 260px;
  box-shadow: 0 8px 32px #7c4dff22;
}
.header-img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  /* filter: brightness(0.92) saturate(1.1); */
  border-radius: 18px;
  z-index: 1;
}
.header-overlay {
  position: absolute;
  left: 0; top: 0; width: 100%; height: 100%;
  background: linear-gradient(90deg,rgba(63,81,181,0.7) 0%,rgba(124,77,255,0.45) 100%);
  pointer-events: none;
  z-index: 2;
}
.header-content {
  position: absolute;
  top: 0; left: 0; width: 100%; height: 100%;
  z-index: 3;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding-bottom: 2.2rem;
  color: #fff;
  text-shadow: 0 2px 8px #3f51b5aa;
}
.bg-gradient-pulse {
  background: linear-gradient(90deg,#ffeb3b,#ff9800,#7c4dff,#3f51b5);
  background-size: 200% 200%;
  animation: gradientPulse 2.5s linear infinite;
  color: #fff;
  border: none;
  box-shadow: 0 0 10px #ffeb3b88;
}
@keyframes gradientPulse {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.header-infos .info-card {
  background: rgba(255,255,255,0.13);
  border-radius: 12px;
  box-shadow: 0 2px 12px #7c4dff11;
  padding: 0.55rem 1.1rem;
  font-size: 1.06rem;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 0.6em;
  transition: transform .13s, box-shadow .18s;
}
.header-infos .info-card:hover {
  transform: translateY(-3px) scale(1.04);
  box-shadow: 0 4px 20px #7c4dff33;
}
.gallery-scroll {
  overflow-x: auto;
  margin-bottom: 1.2rem;
  padding-bottom: 0.3rem;
}
.gallery-track {
  display: flex;
  gap: 12px;
  padding-left: 2px;
}
.gallery-thumb {
  width: 90px;
  height: 64px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid #e6eaff;
  cursor: pointer;
  transition: box-shadow .18s, transform .15s;
  box-shadow: 0 1px 8px #7c4dff22;
}
.gallery-thumb:hover {
  box-shadow: 0 4px 16px #7c4dff99;
  transform: scale(1.08) rotate(-1deg);
}
.bien-title {
  font-size: 2.3rem;
  font-weight: 800;
  background: linear-gradient(90deg,#fff,#ffe082,#7c4dff 80%);
  /* -webkit-background-clip: text; */
  -webkit-text-fill-color: transparent;
  text-shadow: 0 2px 8px #3f51b5aa;
  letter-spacing: 1px;
}
.bien-desc {
  background: linear-gradient(135deg,#fff 80%,#e6eaff 100%);
  border-radius: 14px;
  box-shadow: 0 2px 18px #7c4dff22;
  padding: 1.2rem 1.5rem;
  margin-bottom: 1.7rem;
  color: #3f3f4f;
  font-size: 1.08rem;
}
.text-gradient {
  background: linear-gradient(90deg,#3f51b5,#7c4dff,#ff9800);
  /* -webkit-background-clip: text; */
  -webkit-text-fill-color: transparent;
}
.btn-gradient-glow {
  background: linear-gradient(90deg,#ff9800,#7c4dff,#3f51b5);
  color: #fff;
  border: none;
  font-weight: 700;
  font-size: 1.18rem;
  box-shadow: 0 0 16px #7c4dff44, 0 2px 20px #ff980044;
  border-radius: 10px;
  transition: box-shadow .18s, background .18s;
}
.btn-gradient-glow:hover {
  background: linear-gradient(90deg,#3f51b5,#7c4dff,#ff9800);
  box-shadow: 0 0 32px #7c4dff77, 0 2px 32px #ff980077;
}
@media (max-width: 768px) {
  .header-bien, .header-img { height: 160px !important; min-height: 160px !important; }
  .header-content { padding-bottom: 1.1rem; }
  .bien-title { font-size: 1.3rem; }
  .gallery-thumb { width: 58px; height: 38px; }
  .bien-desc { padding: 0.8rem 0.7rem; }
}

.main-bien-img {
  max-width: 320px;
  max-height: 220px;
  border-radius: 14px;
  object-fit: cover;
  box-shadow: 0 2px 18px rgba(60,60,180,0.10);
}
.gallery-thumb {
  width: 60px;
  height: 44px;
  object-fit: cover;
  border-radius: 6px;
  border: 1.5px solid #e6eaff;
  cursor: pointer;
  transition: box-shadow .18s;
}
.gallery-thumb:hover {
  box-shadow: 0 2px 8px #7c4dff44;
}
.bien-title {
  font-size: 2rem;
  font-weight: 700;
  background: linear-gradient(90deg,#3f51b5,#7c4dff);
  /* -webkit-background-clip: text; */
  -webkit-text-fill-color: transparent;
}
.bien-desc {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px #e6eaff88;
  padding: 1rem;
}
.btn-gradient {
  background: linear-gradient(90deg,#3f51b5,#7c4dff);
  color: #fff;
  border: none;
  transition: background .18s;
}
.btn-gradient:hover {
  background: linear-gradient(90deg,#7c4dff,#3f51b5);
}
</style>
