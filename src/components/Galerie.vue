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

.galerie-img {
  width: 100%;
  height: 190px;
  object-fit: cover;
  border-radius: 16px;
  transition: transform 0.4s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.galerie-img-container:hover .galerie-img {
  transform: scale(1.05) rotate(0deg);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

@keyframes flottement-gauche {
  0% {
    transform: rotate(-4deg) scale(1);
  }
  100% {
    transform: rotate(-2deg) scale(1.04);
  }
}

@keyframes flottement-droite {
  0% {
    transform: rotate(4deg) scale(1);
  }
  100% {
    transform: rotate(2deg) scale(1.04);
  }
}

/*  Responsive 3 images par ligne sur petit écran */
@media (max-width: 768px) {
  .galerie-img-container {
    flex: 1 1 calc(33.33% - 20px);
    max-width: calc(33.33% - 20px);
  }
}

/* ✅ Très petits écrans  */
@media (max-width: 500px) {
  .galerie-img-container {
    flex: 1 1 calc(50% - 10px);
    max-width: calc(50% - 10px);
  }
}

</style>