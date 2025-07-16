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
            Notre agence immobilière est dédiée à vous accompagner dans toutes vos démarches liées à l'achat, la vente, la location et la gestion de biens immobiliers au Sénégal.</p><br>
            <p>Forts de nombreuses années d'expérience et d'une connaissance approfondie du marché local, nous mettons un point d'honneur à comprendre vos besoins et à vous offrir des solutions sur mesure, adaptées à vos attentes. 
                Notre équipe de professionnels passionnés et réactifs vous guide avec sérieux et transparence, en vous fournissant des conseils précieux à chaque étape de votre projet immobilier. 
                Que vous soyez primo-accédant, investisseur ou locataire, nous nous engageons à rendre votre expérience simple, fluide et satisfaisante.<br>
                Notre objectif: faire de vos projets immobiliers une réalité, en toute confiance et sérénité...
            </p>
        </div>
        <img src="@/assets/toff2.jpeg" alt="Image bâtiment" class="bottom-image" />
      </div>
    </div>
    <main class="descript text-dark py-5">
      <div class="container">
        <h2 class="text-center text-primary mb-4">
          NOTRE SAVOIR-FAIRE, LA CLÉ DE NOTRE SUCCÈS
        </h2>
        <div class="row">
          <div class="col-md-6">
            <ul>
              <li>Conseils personnalisés</li>
              <li>Accompagnement sur-mesure</li>
              <li>Transparence & confiance</li>
              <li>Expérience client unique</li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul>
              <li>Large choix de biens</li>
              <li>Professionnels passionnés</li>
              <li>Marché local maîtrisé</li>
              <li>Suivi après-vente</li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </section>
</template>

<script>
export default {
  name: 'AproposSection'
}
</script>

<style scoped>
.full-width-image-container {
  position: relative;
  width: 100%;
  height: 320px;
  overflow: hidden;
  margin-bottom: 24px;
}
.full-width-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.blue-alert-box {
  position: absolute;
  bottom: 20px;
  left: 20px;
  background: #007bff;
  color: #fff;
  padding: 16px 24px;
  border-radius: 8px;
  max-width: 420px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.full-width-blue-section {
  background: #eaf1fb;
  padding: 32px 0;
}
.bottom-part {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 32px;
}
.text-with-icon {
  flex: 2;
}
.icon-purple {
  color: #6f42c1;
  margin-right: 8px;
}
.bottom-image {
  flex: 1;
  width: 180px;
  border-radius: 8px;
}
</style>
