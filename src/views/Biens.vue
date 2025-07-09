<template>
  <!-- Barre de recherche -->
  <section class="search-section py-4">
    <div class="container text-center">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Rechercher un bien, une localisation, etc..."
        class="form-control d-inline-block w-50"
      />
      
    </div>
  </section>

  <!-- Texte avec fond bleu -->
  <section class="blue-banner text-center text-white py-5"  v-if="filteredBiens.some(b => b.type === 'Appartement')">
    <div class="container">
      <h2 class="fw-bold mb-3">Découvrez votre futur chez-vous !</h2>
      <p class="lead fw-semibold">
       Nous vous invitons à parcourir notre catalogue d'appartements soigneusement sélectionnés pour répondre à vos besoins et envies.<br> 
  Que vous cherchiez un studio cosy, un appartement familial ou un logement de standing, vous y trouverez sûrement votre coup de cœur.<br> 
  Cliquez et laissez-vous inspirer par nos offres!
      </p>
    </div>
  </section>

  <!-- Liste des biens -->
  <section class="container py-4">
    <div class="row mb-5" v-for="(bien, index) in filteredBiens.filter(b => b.type === 'Appartement')" :key="'app-' + index">
      <!-- Images -->
      <div class="col-md-6">
        <img :src="getImageUrl(bien.imagePrincipale)" alt="Image principale" class="img-fluid rounded mb-2 w-100" />
        <div class="d-flex gap-2">
          <img
            v-for="(img, i) in bien.imagesSecondaires"
            :key="i"
            :src="getImageUrl(img)"
            alt="Image secondaire"
            class="img-thumbnail"
          />
        </div>
      </div>

      <!-- Infos -->
      <div class="col-md-6">
        <h4 class="fw-bold">{{ bien.titre }}</h4>
        <div class="d-flex align-items-center gap-3 mb-2">
          <p class="text-primary fw-bold mb-0">{{ bien.prix }}</p>
          <span class="badge bg-dark">{{ bien.statut }}</span>
        </div>

        <div class="d-flex flex-wrap gap-3 my-2 text-primary">
          <div><i class="bi bi-aspect-ratio-fill"></i> {{ bien.superficie }}</div>
          <div><i class="bi bi-person-fill"></i> {{ bien.chambres }} Chambre</div>
          <div><i class="bi bi-droplet-fill"></i> {{ bien.sdb }} Salle de bain</div>
          <div><i class="bi bi-house-door-fill"></i> {{ bien.pieces }} Pièces</div>
        </div>

        <p class="mb-2 fw-bold">Description</p>
        <p>{{ bien.description }}</p>

        <p><i class="bi bi-geo-alt-fill text-primary"></i> {{ bien.localisation }}</p>

        <router-link to="/contact" class="btn btn-primary"> Réserver</router-link>

      </div>
    </div>
  </section>
<!-- Texte séparateur maisons -->
<section class="maisons-banner text-center text-white py-5"  v-if="filteredBiens.some(b => b.type === 'Maison')">
  <div class="container">
    <h2 class="fw-bold mb-3">La maison de vos rêves vous attend !</h2>
    <p class="lead fw-semibold">
      Explorez notre collection de maisons à vendre ou à louer, alliant confort, sécurité et cadre agréable.<br>
      Que ce soit pour vivre, investir ou loger votre famille, vous trouverez la maison idéale dans notre catalogue.<br>
      Faites le premier pas vers votre futur chez vous !
    </p>
  </div>
</section>

<!-- Biens de type "Maison"  -->
<section class="container py-4">
  <div
    class="row mb-5"
    v-for="(bien, index) in filteredBiens.filter(b => b.type === 'Maison')"
    :key="'maison-' + index">
    <!-- Images -->
    <div class="col-md-6">
      <img :src="getImageUrl(bien.imagePrincipale)" alt="Image principale" class="img-fluid rounded mb-2 w-100" />
      <div class="d-flex gap-2">
        <img
          v-for="(img, i) in bien.imagesSecondaires"
          :key="i"
          :src="getImageUrl(img)"
          alt="Image secondaire"
          class="img-thumbnail" />
      </div>
    </div>

    <!-- Infos  maison-->
    <div class="col-md-6">
      <h4 class="fw-bold">{{ bien.titre }}</h4>
      <div class="d-flex align-items-center gap-3 mb-2">
        <p class="text-primary fw-bold mb-0">{{ bien.prix }}</p>
        <span class="badge bg-dark">{{ bien.statut }}</span>
      </div>

      <div class="d-flex flex-wrap gap-3 my-2 text-primary">
        <div><i class="bi bi-aspect-ratio-fill"></i> {{ bien.superficie }}</div>
        <div><i class="bi bi-person-fill"></i> {{ bien.chambres }} Chambre</div>
        <div><i class="bi bi-droplet-fill"></i> {{ bien.sdb }} Salle de bain</div>
        <div><i class="bi bi-house-door-fill"></i> {{ bien.pieces }} Pièces</div>
      </div>

      <p class="mb-2 fw-bold">Description</p>
      <p>{{ bien.description }}</p>

      <p><i class="bi bi-geo-alt-fill text-primary"></i> {{ bien.localisation }}</p>

     <router-link to="/contact" class="btn btn-primary"> Réserver</router-link>

    </div>
  </div>
</section>
<!-- Texte séparateur villa -->
<section class="villa-banner text-center text-white py-5" v-if="filteredBiens.filter(b => b.type && b.type.toLowerCase() === 'villa').length > 0">
  <div class="container">
    <h2 class="fw-bold mb-3">Offrez-vous l’élégance d’une villa de rêve !</h2>
    <p class="lead fw-semibold">
      Plongez dans notre sélection exclusive de villas haut standing, pensées pour allier luxe, espace et tranquillité.<br>
   Que ce soit en bord de mer, en ville ou en zone résidentielle, trouvez la villa parfaite qui répond à vos attentes.<br>
    Votre confort commence ici.
    </p>
  </div>
</section>
<!-- Biens de type "villa"  -->
<section class="container py-4">
  <div
    class="row mb-5"
    v-for="(bien, index) in filteredBiens.filter(b => b.type === 'Villa')"
    :key="'Villa-' + index">
    <!-- Images villa -->
    <div class="col-md-6">
      <img :src="getImageUrl(bien.imagePrincipale)" alt="Image principale" class="img-fluid rounded mb-2 w-100" />
      <div class="d-flex gap-2">
        <img
          v-for="(img, i) in bien.imagesSecondaires"
          :key="i"
          :src="getImageUrl(img)"
          alt="Image secondaire"
          class="img-thumbnail" />
      </div>
    </div>

    <!-- Infos villa -->
    <div class="col-md-6">
      <h4 class="fw-bold">{{ bien.titre }}</h4>
      <div class="d-flex align-items-center gap-3 mb-2">
        <p class="text-primary fw-bold mb-0">{{ bien.prix }}</p>
        <span class="badge bg-dark">{{ bien.statut }}</span>
      </div>

      <div class="d-flex flex-wrap gap-3 my-2 text-primary">
        <div><i class="bi bi-aspect-ratio-fill"></i> {{ bien.superficie }}</div>
        <div><i class="bi bi-person-fill"></i> {{ bien.chambres }} Chambre</div>
        <div><i class="bi bi-droplet-fill"></i> {{ bien.sdb }} Salle de bain</div>
        <div><i class="bi bi-house-door-fill"></i> {{ bien.pieces }} Pièces</div>
      </div>

      <p class="mb-2 fw-bold">Description</p>
      <p>{{ bien.description }}</p>

      <p><i class="bi bi-geo-alt-fill text-primary"></i> {{ bien.localisation }}</p>

     <router-link to="/contact" class="btn btn-primary"> Réserver</router-link>

    </div>
  </div>
</section>

<!-- Texte séparateur terrains -->
<section class="terrain-banner text-center text-white py-5" v-if="filteredBiens.filter(b => b.type && b.type.toLowerCase() === 'terrain').length > 0">
  <div class="container">
    <h2 class="fw-bold mb-3">Investissez dans un terrain d’avenir !</h2>
    <p class="lead fw-semibold">
     Découvrez nos offres de terrains bien situés, sécurisés et prêts à bâtir.<br>
   Que ce soit pour un projet personnel, commercial ou un investissement à long terme, nous avons ce qu’il vous faut.<br>
    Saisissez l’opportunité de poser les bases de votre futur !
    </p>
  </div>
</section>
<!-- Biens de type "terrain"  -->
<section class="container py-4">
  <div
    class="row mb-5"
    v-for="(bien, index) in filteredBiens.filter(b => b.type === 'terrain')"
    :key="'terrain-' + index">
    <!-- Images terrain -->
    <div class="col-md-6">
      <img :src="getImageUrl(bien.imagePrincipale)" alt="Image principale" class="img-fluid rounded mb-2 w-100" />
      <div class="d-flex gap-2">
        <img
          v-for="(img, i) in bien.imagesSecondaires"
          :key="i"
          :src="getImageUrl(img)"
          alt="Image secondaire"
          class="img-thumbnail" />
      </div>
    </div>

    <!-- Infos terrain -->
    <div class="col-md-6">
      <h4 class="fw-bold">{{ bien.titre }}</h4>
      <div class="d-flex align-items-center gap-3 mb-2">
        <p class="text-primary fw-bold mb-0">{{ bien.prix }}</p>
        <span class="badge bg-dark">{{ bien.statut }}</span>
      </div>

      <div class="d-flex flex-wrap gap-3 my-2 text-primary">
        <div><i class="bi bi-aspect-ratio-fill"></i> {{ bien.superficie }}</div>
      
      </div>

      <p class="mb-2 fw-bold">Description</p>
      <p>{{ bien.description }}</p>

      <p><i class="bi bi-geo-alt-fill text-primary"></i> {{ bien.localisation }}</p>

     <router-link to="/contact" class="btn btn-primary"> Réserver</router-link>

    </div>
  </div>
</section>
 <!-- Texte remerciement-->
  <section class="remercie-banner text-center text-white py-5"  >
    <div class="container">
      <h2 class="fw-bold mb-3">Merci d’avoir pris le temps de consulter nos offres !</h2>
      <p class="lead fw-semibold">
       Si l’un de nos biens a retenu votre attention ou si vous avez des questions, n’hésitez pas à nous <router-link to="/contact"  class="lien-blanc"> Contacter</router-link>.
   Nous sommes là pour vous accompagner jusqu’à votre futur chez-vous.
      </p>
    </div>
  </section>
<div>
  <!-- footer -->
   <pied />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import pied from '@/components/pied.vue'

const searchQuery = ref('')

const biens = ref([
  {
    titre: 'Studio Meublé à Point-E',
    prix: '85 millions cfa',
     type: 'Appartement',
    superficie: '44 m²',
    chambres: 1,
    sdb: 1,
    pieces: 4,
    statut: 'A Vendre',
    localisation: 'Dakar / Point E',
    description: 'Bel appartement très lumineux F2 de 44 m², 8e étage d’un immeuble de standing à Point E (proche du commissariat).Parfait AirBnB. 1 Salon/Cuisine américaine, 1 couloir, 1 SDB, 1 chambre. Salle de sport et piscine dans l’immeuble.',
    imagePrincipale: '@/assets/studio à point-E.jpg',
    imagesSecondaires: ['@/assets/studio à point-E 1.jpg', '@/assets/studio à point-E 2.jpg']
  },

   {
    titre: 'Appartement à Yoff',
     type: 'Appartement',
    prix: '185 millions cfa',
    superficie: '255 m²',
    chambres: 4,
    sdb: 4,
    pieces: 10,
    statut: 'A Vendre',
    localisation: 'Dakar ',
    description: 'Situé dans un immeuble résidentiel de prestige à sis yoff. Offrant une grande sécurité, l appart est composé d une buanderie, un grand salon, cuisine équipée, espace personnel.De plus l espace nuit, pour chaque chambres une salle de bain equipée des materiaux de 1er choix. Il est grand et lumineux',
    imagePrincipale: '@/assets/app yoff.png',
    imagesSecondaires: ['@/assets/app yoff 1.jpg', '@/assets/app yoff 2.jpg']
  },
   {
    titre: 'Résidence aux Almadies',
    type: 'Appartement',
    prix: '170 millions cfa',
    superficie: '300 m²',
    chambres: 4,
    sdb: 4,
    pieces: 4,
    statut: 'A Vendre',
    localisation: 'Dakar / Almadies',
    description: '  De grands volumes dans toutes les piéces. Situé au rez-de-chaussée (rdc). Il dispose dune grande cour arrière privé et dun accés direct à la piscine. Lentrée de la propriété vous mène à un grand et lumineux salon qui dispose d un patio laissant entrer la lumière naturelle et qui offre de multiples possibilités de décoratives  Du séjour, vous accédez à la cuisine entiérement équipée, à la dépendance domestique ainsi qu au deuxième cour arrière et buanderie. Les 3 chambres sont grandes, naturellement aerées et disposent de leurssalles d eau et dressings   La résidence est haut gamme, en bord de mer et offre d excellente commodites à savoir une terrasse aménagée commune avec une large et imprenable vue sur la mer, une piscine,des places de parking privés au sous-sol et une salle de sport sur la terasse. Titre foncier incluant une place de parking privé au sous-sol.   ',
    imagePrincipale: '@/assets/residence almadies.jpg',
    imagesSecondaires: ['@/assets/residence almadies 1.jpg', '@/assets/residence almadies 2.jpg']
  },
   {
    titre: 'Appartement F4 à cité Keur Gorgui',
    type: 'Appartement',
    prix: '150 millions cfa',
    superficie: '140 m²',
    chambres: 3,
    sdb: 2,
    pieces: 6,
    statut: 'A Vendre',
    localisation: 'Dakar / Keur Gorgui',
    description: ' 3 chambres salon, 1 chambre parent avec salle de bain, une toilette commune pour les 2 autres chambres, une toilette visiteur. Un grand séjour, une cuisine équipée de placards et de hotte prolongé de sa buanderie de 140m² au 5e et 6e étage.Limmeuble est neuf avec groupe electrogène, ascenseur, gardiennage.',
    imagePrincipale: '@/assets/app keur guorgui.jpg',
    imagesSecondaires: ['@/assets/app keur guorgui 1.jpg', '@/assets/app keur guorgui 2.jpg']
  }
  ,
   {
    titre: 'Appartement à Ouakam',
    type: 'Appartement',
    prix: '300 mille cfa / mois',
   
    chambres: 2,
    sdb: 2,
    pieces:6 ,
    statut: 'A Vendre',
    localisation: 'Dakar / Ouakam',
    description: '   L appartement est au deuxième étage et comprend 2 chambres, 1 salon avec balcon, 1 cuisine équipée de placards, 2 salles d eau. L immeuble est moderne avec service de gardiennage.',
    imagePrincipale: '@/assets/app ouakam.jpg',
    imagesSecondaires: ['@/assets/app ouakam 1.jpg', '@/assets/app ouakam 2.jpg']
  }
  ,
   {
    titre: 'Appartement Meublé aux Almadies',
    type: 'Appartement',
    prix: ' 140 millions cfa',
    superficie: '140 m²',
    chambres:3 ,
    sdb:4 ,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Almadies',
    description: ' Appartement F4 au virage meublé de trois chambres avec toilette intérieur, salon avec vue sur mer pour les 3 chambres avec leur balcon, piscine, parking intégré.',
    imagePrincipale: '@/assets/app almadies.jpg',
    imagesSecondaires: ['@/assets/app almadies 1.jpg', '@/assets/app almadies 2.jpg']
  }
  ,
   {
    titre: 'Penthouse de luxe à Mbour',
    type: 'Appartement',
    prix: ' 300 millions cfa',
    superficie: '600 m²',
    chambres: 5,
    sdb:6 ,
    pieces:25 ,
    statut: 'A Vendre',
    localisation: 'Thies / Mbour',
    description: 'Ce penthouse de 5 chambres est Situé en bord de mer à Mbour. Il dispose d une grande piscine et un jardin offrant une vue panoramique sur la mer, d une cuisine moderne et de finitions haut de gamme. Il dispose aussi d un très grand salon espace salle à mangé inclus.',
    imagePrincipale: '@/assets/penthouse mbour.jpg',
    imagesSecondaires: ['@/assets/penthouse mbour 1.jpg', '@/assets/penthouse mbour 2.jpg']
  }
   ,
   {
    titre: 'Appartement à Ouakam',
    type: 'Appartement',
    prix: ' 250 mille cfa / mois ',
    superficie: ' 170m²',
    chambres: 2,
    sdb:2,
    pieces:6 ,
    statut: 'A Vendre',
    localisation: 'Dakar / Ouakam',
    description: ' Appartement à louer à Ouakam dans un immeuble de 3 étages situé dans un quartier résidentiel bien sécurisé avec un système de gardiennage. L appartement est au premier étage, comprenant 3 pièces dont une chambre parentale avec salle de bain et un mini dressing, une chambre de 13m²,un salon à l architecture moderne, lumineux et très spacieux, une cuisine moderne et une douche extérieure. Très belle vue sur le monument de la Renaissance.',
    imagePrincipale: '@/assets/app2 ouakam.jpg',
    imagesSecondaires: ['@/assets/app2 ouakam 1.jpg', '@/assets/app2 ouakam 2.jpg']
  }
   ,
   {
    titre: 'Appartement dans le Centre Ville',
    type: 'Appartement',
    prix: '180 millions cfa',
    superficie: '210 m²',
    chambres:3 ,
    sdb: 3,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Almadies',
    description: ' Appartement à vendre aux almadies composant 3 chambres, salon, parking sous-sol, cuisine équipée, groupe électrogène, ascenseur, piscine, salle de gymnastique et de boxe.',
    imagePrincipale: '@/assets/app cv.jpg',
    imagesSecondaires: ['@/assets/app cv 1.jpg', '@/assets/app cv 2.jpg']
  }
   ,
   {
    titre: 'Appartement au Point-E',
    type: 'Appartement',
    prix: '175 millions cfa',
    superficie: '',
    chambres: 3,
    sdb:2 ,
    pieces: 7,
    statut: 'A Vendre',
    localisation: '',
    description: 'Appartement neuf coomposé de 3 chambres, salon, salle de bain et cuisine. Il est situé dans le quartier résidentiel du Point-E à Dakar.Gardiennage et vidéo-surveillance 24h/24h.',
    imagePrincipale: '@/assets/app point e.jpg',
    imagesSecondaires: ['@/assets/app point e 1.jpg', '@/assets/app point e 2.jpg']
  }
   ,
   {
    titre: 'Appartement à Apix',
    type: 'Appartement',
    prix: '150 millions cfa',
    superficie: '150 m²',
    chambres: 4,
    sdb: 2 ,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Rufisque',
    description: ' Magnifique appartement moderne et spacieux.',
    imagePrincipale: '@/assets/app apix.jpg',
    imagesSecondaires: ['@/assets/app apix 1.jpg', '@/assets/app apix 2.jpg']
  }
   ,
   {
    titre: 'Duplex à Saly',
    type: 'Appartement',
    prix: '150 millions cfa',
    superficie: '167 m²',
    chambres: 3,
    sdb: 4 ,
    pieces: 18 ,
    statut: 'A Vendre',
    localisation: 'Thies / Mbour',
    description: 'Situé dans la station balnéaire de Saly entre le golf et la plage, ce duplex offre 3 chambres, grande pièce de vie, petite copropriété de 4 appartements, une cuisine équipée et une terasse avec vue sur la piscine commune, balcon, terasse barbecue accessoirisé, gardien.',
    imagePrincipale: '@/assets/duplex saly.jpg',
    imagesSecondaires: ['@/assets/duplex saly 1.jpg ', '@/assets/duplex saly 2.jpg']
  }
 ,
  
                                /*    Maison     */
   {
    titre: 'Maison aux Parcelles Assainies',
     type: 'Maison',
    prix: '35 millions cfa',
    superficie: '173 m²',
    chambres: 3,
    sdb:1 ,
    pieces:6 ,
    statut: 'A Vendre',
    localisation: 'Dakar / Parcelles Assainies',
    description:'Maison lumineuse et spacieusesituée dans un quartier calme et recherché, cette charmante maison de 6 pièces offre tout le confort nécessaire pour une vie paisible et agréable en plus d être dans une zone non inondable.Composition : 03 chambres, 01 salles de bain, cuisine, séjour spacieux et lumineux a l entrée, Toilettes extérieures et un cours de derrière.Atouts : Double façade, impasse, fondation R+3, zone non inondable',
    imagePrincipale: '@/assets/maison PA.jpg',
    imagesSecondaires: ['@/assets/maison PA1.jpg', '@/assets/maison PA2.jpg']
  },
  
  {
    titre: 'Maison aux Almadies 2',
     type: 'Maison',
    prix: '1 million cfa ',
    superficie: '380 m²',
    chambres: 4,
    sdb: 4,
    pieces: 12,
    statut: 'A Vendre',
    localisation: 'Dakar / Almadie 2 ',
    description:' Maison moderne à louer aux Almadies 2 sur 380m2 construite en R+1 avec terrasse accessible. F5 + grand espace de vie ouvert à l étage.	Rez de chausséeChambre de bonne, chambre d amis avec salle de bains transformée en bureau avec une véranda attenante donnant accès au jardin , double salon fermé + salle à manger , toilettes visiteurs.•	1er étage: salon ouvert avec espace à manger, terrasse chambres, dont une avec salle de bains + salle d eau extérieure Kitchenette avec placards de rangement. Nb: possibilité de louer sans meubles à 800 000fcfa.',
    imagePrincipale: '@/assets/maison almadies2.jpg',
    imagesSecondaires: ['@/assets/maison almadies2 1.jpg', '@/assets/maison almadies2 2.jpg']
  },
   
  {
    titre: 'Maison à Thies',
     type: 'Maison',
    prix: '350 millions cfa',
    superficie: '150 m²',
    chambres:3 ,
    sdb: 2,
    pieces: 8,
    statut: 'A Vendre',
    localisation: ' Thies / Keur Sega',
    description:'   Maison à keur sega commune de Keur Moussa ( département de Thies). Keur Sega est à la croisée des chemins entre Thies qui est à 20 minutes de route, à 30 minutes de l’aéroport AIBD, 20 minutes de Kayar zone très poissonneuse, keur Abdou Ndoye zone de fruits et légumes, accessible à Dakar par l’autoroute à péage sortie numéro 12 Sebikotane, environ 50 minutes de route. Keur Sega est une zone très calme où l’air n’est pas pollué, où il fait bon vivre, idéal pour l’épanouissement de nos enfants et de nos proches . La villa est composée d’une cour ( jardin) à l’entrée, d’un grand salon , d’un Space familial , d’une chambre des parents avec salle de bains , d’une chambre des enfants, d’une chambre des hôtes, d’une salle de bains extérieure, d’une cuisine et deux patios qui rendent l’habitation très aérée et lumineuse .',
    imagePrincipale: '@/assets/maison thies.jpeg',
    imagesSecondaires: ['@/assets/maison thies 1.jpeg', '@/assets/maison thies2.jpeg']
  }, 
  {
    titre: 'Maison à Golf',
     type: 'Maison',
    prix: '245 millions cfa',
    superficie: '158 m²',
    chambres:7 ,
    sdb: 7,
    pieces:23 ,
    statut: 'A Vendre',
    localisation: ' Dakar / Golf',
    description:' C est une maison que je vends avec les meubles à 245 millions, situé à la cité Atépa Golf Nord Guédiawaye derrière Dalal Diam vers la plage de Malibu à 150 mètres de la plage.Il est compsé d un rdc, grand salon et 2 magasins avec salle de bain + toilette visiteur.Au 1er et 2e étage 3chambres avec salle de bain et et salon avec cuisinette.Au 3e étage une grande cuisine, une chambre, une toilette visiteur, un espace de détente (pergola) et une salle de musculation.',
    imagePrincipale: '@/assets/maison golf.jpg',
    imagesSecondaires: ['@/assets/maison golf 1.jpg', '@/assets/maison golf 2.jpg']
  }, 
  {
    titre: 'Maison à Yoff',
     type: 'Maison',
    prix: '2 millions cfa / mois',
    superficie: '200 m²',
    chambres: 6,
    sdb:5 ,
    pieces: 16,
    statut: 'A Vendre',
    localisation: 'Dakar / Yoff ',
    description:' Maison d exception R+2 avec prestations haut de gamme,découvrez cette somptueuse maison R+2, offrant un cadre de vie spacieux, moderne et sécurisé, idéale pour les familles en quête de confort et de sérénité.<br>Caractéristiques générales: rez-de-chaussée, entrée avec un vaste salon lumineux de 80 m² doté d une cuisine américaine élégante et fonctionnelle, une chambre avec salle de bain privée, deux patios apportant lumière et convivialité, toilettes visiteurs.<br>Au 1er étage : suite parentale avec dressing intégré, salle de bain équipée d un jacuzzi et accès à deux terrasses privatives, deux chambres spacieuses avec salle de bain extérieure.<br>AU 2e étage : un salon dédié au divertissement ou à un espace de bureau, deux chambres avec salle de bain extérieure, une cuisine africaine indépendante, deux terrasses privées idéales pour vos moments de détente.<br>Équipements et sécurité : barbelé électrique pour une sécurité renforcée, système d alarme moderne et caméras de surveillance, garage pouvant accueillir un véhicule.',
    imagePrincipale: '@/assets/maison yoff.jpg',
    imagesSecondaires: ['@/assets/maison yoff 1.jpg', '@/assets/maison yoff 2.jpg']
  }, 
  {
    titre: 'Maison à Louga',
     type: 'Maison',
    prix: '350 mille cfa / mois',
    superficie: '450 m²',
    chambres: 5,
    sdb: 2,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Louga ',
    description:'  A louer à Louga pour usage d habitation ou de bureau. Maison composée de 05 chambres, 02 salles de bain, 01 grand salon, 02 toilettes visiteurs, 01 grande cuisine, 01 garage.',
    imagePrincipale: '@/assets/maison louga.jpg',
    imagesSecondaires: ['@/assets/maison louga 1.jpg', '@/assets/maison louga 2.jpg']
  }, 
 
  {
    titre: 'Maison à Ouest-foire',
     type: 'Maison',
    prix: '650 millie cfa / mois',
    superficie: '450 m²',
    chambres: 5,
    sdb: 3,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Foire ',
    description:'  Une belle maison R+1 à louer à Ouest-foire dans un quartier calme. Elle se compose de 5 chambres dont 3 avec leurs toilettes internes, d un double salon, d une cuisine spacieuse, d une toilette extérieure, d une toilette visiteur, d une courette, d une cuisine africaine à la terasse, d un magasin, d une buanderie et d une toilette à la terasse.',
    imagePrincipale: '@/assets/maison ouest-foire.jpeg',
    imagesSecondaires: ['@/assets/maison ouest-foire 1.jpeg', '@/assets/maison ouest-foire 2.jpeg']
  }, 
  {
    titre: 'Maison à Rufisque',
     type: 'Maison',
    prix: '150 mille cfa / mois',
    superficie: '175 m²',
    chambres: 3,
    sdb: 2,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Rufisque ',
    description:'  Maison composée de : 01 salon climatisé, 01 chambre principale climatisée, 02 chambres simples, 01 cuisine, 01 garage, toilettes visiteurs, grand espace familial, patio.',
    imagePrincipale: '@/assets/maison rufisque.jpg',
    imagesSecondaires: ['@/assets/maison rufisque 1.jpg', '@/assets/maison rufisque 2.jpg']
  }, 
  {
    titre: 'Maison à Keur Massar',
     type: 'Maison',
    prix: '225 mille cfa / mois',
    superficie: '200 m²',
    chambres: 3,
    sdb: 3,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Keur Massar ',
    description:'  Jolie villa rdc à louer à keur Massar cité Sotrac.Zone très accessible par rapport à la vdn3 et la route nationale.Composée de trois chambres dont deux avec salle de bain, un grand salon, une cuisine, une toilette visiteur et une espace familiale situé dans une zone calme et non inondable.',
    imagePrincipale: '@/assets/maison km.jpg',
    imagesSecondaires: ['@/assets/maison km 1.jpg', '@/assets/maison km 2.jpg']
  }, 
  {
    titre: 'Maison à Ngaparou',
     type: 'Maison',
    prix: '136 millions cfa',
    superficie: '175 m²',
    chambres: 4,
    sdb: 5,
    pieces: 10,
    statut: 'A Vendre',
    localisation: 'Thies / Saly',
    description:'   Située dans un quartier résidentiel, cette vIlla construite en 2024 d une surface habitable de 175m2, vendue semi-meublée, est de type R+1 et très lumineuse. Elle comprend 4 chambres, une au RDC et 3 à l étage, 4 salles d eau, une cuisine fermée et équipée avec une vitre donnant sur un séjour de 55m2 avec baies vitrées,  un wc visiteurs, une terrasse couverte de 30m2 au RDC, une terrasse de 20m2 à l étage, une piscine 8 X 4, un local piscine et une place de parking intérieur. Le terrain de 300m2 comprend un forage et est cloturé par un mur en toglou sur 2m50 de haut avec portail coulissant de 4m de long et une porte d entrée.',
    imagePrincipale: '@/assets/maison ngaparou.jpeg',
    imagesSecondaires: ['@/assets/maison ngaparou 1.jpeg', '@/assets/maison ngaparou 2.jpeg']
  }, 
   {
    titre: 'Maison à Cap-Skiring',
     type: 'Maison',
    prix: '450 millions cfa',
    superficie: '582 m²',
    chambres: 3,
    sdb: 3,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Ziguinchor / Cap-Skiring ',
    description:'   Villa style andalou sur 3 niveaux surplombant l océan et vue imprenable sur la réserve naturelle. Endroit idyllique bercé par les entrées maritimes. Conception familiale avec une annexe servant de bureau pouvant être destiné en studio. En plus, il y a une deuxième annexe de la dépendance pour le gardien et la femme de ménage.Énergie solaire, réserve d eau enterrée de 13 m³. Possibilité dinstaller une piscine 4*12.',
    imagePrincipale: '@/assets/maison cs.jpg',
    imagesSecondaires: ['@/assets/maison cs 1.jpg', '@/assets/maison cs 2.jpg']
  }, 
   
                                /*    villa    */
   
 {
    titre: 'Villa à Ngérine',
     type: 'Villa',
    prix: '500 millions cfa',
    superficie: '450 m²',
    chambres: 5,
    sdb: 5,
    pieces: 18,
    statut: 'A Vendre',
    localisation: 'Thiés',
    description:' Magnifique propriété située sur une superficie de près de 6000m2 avec des arbres fruitiers à Nguerigne. Cette somptueuse villa dispose de 5 chambres, dont 2 dans des studios indépendants, chacune avec une salle de bain et pour certaines un dressing. Vous bénéficierez d’un bel espace de vie comprenant un grand salon/salle à manger avec bar, un deuxième salon avec bureau et salon ainsi qu’un troisième petit salon qui jouxte une cuisine équipée avec îlot central et une buanderie. Salle de massage/sport avec douche ainsi que plusieurs terrasses (couvertes ou solariums) et salons extérieurs donnant sur une piscine 13X6 avec plage. La piscine chauffée est alimentée par une pompe électrique et des panneaux solaires. Vous trouverez également sur place une annexe avec des chambres pour le personnel, un garage, plusieurs places de parking possibles, un puits avec filtration mécanique et ultraviolette, un réservoir d’eau et un générateur.',
    imagePrincipale: '@/assets/villa ngérine.jpg',
    imagesSecondaires: ['@/assets/villa ngérine 1.jpg ', '@/assets/villa ngérine 2.jpg']
  }, 
{
    titre: 'Villa à Somone',
     type: 'Villa',
    prix: '2 milliards cfa',
    superficie: '480 m²',
    chambres: 5,
    sdb: 5,
    pieces: 12,
    statut: 'A Vendre',
    localisation: 'Thiés / Mbour',
    description:' A la fois en bord de mer et bordure de route, cette belle et grande villa est composée de 5 chambres, 5 salles de bain, salon, salle à manger et cuisine equipée ouverte sur une grande terasse aménagée avec salon, table à manger et pool housePartio arboré, piscine à débordement, double garage local, gardien et dépendances. Vendue meublée et équipée.',
    imagePrincipale: '@/assets/villa somone.jpg',
    imagesSecondaires: ['@/assets/villa somone 1.jpg', '@/assets/villa somone 2.jpg']
  }, 
{
    titre: 'Villa à Saint-Louis',
     type: 'Villa',
    prix: '200 millions cfa',
    superficie: '375 m²',
    chambres: 5,
    sdb: 5,
    pieces: 14,
    statut: 'A Vendre',
    localisation: 'Saint-Louis',
    description:'   A vendre magnifique maison, à Saint-Louis (Quartier Vauvert), au bord de l eau, face à la mangrove. Titre Foncier. Construction Année 2008. Superficie : 644 M² Surface Habitable : 375 M² Type : R+2 Nombre de séjour (salon salle à Manger) :02 Nombre de chambres : 05 Nombre de salle de bain :05 Nombre de toilettes : 07, dont 2 visiteurs.Jardin fleuri face au Fleuve. Possibilité de nombreuses extensions. ',
    imagePrincipale: '@/assets/villa stl.jpg',
    imagesSecondaires: ['@/assets/villa stl 1.jpg', '@/assets/villa stl 2.jpeg']
  }, 
{
    titre: 'Villa à Mbao',
     type: 'Villa',
    prix: '450 mille cfa / mois',
    superficie: '300 m²',
    chambres: 4,
    sdb: 3,
    pieces: 10,
    statut: 'A Vendre',
    localisation: 'Rufisque / Mbao',
    description:'  Location d une grande VILLA de 4 chambres climatisées avec des armoires incorporés avec 3 salles de bain ; un grand salon climatisé; Spatio climatisé avec balcon; Epace famillial avec un armoire de rangement; Cuisine avec des placards; Toilettes visiteurs; Garage pouvant contenir 3 vehicules; la villa dispose d un chauffe eau qui alimente toute la villa; d un visiophone et d une camera de surveillance à petit Mbao cité RIDWAN trés accessible.',
    imagePrincipale: '@/assets/villa mbao.jpg',
    imagesSecondaires: ['@/assets/villa mbao 1.jpg', '@/assets/villa mbao 2.jpg']
  }, 
 {
    titre: 'Villa à Fann Résidence',
     type: 'Villa',
    prix: '8 millions cfa / mois',
    superficie: '700 m²',
    chambres: 5,
    sdb: 4,
    pieces: 12,
    statut: 'A Vendre',
    localisation: 'Dakar / Fann Résidence',
    description:'Cette splendide villa vous met à disposition plus de 12 pièces.Avec un grand jardin et une immense piscine, ses deux (2) salons, sa suite parentale et ses grands dressing bien aménagés. Cette villa située dans un quartier chic et résidentiel, répond à votre rêve d’espace et de tranquillité. ',
    imagePrincipale: '@/assets/villa fr.jpg',
    imagesSecondaires: ['@/assets/villa fr 1.jpeg', '@/assets/villa fr 2.jpeg']
  }, 
{
    titre: 'Villa aux Almadies',
     type: 'Villa',
    prix: '375 millions cfa',
    superficie: '202 m²',
    chambres: 7,
    sdb: 7,
    pieces: 19,
    statut: 'A Vendre',
    localisation: 'Dakar / Almadies',
    description:'  Villa R+3 de 202 m2 aux RECASEMENT 1 ALMADIES derrière Philippe Morris. RDC: cour avant, garage 45m²: 2 véhicules + rangement, véranda, espace familial 75m², cour arrière, toilette visiteur, cuisine aménagée, patio- espace stockage gaz. 1er Etage : double salon 54m² + balcon, salon + cuisine américaine 40m² avec double hauteur ( Mezzanine) + balcon, salon 35m², toilettes visiteurs. 2ème étage : suite parentale (salon, chambre à coucher, dressing, SDB) + balcon, chambre enfant + dressing + SDB. 3ème étage : 3 chambres enfants + dressing + SDB, espace familial.<br>Divers : terrasse accessible avec espace lavage, réservoir 5000 L, réservoir 2000 L (Terrasse), surpresseur, 3 chauffe-eau (toutes les SDB & cuisines alimentées en eau chaude), système vidéo surveillance (caméra, alarmes, détecteurs de mouvements), système domotique ( ouverture & accès à distance), pré-installation climatisation dans toutes les pièces, fibre optique, câblage TV, fondations prévues pour R+5',
    imagePrincipale: '@/assets/villa almadies.jpeg',
    imagesSecondaires: ['@/assets/villa almadies 1.jpeg', '@/assets/villa almadies 2.jpeg']
  }, 
  {
    titre: 'Villa à Saly',
     type: 'Villa',
    prix: '8 millions cfa / ans',
    superficie: '400 m²',
    chambres: 4,
    sdb: 4,
    pieces: 14,
    statut: 'A Vendre',
    localisation: '',
    description:'  Belle Villa Située à Saly cité Lagune à 300 mètres de la plage de Safari Beach. La propriété s’étend sur 955 mètres carrés, dont 400 mètres carrés habitables. Dans un Quartier résidentiel calme à 5 minutes (à pied) de tous les commerces et du centre de Saly, à 1 heure de Dakar, sortie Péage à 10 minutes. Elle est composée de 4 chambres doubles + 4 SDB, 1 Cuisine équipée, 1 Salon séjour de 75 mètres carrés, 1 Salle de musique, 1 Bureau, 1 grande piscine, 1 Toilette visiteur, 1 Garage, 1 Buanderie.',
    imagePrincipale: '@/assets/villa saly.jpeg',
    imagesSecondaires: ['@/assets/villa saly 1.jpg ', '@/assets/villa saly 2.jpg']
  }, 
{
    titre: 'Villa à Ouakam',
     type: 'Villa',
    prix: '200 millions cfa',
    superficie: '582 m²',
    chambres: 8,
    sdb: 7,
    pieces: 12,
    statut: 'A Vendre',
    localisation: 'Dakar / Ouakam',
    description:'  Caractéristiques : 8 chambres dont 7 avec toilettes intérieures, 3 salons, 1 salle à manger, 2 cuisines, 2 patios, 1 couloir, 2 terrasses avec vue sur mer, 1 reservoir avec surpresseur, 3 caméras de surveillance, 3 toilettes extérieures publics sans les meubles. ',
    imagePrincipale: '@/assets/villa ouakam.jpg',
    imagesSecondaires: ['@/assets/villa ouakam 1.jpg', '@/assets/villa ouakam 2.jpg']
  }, 
 {
    titre: 'Villa à Somone',
     type: 'Villa',
    prix: '2 millions cfa / ans',
    superficie: '300 m²',
    chambres: 4,
    sdb: 4,
    pieces: 12,
    statut: 'A Vendre',
    localisation: ' Thiés / Mbour',
    description :' Proposée en location annuelle, cette propriété pieds dans l eau est située à la Somone face à la lagune, tout en restant proche des commodités. Bâties sur un grand terrain arboré et fleuri de 2400 m2, la maison principale et ses 2 dépendances d une surface habitable totale de 300 m2 vous accueillent dans cet écrin de verdure.  La villa de 120 m2 est composée d un salon-salle à manger ouvert sur une jolie terrasse, d une cuisine, d un WC visiteur, d une chambre agrémentée d un dressing et de sa salle d eau attenante. Une mezzanine offre un espace supplémentaire. La première dépendance de 100 m2 se compose d un salon et d un coin cuisine, d une chambre et sa salle d eau. La deuxième dépendance de 80 m2 propose 2 chambres avec leurs salles d eau respectives. Toutes ont une vue magnifique sur la piscine et la lagune ! Il existe également un double garage et un local pour le personnel. Surpresseur + réserve de 2000 L.Alarme. Loué semi-meublé. Son atout: rien d autre en face de vous que la lagune, la mangrove et les oiseaux !',   
    imagePrincipale: '@/assets/villa2 somone.jpeg',
    imagesSecondaires: ['@/assets/villa2 somone 1.jpeg', '@/assets/villa2 somone 2.jpeg']
  }, 
 {
    titre: 'Villa F4 à Diamniadio',
     type: 'Villa',
    prix: '1 million 200 mille cfa / mois',
    superficie: '200 m²',
    chambres: 3,
    sdb: 2,
    pieces: 8,
    statut: 'A Vendre',
    localisation: 'Dakar / Diamniadio',
    description:'    Entrée, toilette visiteurs, espace familial, coin privé, séjour avec table à manger, terrasse au rez de chaussée, cuisine, buanderie, toilette de service, chambre principale + Terrasse au 1er étage, salle deau + machine à laver + chauffe eau, chambre 2 au rez de chaussée, salle d eau, chambre 3 au 1er étage, salle d eau + chauffe eau, espace familial au 1er étage,',
    imagePrincipale: '@/assets/villa D.jpg',
    imagesSecondaires: ['@/assets/villa D 1.jpg', '@/assets/villa D 2.jpg']
  },
                                     /*    terrain    */
   
{                      
  
  titre: 'Terrain à Mboro',
    prix: '2,750 millions cfa',
     type: 'terrain',
    superficie: '10.000 m²',
  
    statut: 'A Vendre',
    localisation: 'Thies / Mboro',
    description:  ' Voici 50 hectares disponible entre Diogo et Mboro, Tivaoune Thies au Sénégal. Le champs est très accessible avec un sol assez fertile et propice pour une activité de culture car la nappe phréatique est très proche. Le m² est vendu à 275f soit 2.750.000 francs l hectare.',
    imagePrincipale: '@/assets/terrain mboro.jpg',
    imagesSecondaires: ['@/assets/terrain mboro 2.jpg', '@/assets/terrain mboro 3.jpg']
  },
{                      
  
  titre: 'Terrain à Pout',
    prix: '4,500 millions cfa',
     type: 'terrain',
    superficie: '180 m²',
  localisation: 'Thies / Pout',
    statut: 'A Vendre',
    
    description:  ' Situé non loin de la gare du TER, à proximité de l autoroute à péage A1 sortie 12, nous vous offrons des terrains de 180 m² à Pout dans une cité résidentielle à 4.500.000 la parcelle payable sur une durée de 36 mois avec un apport de réservation de 1.000.000 fcfa et l ouverture du dossier s élève à 200.000 francs. Nous vous offrons des aires de jeux, lieux de cultes et espaces verts.',
    imagePrincipale: '@/assets/terrain pout.jpg',
    imagesSecondaires: ['@/assets/terrain pout 2.jpg', '@/assets/terrain pout 3.jpg']
  },
  {                      
  
  titre: 'Terrain à Diass',
    prix: '4 millions cfa',
     type: 'terrain',
    superficie: '225 m²',
    statut: 'A Vendre',
     localisation: 'Thies / Diass',
    description:  'Nous vous proposons des terrains à vendre sur Diass à 5 minutes de l aéroport Blaise Diagne dans une site habitée ayant eau et électricité: 300 m² à partir du prix affiché.',
    imagePrincipale: '@/assets/terrain Diass.jpg',
    imagesSecondaires: ['@/assets/terrain Diass 2.jpg', '@/assets/terrain Diass 3.jpg']
  },
  {                      
  
  titre: 'Terrain à Ndiakhirate Dakar',
    prix: '14 millions cfa',
     type: 'terrain',
    superficie: '150 m²',
    statut: 'A Vendre',
     localisation: 'Dakar / Rufisque',
    description:  '  Kalimo city situé à 30mns du centre-ville de Dakar et à 10mns du Lac Rose plus précisément à Ndiakhirate, proche de l’autoroute à péage A1 sortie 10 de Diamniadio, AIBD et du prolongement de la VDN.Cette nouvelle cité disposant de toutes les commodités ( aires de jeux , Mosquée , espaces verts, poste de santé, école, terrain de sport etc…) vous propose des parcelles de 150m² payables sur 2ans. Nature Juridique : Titre Foncier Individuel',
    imagePrincipale: '@/assets/terrain ndiakhirate.jpg',
    imagesSecondaires: ['@/assets/terrain ndiakhirate 2.jpg', '@/assets/terrain ndiakhirate.jpg']
  },
  {                      
  
  titre: 'Terrain à Ngor Almadies',
    prix: '480,165 millions cfa',
     type: 'terrain',
    superficie: '538 m²',
  
    statut: 'A Vendre',
     localisation: 'Dakar / Ngor',
    description:  '  Votre agence immobilière DEV_IMMO vous propose ce magnifique terrain de 538 m² situé dans le quartier résidentiel de Ngor Almadies. Niché derrière Philippe Morris, ce terrain bénéficie d’un emplacement exceptionnel, au cœur d’un secteur recherché et paisible. Une opportunité rare dans un cadre idyllique, idéal pour concrétiser vos projets immobiliers. Laissez-vous séduire par cette parcelle aux nombreux atouts, où chaque mètre carré offre des possibilités infinies. Un espace parfait pour donner vie à vos aspirations, alliant tranquillité et accessibilité.<br>🖋 Titre de propriété : Titre foncier individuel',
    imagePrincipale: '@/assets/terrain almadies.jpg',
    imagesSecondaires: ['@/assets/terrain almadies 2.jpg', '@/assets/terrain almadies.jpg']
  },
  {                      
  
  titre: 'Terrain à Guéréo',
    prix: '200 millions cfa',
     type: 'terrain',
    superficie: '10.000 m²',
    statut: 'A Vendre',
     localisation: 'Thies',
    description:  'Découvrez une opportunité rare au cœur de la zone la plus prisée de Guereo, sur les hauteurs, avec une vue imprenable sur la mer, la lagune de la Somone et Saly. Situé dans un environnement en plein essor, ce terrain offre une proximité avec des lieux emblématiques comme les Manguiers de Guereo à seulement 300 m ou encore la Ferme Bio des Collines. Nous proposons deux parcelles de 1000 m² chacune, sur un terrain libre, légèrement incliné, parfait pour concrétiser votre projet de résidence ou d’investissement dans un cadre paradisiaque et à fort potentiel de valorisation. Prix attractif, terrain avec délibération, PV de vérification et accords favorables de l’urbanisme, du cadastre et des domaines de Mbour. Accès direct à la route, raccordement facile à la Senelec.<br> Localisation idéale : à 5 minutes du village de Guereo, 10 minutes de la Somone, 15 minutes du péage de SinProfitez de cette chance unique d’acquérir un bien exceptionnel dans une zone où les opportunités se font de plus en plus rares.',
    imagePrincipale: '@/assets/terrain guereo 3.jpg',
    imagesSecondaires: ['@/assets/terrain guerreo 2.jpg ', '@/assets/terrain guereo 3.jpg']
  },
  {                      
  
  titre: 'Terrain à Somone',
    prix: '17 millions cfa',
     type: 'terrain',
    superficie: '600 m²',
    statut: 'A Vendre',
     localisation: 'Thies',
    description:  'Un terrain à Somone de 600 m², très calme et éclairé.',
    imagePrincipale: '@/assets/terrain somone.jpg',
    imagesSecondaires: ['@/assets/terrain somone 2.jpg', '@/assets/terrain somone.jpg']
  },
  {                      
  
  titre: 'Terrain à Yoff',
    prix: '985 millions cfa',
     type: 'terrain',
    superficie: '1095 m²',
    statut: 'A Vendre',
     localisation: 'Dakar / Yoff',
    description:  '    Un terrain à vendre à Yoff virage avec une superficie de 1095 m2. Opportunités à saisir ! Terrain de 1095 m2 , idéalement situé dans un cadre calme et sécurisé de Yoff virage , à proximité immédiate de la mer . Parfait pour un projet immobilier de prestige, que ce soit une villa , un hôtel , ou un complexe résidentiel.<br>Prix du m2 : 900.000 f<br>Prix unitaire : 985.000.000 f',
    imagePrincipale: '@/assets/terrain yoff virage.jpg',
    imagesSecondaires: ['@/assets/terrain yoff virage 2.jpg', '@/assets/terrain yoff virage.jpg']
  },
  {                      
  
  titre: 'Terrain aux almadies',
    prix: '115 millions cfa',
     type: 'terrain',
    superficie: '180 m²',
  
    statut: 'A Vendre',
     localisation: 'Dakar / Almadies',
    description:  '  Un terrain de 180 m² aux Almadies, Dakar. Situé dans le quartier prisé des almadies, ce terrain de 180 m² est en vente pour le prix de 115 millions.',
    imagePrincipale: '@/assets/terrain almadies 3.jpg',
    imagesSecondaires: ['@/assets/terrain almadies 3.jpg', '@/assets/terrain almadies 3.jpg']
  },
  {                      
  
  titre: 'Terrain à Saly',
    prix: '15 millions cfa',
     type: 'terrain',
    superficie: '300 m²',
    statut: 'A Vendre',
     localisation: 'Thies',
    description:  '  Un terrain de 300 m² à Saly. Situé à Nguering dans le quartier privilégié du parc exotique et de l école Montessori, ce terrain est en vente pour 15 millions.',
    imagePrincipale: '@/assets/terain saly 4.jpg',
    imagesSecondaires: ['@/assets/terrain saly.jpg', '@/assets/terrain saly 3.jpg']
  },
  {                      
  
  titre: 'Terrain à Kaolack',
    prix: '20 millions cfa',
     type: 'terrain',
    superficie: '288 m²',
  
    statut: 'A Vendre',
     localisation: 'Kaolack',
    description:  ' Un terrain Nu à Kaolack titre foncier d’une superficie de 288 m2. Terrain d’angle bien positionné, en bordure de route sur la route vers Medina baye . Emplacement à 900 m du cœur de ville , et à environ 1 km de la grande mosquée de Médina Baye . Prix 19 900 000 f ',
    imagePrincipale: '@/assets/terrain Kaolack.jpg',
    imagesSecondaires: ['@/assets/terrain Kaolack.jpg ', '@/assets/terrain Kaolack.jpg']
  },
  {                      
  
  titre: 'Terrain à Zac Mbao',
    prix: '18 millions cfa',
     type: 'terrain',
    superficie: '150 m²',
  
    statut: 'A Vendre',
     localisation: 'Dakar',
    description:  '  Un terrain de 150 m² à Zac Mbao, Dakar. Situé dans la cité Enda de Zac Mbao, ce terrain est idéal pour une construction résidentielle. ',
    imagePrincipale: '@/assets/terrain zac mbao 2.jpg',
    imagesSecondaires: ['@/assets/terrain zac mbao 4.jpg', '@/assets/terrain zac mbao 3.jpg']
  },
                  







])
  
  


const filteredBiens = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return biens.value.filter(
    (b) =>
      b.titre.toLowerCase().includes(query) ||
      b.description.toLowerCase().includes(query) ||
      b.localisation.toLowerCase().includes(query) ||
      
      (b.type && b.type.toLowerCase().includes(query))
  )
})

function getImageUrl(path) {
  return new URL(path.replace('@/', '/src/'), import.meta.url).href
}


</script>

<style scoped>
.search-section input {
  padding: 0.75rem 1rem;
  font-size: 1rem;
}

.blue-banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.blue-banner h2 {
  font-size: 2rem;
}

.blue-banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}

.img-thumbnail {
  border-radius: 8px;
  height: 130px;
  width: 48%;
  object-fit: cover;
}

.bi {
  margin-right: 6px;
}
.maisons-banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.maisons-banner h2 {
  font-size: 2rem;
}

.maisons-banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}
.villa-banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.villa-banner h2 {
  font-size: 2rem;
}

.villa-banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}
.terrain-banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.terrain-banner h2 {
  font-size: 2rem;
}

.terrain-banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}
.remercie-banner {
  background-color: #0047FF;
  color: white;
  width: 100%;
}

.remercie-banner h2 {
  font-size: 2rem;
}

.remercie-banner p {
  font-size: 1.1rem;
  max-width: 900px;
  margin: 0 auto;
  line-height: 1.7;
}
.lien-blanc {
  color: white;
  text-decoration: none;
}
</style>
 