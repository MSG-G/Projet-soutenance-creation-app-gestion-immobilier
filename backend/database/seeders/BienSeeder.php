<?php

namespace Database\Seeders;

use App\Models\Bien;
use Illuminate\Database\Seeder;

class BienSeeder extends Seeder
{
    public function run(): void
    {
        $biens = [
            [
                'titre' => 'Bel appartement lumineux',
                'description' => 'Magnifique appartement avec vue dégagée',
                'prix' => 250000,
                'surface' => 75,
                'adresse' => '10 rue de la Paix',
                'statut' => 'disponible',
                'proprietaire_id' => 1,
                'ville_id' => 1,
                'type_bien_id' => 1
            ],
            [
                'titre' => 'Maison avec jardin',
                'description' => 'Belle maison familiale avec grand jardin',
                'prix' => 450000,
                'surface' => 150,
                'adresse' => '15 avenue des Fleurs',
                'statut' => 'disponible',
                'proprietaire_id' => 2,
                'ville_id' => 2,
                'type_bien_id' => 2
            ],
            [
                'titre' => 'Studio moderne',
                'description' => 'Studio rénové en centre-ville',
                'prix' => 120000,
                'surface' => 30,
                'adresse' => '20 rue du Commerce',
                'statut' => 'disponible',
                'proprietaire_id' => 3,
                'ville_id' => 3,
                'type_bien_id' => 3
            ],
            [
                'titre' => 'Loft design',
                'description' => 'Superbe loft avec hauteur sous plafond',
                'prix' => 380000,
                'surface' => 100,
                'adresse' => '25 rue des Arts',
                'statut' => 'disponible',
                'proprietaire_id' => 4,
                'ville_id' => 4,
                'type_bien_id' => 4
            ],
            [
                'titre' => 'Villa de luxe',
                'description' => 'Villa d\'exception avec piscine',
                'prix' => 850000,
                'surface' => 250,
                'adresse' => '30 avenue du Parc',
                'statut' => 'disponible',
                'proprietaire_id' => 5,
                'ville_id' => 5,
                'type_bien_id' => 5
            ],
            [
                'titre' => 'Duplex contemporain',
                'description' => 'Duplex moderne avec terrasse',
                'prix' => 320000,
                'surface' => 85,
                'adresse' => '35 rue Moderne',
                'statut' => 'disponible',
                'proprietaire_id' => 6,
                'ville_id' => 6,
                'type_bien_id' => 6
            ],
            [
                'titre' => 'Penthouse vue mer',
                'description' => 'Penthouse exceptionnel avec vue panoramique',
                'prix' => 950000,
                'surface' => 180,
                'adresse' => '40 promenade des Anglais',
                'statut' => 'disponible',
                'proprietaire_id' => 7,
                'ville_id' => 7,
                'type_bien_id' => 7
            ]
        ];

        foreach ($biens as $bien) {
            Bien::create($bien);
        }
    }
} 