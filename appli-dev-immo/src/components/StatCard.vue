<template>
  <div class="card-stats p-3 rounded bg-white shadow-sm w-100" style="border-left: 4px solid blue;">
    <h6>{{ titre }}</h6>
    <h4 class="fw-bold">{{ valeur }}</h4>
    <small :class="textClass">{{ variation }} par rapport au mois dernier</small>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  titre: { type: String, required: true },
  valeur: { type: [String, Number], required: true },
  variation: { type: String, required: false },
  type: String
})

const textClass = computed(() => {
  return props.type === 'success' ? 'text-success' : 'text-danger'
})
</script>


