<template>
  <div>
    <div v-if="chargement" class="text-center my-4">
      <span>Chargement des biens...</span>
    </div>
    <div v-else-if="erreur" class="alert alert-danger my-4">
      {{ erreur }}
    </div>
    <div v-else>
      <!-- Bloc 1 : Ajouter des propriétés -->
      <div class="container-fluid mt-4">
        <div class="row ms-5">
          <div class="col-12 col-md-10 col-lg-10">
            <div class="card shadow rounded bg-white">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ajouter des propriétés</h5>
                <button class="btn btn-outline-primary btn-sm">ajouter</button>
              </div>
              <div class="table-responsive">
                <table class="table bg-white">
                  <thead class="table-light">
                    <tr>
                      <th scope="col">Modéle</th>
                      <th scope="col">Type</th>
                      <th scope="col">Statut</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="bien in biens" :key="bien.id">
                      <td>{{ bien.titre }}</td>
                      <td>{{ bien.typeBien?.nom }}</td>
                      <td><span class="badge bg-success">{{ bien.statut ?? (bien.disponible ? 'Disponible' : 'Vendu') }}</span></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Bloc 2 : Visites à venir -->
      <div class="row ms-5 mt-5">
        <!-- Champ de recherche -->
        <div class="col-12 col-md-10 col-lg-11">
          <div class="mb-3 d-flex flex-wrap bar-search">
            <div class="position-relative w-100 me-2" style="max-width: 45rem;">
              <input
                type="text"
                v-model="recherche"
                class="form-control ps-5"
                placeholder="Rechercher..."
              />
              <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>
            <button type="button" class="btn btn-primary ms-0">rechercher</button>
          </div>
        </div>
        <div class="col-12 col-md-10 col-lg-11 d-flex">
          <select v-model="filtreLieu" class="form-select ms-4">
            <option value="" disabled selected>Lieux</option>
            <option value="Thiès">Thiès</option>
            <option value="Saint-Louis">Saint-Louis</option>
            <option value="Mbour">Mbour</option>
            <option value="Dakar">Dakar</option>
            <option value="kedougou">kédougou</option>
            <option value="Ziguinchor">Ziguinchor </option>
            <option value="Kaolack">Kaolack</option>
          </select>
          <select v-model="filtreType" class="form-select ms-5 me-5">
            <option value="" disabled selected>Type</option>
            <option value="Appartement">Appartement</option>
            <option value="Villa">Villa</option>
            <option value="Maison">Maison</option>
            <option value="Terrain">Terrain</option>
          </select>
          <select v-model="filtreStatut" class="form-select ms-5">
            <option value=""disabled selected>Statut</option>
            <option value="Disponible">Disponible</option>
            <option value="Vendu">Vendu</option>
          </select>
        </div>
        <div class="row g-4">
          <div v-if="biensFiltres.length === 0" class="alert alert-warning my-4">
            Aucun bien trouvé.
          </div>
          <div v-for="bien in biensFiltres" :key="bien.id" class="col-11">
            <div class="cardBien d-flex flex-column align-items-start shadow-sm p-3 mb-3">
              <h5 class="mb-1">{{ bien.titre }}</h5>
              <p class="mb-1 text-muted">{{ bien.description }}</p>
              <p class="mb-1"><strong>Prix :</strong> {{ bien.prix }} FCFA</p>
              <p class="mb-1"><strong>Surface :</strong> {{ bien.surface }} m²</p>
              <p class="mb-1"><strong>Adresse :</strong> {{ bien.adresse }}</p>
              <p class="mb-1"><strong>Statut :</strong> {{ bien.statut }}</p>
              <p class="mb-1"><strong>Ville :</strong> {{ bien.ville?.nom }}</p>
              <p class="mb-1"><strong>Type :</strong> {{ bien.type_bien?.nom }}</p>
              <p class="mb-1"><strong>Propriétaire :</strong> {{ bien.proprietaire?.nom }}</p>
            </div>
          </div>
        </div>
        <!-- Debug temporaire : affichage du JSON -->
        <pre style="background:#f8f8f8; color:#333; padding:1em; border-radius:8px; margin-top:2em;">
          {{ biens }}
        </pre>
      </div>
    </div>
  </div>
</template>

<script setup>

import { ref, computed, onMounted } from 'vue'
import { biensApi } from '../utils/apiResources'

const filtreLieu = ref("")
const filtreType = ref("")
const filtreStatut = ref("")
const recherche = ref("")

const biens = ref([])
const chargement = ref(true)
const erreur = ref("")

const chargerBiens = async () => {
  chargement.value = true
  try {
    const response = await biensApi.list()
    biens.value = Array.isArray(response.data) ? response.data : response.data.data || []
    console.log('BIENS:', biens.value)
  } catch (err) {
    erreur.value = err.response?.data?.message || 'Erreur lors du chargement des biens.'
    console.error('ERREUR API:', err)
  } finally {
    chargement.value = false
  }
}

onMounted(() => {
  chargerBiens()
})

const biensFiltres = computed(() => {
  return biens.value.filter((bien) => {
    const correspondLieu = !filtreLieu.value || (bien.ville?.nom === filtreLieu.value)
    const correspondType = !filtreType.value || (bien.typeBien?.nom === filtreType.value)
    const correspondStatut = !filtreStatut.value || ((bien.statut ?? (bien.disponible ? 'Disponible' : 'Vendu')) === filtreStatut.value)
    const correspondRecherche = !recherche.value || (bien.titre?.toLowerCase().includes(recherche.value.toLowerCase()))
    return correspondLieu && correspondType && correspondStatut && correspondRecherche
  })
})

</script>

<style scoped>
@media (max-width: 768px) {
  table {
    font-size: 0.85rem;
  }
  .card-header h5 {
    font-size: 1rem;
  }
  
}
.card {
border: none;
  border-radius: 12px;
  overflow: hidden;
}

.table {
  margin: 0;
}

/*partie recherche et biens...*/
.cardBien {
  background-color: white;
  padding: 15px;
  border-radius: 12px;
  border: none;
}
.img-bien {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}
.form-select {
  width:170px;
  height:8vh;
  }
  .form-control{
width: 45rem;
}

</style>
