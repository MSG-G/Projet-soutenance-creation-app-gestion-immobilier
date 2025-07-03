<template>
  <div style="height: 250px;">
    <Line :data="donneesGraphique" :options="optionsGraphique" />
  </div>
</template>

<script setup>
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement
)

defineProps({
  donneesGraphique: Object,
  optionsGraphique: Object
})
</script>
