<template>
  <div style="height: 250px;">
    <Bar :data="donneesGraphique" :options="optionsGraphique" />
  </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
)

defineProps({
  donneesGraphique: Object,
  optionsGraphique: Object
})
</script>
