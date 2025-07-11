<template>
  <section class="presentation-wrapper">
   
    <div class="full-width-image-container">
      <img src="@/assets/image7.jpg" alt="Image présentation" class="full-width-image" />
      <div class="blue-alert-box">
        <p>
         Bienvenue chez <strong>DEV-IMMO</strong>, votre partenaire de confiance dans la recherche, la location et la gestion de biens immobiliers.
        Que vous soyez à la recherche de votre futur chez-vous ou d'un investissement rentable, nous sommes là pour vous accompagner à chaque étape. 
    Avec notre expertise et notre engagement, nous transformons vos projets immobilier en réalité.
        </p>
      </div>
    </div>

   
    <div class="full-width-blue-section">
      <div class="bottom-part">
        <div class="text-with-icon">
          <p>
            <i class="bi bi-house-fill icon-purple"></i>
           Notre agence immobilière est dediée à vous accompagner dans toutes vos démarches liées à l'achat, la vente, la location et la gestion de biens immobiliers au Sénégal.</p><br>
            <p>Forts de nombreuses années d'expérience et d'une connaissance approfondie du marché local, nous mettons un point d'honneur à comprendre vos besoins et à vous offrir des solutions sur mesure, adaptées à vos attentes. 
                Notre équipe de professionnels passionés et réactifs vous guide avec sérieux et transparence, en vous fournissant des conseils précieux à chaque étape de votre projet immobilier. 
                Que vous soyez primo-accédant, investisseur ou locataire, nous nous engageons à rendre votre expérience simple, fluide et satisfaisante.<br>
                Notre objectif: faire de vos projets immobiliers une réalité, en toute confiance et sérénité...
            </p>
        </div>
        <img src="@/assets/toff2.jpeg" alt="Image bâtiment" class="bottom-image" />
      </div>
    </div>
    
  </section>
   <main class="descript text-dark py-5">
    <div class="container">
      <h2 class="text-center text-primary mb-4">
        NOTRE SAVOIR-FAIRE, LA CLÉ DE NOTRE SUCCÈS
      </h2>

      <div class="row">
        <!-- Nos avantages -->
        <div class="col-md-6">
          <h3 class="fw-bold">Nos avantages</h3>
          <p>
            Spécialisé dans ce domaine de nombreuses années, nous vous offrons une expérience fluide et professionnelle.
          </p>
          <ul>
            <li>
              Implanté partout dans le Sénégal, nos jeunes agents immobiliers passionnés et motivés seront à votre disposition pour chaque étape.
            </li>
            <li>
              Des services sur mesure pour répondre à chaque client.
            </li>
            <li>
              Un suivi clair et honnête à chaque étape de votre projet.
            </li>
            <li>
Nous travaillons en étroite collaboration avec les nouvelles technologies pour valoriser vos biens et vous projetez dans cette atmosphère chaleureuse avec la 3D.            </li>
          </ul>
        </div>

        <!-- Notre mission -->
        <div class="col-md-6">
          <h3 class="fw-bold">Notre mission</h3>
          <p>
            Notre mission est de réaliser vos rêves immobiliers en vous fournissant des services de premier ordre et en mettant à votre disposition notre expertise du marché.
          </p>
          <ul>
            <li>
Nous croyons fermement qu’une relation basée sur la confiance et la transparence est la clé pour atteindre vos objectifs immobiliers.   
         </li>
           
         <li>
              Ainsi nous simplifions et sécurisons  vos démarches immobilières tout en créant une expérience client unique:
          </li>
           <li>
              Vos choix, nous en ferons notre préoccupation.
            </li>
            <li>
              Trouver votre coup de cœur quoi qu’il en coûte.
            </li>
            <li>
              Un suivi clair et honnête à chaque étape de votre projet.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </main>
  <section class="experts-section">
    <div class="container py-5">
      <h2 class="fw-bold text-center text-primary mb-3">
        Rencontrez Nos Experts de l'immobilier 🧑‍💼
      </h2>
      <p class="text-center mb-4">
        Derrière chaque transaction réussie, il y a un agent immobilier passionné qui comprend vos besoins et vous guide dans votre projet. Notre équipe de professionnels est là pour vous :
      </p>

      <ul class="fs-5">
        <li>🏡 Acheteurs ? Nous trouvons le bien parfait pour vous.</li>
        <li>📦 Vendeurs ? Nous mettons en valeur votre propriété pour une vente rapide.</li>
        <li>📈 Investisseurs ? Nous vous aidons à faire les meilleurs choix.</li>
      </ul>

      <p class="text-center mt-3 fs-5 text-primary">
        Découvrez nos agents et trouvez votre expert dédié 🧭
      </p>

      <div class="text-center mt-3">
        <button class="btn btn-outline-light">Contacter</button>
      </div>
    </div>

     <!-- compteurs -->
  <div class="stats-background d-flex align-items-center">
    <div class="container text-center py-5">
      <div class="row">
        <div class="col-6 col-md-3" v-for="(stat, index) in stats" :key="index">
          <div class="stat-box">
            <h3 class="display-6 fw-bold text-white">
              {{ formatNumber(displayCounts[index]) }} +
            </h3>
            <p class="text-white">{{ stat.label }}</p>
            <hr class="white-line" />
          </div>
        </div>
      </div>
    </div>
  </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const stats = [
  { target: 100, label: 'Appartements vendus' },
  { target: 1000, label: 'Clients satisfaits' },
  { target: 250, label: 'Maisons Louées' },
  { target: 1200, label: 'Propriétés répertoriées' }
]

const displayCounts = ref(stats.map(() => 0))
let animationStarted = false

onMounted(() => {
  const observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && !animationStarted) {
        startAnimation()
        animationStarted = true
        observer.disconnect()
      }
    },
    { threshold: 0.5 }
  )

  const target = document.querySelector('.stats-background')
  if (target) observer.observe(target)
})

function startAnimation() {
  const duration = 2000
  const start = performance.now()

  function update(timestamp) {
    const progress = Math.min((timestamp - start) / duration, 1)

    stats.forEach((stat, i) => {
      displayCounts.value[i] = Math.floor(stat.target * progress)
    })

    if (progress < 1) {
      requestAnimationFrame(update)
    } else {
      stats.forEach((stat, i) => {
        displayCounts.value[i] = stat.target
      })
    }
  }

  requestAnimationFrame(update)
}

function formatNumber(number) {
  return number.toLocaleString()
}
</script>

<style>
.full-width-image-container {
  position: relative;
  margin-bottom: 140px; 
}

.full-width-image {
  width: 100%;
  height: 450px;
  object-fit: cover;
  display: block;
}


.blue-alert-box {
  position: absolute;
  bottom: -90px;
  right: 40px;
  background-color: #007bff;
  color: white;
  padding: 20px 25px;
  border-radius: 8px;
  max-width: 350px;
  font-size: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}


.full-width-blue-section {
  width: 100vw;
  margin-left: calc(-50vw + 50%);
  background-color: #e6f0ff;
  padding: 80px 0;
}


.bottom-part {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  padding: 0 20px;
}

.text-with-icon {
  flex: 2;
  font-size: 15px;
  color: #444;
}

.bottom-image {
  flex: 1;
  max-width: 350px;
  border-radius: 8px;
  margin-top: 10px;
}

/* 🔁 Responsive */
@media (max-width: 768px) {
  .blue-alert-box {
    position: static;
    margin: 20px auto 0 auto;
    width: 90%;
    text-align: center;
  }

  .bottom-part {
    flex-direction: column;
    text-align: center;
  }

  .bottom-image {
    width: 100%;
  }
}
.descript {
  background-color: #e6f0ff;
  width: 100vw;
  margin: 0;
  padding: 60px 0; 
}

.descript ul {
  padding-left: 1rem;
}

.descript li {
  margin-bottom: 0.5rem;
}


experts-section {
  background-color: #111; 
  color: white;
}

ul {
  list-style: none;
  padding-left: 0;
}

ul li {
  margin-bottom: 0.6rem;
}

.stats-background {
  background-image: url('@/assets/image11.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  width: 100%;
  min-height: 500px;
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
}

.stat-box {
  margin: 20px 0;
}

.white-line {
  border: none;
  height: 2px;
  background-color: white;
  width: 60%;
  margin: 10px auto 0;
}

</style>
