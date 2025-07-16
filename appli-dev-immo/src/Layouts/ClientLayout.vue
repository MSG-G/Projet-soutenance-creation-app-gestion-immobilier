<template>
  <div class="barrehaut">
    <SidebarClient />
    <div class="main-contenu">
      <div class="page-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import SidebarClient from '@/components/SidebarClient.vue'
</script>

<style scoped>
.barrehaut {
  display: flex;
  height: 100vh;
  overflow: hidden;
}
.main-contenu {
  display: flex;
  flex-direction: column;
  width: calc(100% - 260px);
  margin-left: 260px;
  height: 100vh;
}
.page-content {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
  background-color: #f9f9f9;
}
</style>
