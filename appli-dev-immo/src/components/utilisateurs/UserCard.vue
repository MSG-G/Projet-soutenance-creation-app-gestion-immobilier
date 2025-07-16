<template>
  <div :class="['card', 'user-card', `border-${color}`]">
    <div class="card-body">
      <h5 class="card-title mb-1">{{ user.name }}</h5>
      <span class="badge" :class="`bg-${color}`">{{ user.role }}</span>
      <p class="card-text text-muted small mb-0">{{ user.email }}</p>
    </div>
    <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2">
      <button @click="$emit('voir', user)" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button>
      <button @click="$emit('edit', user)" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
      <button @click="$emit('delete', user)" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
    </div>
  </div>
</template>
<script setup>
defineProps({ user: Object, color: String })
</script>
<style scoped>
.user-card { border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: #fff; transition: all 0.25s; }
.user-card:hover { transform: translateY(-5px); box-shadow: 0 10px 24px rgba(0,0,0,0.1); }
.badge { font-size: 0.85em; font-weight: 600; padding: 0.35em 0.8em; border-radius: 1em; }
</style> 