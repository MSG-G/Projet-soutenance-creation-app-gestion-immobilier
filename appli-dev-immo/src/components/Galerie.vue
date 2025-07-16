<template>
  <div class="galerie-wrapper">
    <div class="galerie-ligne">
      <div
        v-for="(img, i) in images"
        :key="i"
        :class="['galerie-img-container', i % 2 === 0 ? 'gauche' : 'droite']"
      >
        <img
          :src="img"
          alt="Propriété"
          class="galerie-img"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import image1 from '@/assets/image1.jpg'
import image2 from '@/assets/image2.jpg'
import image3 from '@/assets/image3.jpg'
import image4 from '@/assets/image4.jpg'
import image5 from '@/assets/image5.jpg'
import image6 from '@/assets/image6.jpg'


const images = [image1, image2, image3, image4, image5, image6,]
</script>


<style scoped>
.galerie-wrapper {
  width: 100%;
  padding: 2rem 1rem;
  margin: 0 auto;
  overflow-x: hidden;
  box-sizing: border-box;
}

.galerie-ligne {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.galerie-img-container {
  flex: 1 1 calc(16.6% - 20px); 
  max-width: calc(16.6% - 20px);
  animation: flottement 5s ease-in-out infinite alternate;
}

.galerie-img-container.gauche {
  animation-name: flottement-gauche;
}

.galerie-img-container.droite {
  animation-name: flottement-droite;
}

@keyframes flottement-gauche {
  0% { transform: translateY(0); }
  100% { transform: translateY(-10px); }
}

@keyframes flottement-droite {
  0% { transform: translateY(0); }
  100% { transform: translateY(10px); }
}

.galerie-img {
  width: 100%;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
