<template>
  <div v-if="visible" class="modal-backdrop">
    <div class="modal-content" style="max-width:700px;min-width:320px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Biens du type <span class="text-primary">{{ typeBien?.nom }}</span></h4>
        <button class="btn-close" @click="$emit('close')"></button>
      </div>
      <div v-if="loading" class="text-center my-4"><span class="spinner-border"></span></div>
      <div v-else-if="biens.length" class="row g-3">
        <div class="col-12 col-md-6" v-for="bien in biens" :key="bien.id">
          <div class="card shadow-sm h-100">
            <img :src="bien.image || placeholderImage" alt="bien" class="img-fluid rounded-top" style="height:150px;object-fit:cover;" />
            <div class="card-body">
              <h5 class="card-title mb-1">{{ bien.titre }}</h5>
              <div class="mb-1 text-muted">{{ bien.description }}</div>
              <div><strong>Prix :</strong> {{ bien.prix ? Number(bien.prix).toLocaleString() : '' }} FCFA</div>
              <div><strong>Statut :</strong> {{ bien.statut }}</div>
              <div><strong>Ville :</strong> {{ bien.ville?.nom }}</div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="alert alert-info text-center">Aucun bien trouvé pour ce type.</div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { biensApi } from '../../utils/apiResources'
const props = defineProps({ visible: Boolean, typeBien: Object })
const emit = defineEmits(['close'])
const biens = ref([])
const loading = ref(false)
const placeholderImage = '/placeholder.jpg'

watch(() => [props.visible, props.typeBien], async ([visible, typeBien]) => {
  if (visible && typeBien && typeBien.id) {
    loading.value = true
    try {
      const res = await biensApi.list()
      biens.value = res.data.filter(b => b.type_bien?.id === typeBien.id || b.type_bien_id === typeBien.id)
    } catch {
      biens.value = []
    } finally {
      loading.value = false
    }
  } else if (!visible) {
    biens.value = []
  }
})
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  width: 100vw;
  min-height: 100vh;
  background: rgba(30, 41, 59, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  overflow-y: auto;
}
.modal-content {
  background: #fff;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  width: 100%;
  margin: 0 auto;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  position: relative;
  text-align: left;
}
.btn-close {
  background: none;
  border: none;
  font-size: 1.4rem;
  opacity: 0.7;
}
.btn-close:hover {
  opacity: 1;
}
</style>
