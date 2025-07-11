<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            ['nom' => 'Paris', 'code_postal' => '75000', 'region' => 'Île-de-France'],
            ['nom' => 'Lyon', 'code_postal' => '69000', 'region' => 'Auvergne-Rhône-Alpes'],
            ['nom' => 'Marseille', 'code_postal' => '13000', 'region' => 'Provence-Alpes-Côte d\'Azur'],
            ['nom' => 'Bordeaux', 'code_postal' => '33000', 'region' => 'Nouvelle-Aquitaine'],
            ['nom' => 'Lille', 'code_postal' => '59000', 'region' => 'Hauts-de-France'],
            ['nom' => 'Toulouse', 'code_postal' => '31000', 'region' => 'Occitanie'],
            ['nom' => 'Nice', 'code_postal' => '06000', 'region' => 'Provence-Alpes-Côte d\'Azur']
        ];

        foreach ($villes as $ville) {
            Ville::create($ville);
        }
    }
} 