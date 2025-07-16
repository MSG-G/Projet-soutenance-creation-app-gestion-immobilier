<template>
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">
      <img :src="getImageUrl(bien.imagePrincipale)" class="card-img-top biencard-img animated-img" alt="Image principale du bien" @error="onImgError($event)" />
      <div class="card-body">
        <h5 class="card-title">{{ bien.titre }}</h5>
        <p class="card-text"><strong>Type :</strong> {{ bien.type }}</p>
        <p class="card-text"><strong>Prix :</strong> {{ bien.prix }}</p>
        <p class="card-text" v-if="bien.superficie"><strong>Superficie :</strong> {{ bien.superficie }}</p>
        <p class="card-text" v-if="bien.statut"><strong>Statut :</strong> {{ bien.statut }}</p>
        <div v-if="bien.imagesSecondaires && bien.imagesSecondaires.length">
          <small class="text-muted">Autres images :</small>
          <div class="d-flex gap-2 mt-1">
            <img v-for="(img, i) in bien.imagesSecondaires" :key="i" :src="getImageUrl(img)" alt="Image secondaire" style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px;" @error="onImgError($event, true)" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BienCard',
  props: {
    bien: {
      type: Object,
      required: true
    }
  },
  methods: {
    getImageUrl(path) {
      if (!path) {
        return require('@/assets/no-image.jpg');
      }
      if (path.startsWith('http') || path.startsWith('data:')) {
        return path;
      } else {
        try {
          return require('@/assets/' + path);
        } catch (e) {
          return require('@/assets/no-image.jpg');
        }
      }
    },
    onImgError(event, isSecondary = false) {
      event.target.src = require('@/assets/no-image.jpg');
      if (!isSecondary) event.target.classList.add('img-error');
    }
  }
}
</script>

<style scoped>
.card-img-top {
  height: 200px;
  object-fit: cover;
  transition: transform 0.3s, box-shadow 0.3s;
  border-radius: 14px 14px 0 0;
}
.biencard-img.animated-img {
  animation: fadeInCard 0.8s;
}
.card:hover .card-img-top {
  transform: scale(1.04) translateY(-4px);
  box-shadow: 0 8px 32px rgba(69,123,157,0.13);
}
.img-error {
  filter: grayscale(1) brightness(0.85);
}
.card {
  transition: box-shadow 0.3s, transform 0.3s;
  border-radius: 18px;
}
.card:hover {
  box-shadow: 0 8px 32px rgba(69,123,157,0.17);
  transform: translateY(-8px) scale(1.03);
}
@keyframes fadeInCard {
  from { opacity: 0; transform: scale(0.96); }
  to { opacity: 1; transform: scale(1); }
}
</style>
