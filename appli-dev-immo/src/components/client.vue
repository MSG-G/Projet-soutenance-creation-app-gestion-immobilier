<template>
  <section class="clients-container">
    <div class="clients-content">
      <h2 class="clients-title">Chers clients</h2>
      <p class="clients-text">
Forts de nombreuses années d’expérience et d’une connaissance approfondie du marché local, nous mettons un point d’honneur à comprendre vos besoins et à vous offrir des solutions sur mesure, adaptées à vos attentes.Notre équipe de professionnels passionnés et réactifs vous guide avec sérieux et transparence, en vous fournissant des conseils précieux à chaque étape de votre projet immobilier. Que vous soyez primo-accédant, investisseur ou locataire, nous nous engageons à rendre votre expérience simple, fluide et satisfaisante      </p>
   <span class="objectif">Notre objectif : faire de vos projets immobiliers une réalité, en toute confiance et sérénité.</span>
</div>
  </section>
</template>

<script setup>

</script>

<style scoped>
.clients-container {
  background: linear-gradient(135deg, #0a2540, #144a74);
  padding: 100px 20px;
  color: white;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;

  margin-top: -120px;     
  z-index: -1;             
  position: relative;
}

.clients-content {
  max-width: 800px;
  animation: fadeZoom 1.6s ease-in-out;
}

.clients-title {
  font-size: 2.5rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.clients-text {
  font-size: 1.2rem;
  line-height: 1.6;
}

/* Animation */
@keyframes fadeZoom {
  0% {
    opacity: 0;
    transform: scale(0.8) translateY(30px);
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}
</style>
