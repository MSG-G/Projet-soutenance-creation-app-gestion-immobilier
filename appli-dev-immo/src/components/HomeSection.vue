<template>
  <div class="container py-5">
    <div class="row align-items-center">
      <!-- Chiffres à gauche -->
      <div class="col-md-3 text-start pe-md-5 stat-column stat-left">
        <div v-for="(item, index) in leftStats" :key="index" class="mb-4 stat-item">
          <h3 class="stat-number">{{ animatedValues[index] }}+</h3>
          <p>{{ item.label }}</p>
        </div>
      </div>
      <!-- Texte central -->
      <div class="col-md-6 text-center">
        <h1 class="display-5 fw-bold text-dark mb-3">
          TROUVER LE BIEN IMMOBILIER DE VOS RÊVES
        </h1>
        <p class="mb-4">
          Explorez Des Milliers De Propriétés À Travers Le Pays  <strong class="text-primary">Dev-IMMO</strong> - Votre 
          Destination Immobiliére De Choix
        </p>
        <router-link to="/biens" class="btn btn-primary btn-lg">
          Trouver des propriétés
        </router-link>
      </div>
      <!-- Chiffres à droite -->
      <div class="col-md-3 text-end ps-md-5 stat-column stat-right">
        <div v-for="(item, index) in rightStats" :key="index + 2" class="mb-4 stat-item">
          <h3 class="stat-number">{{ animatedValues[index + 2] }}+</h3>
          <p>{{ item.label }}</p>
        </div>
      </div>
    </div>
    <div>
      <Galerie />
    </div>
    <div>
      <client />
    </div>
    <div>
      <vedette />
    </div>
    <div>
      <vision />
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomeSection',
  components: {
    Galerie: () => import('./Galerie.vue'),
    client: () => import('./client.vue'),
    vedette: () => import('./vedette.vue'),
    vision: () => import('./vision.vue'),
  },
  data() {
    return {
      leftStats: [
        { label: 'Clients satisfaits' },
        { label: 'Biens en gestion' }
      ],
      rightStats: [
        { label: 'Transactions réalisées' },
        { label: 'Années d’expérience' }
      ],
      animatedValues: [200, 150, 120, 10],
    };
  }
};
</script>

<style scoped>
.stat-number {
  font-size: 2.2rem;
  color: #007bff;
  font-weight: bold;
}
</style>
