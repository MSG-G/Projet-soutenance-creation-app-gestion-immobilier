<?php

namespace Database\Seeders;

use App\Models\TypeBien;
use Illuminate\Database\Seeder;

class TypeBienSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['nom' => 'Appartement', 'description' => 'Logement dans un immeuble collectif'],
            ['nom' => 'Maison', 'description' => 'Maison individuelle'],
            ['nom' => 'Studio', 'description' => 'Petit appartement d\'une seule pièce'],
            ['nom' => 'Loft', 'description' => 'Grand espace ouvert aménagé'],
            ['nom' => 'Villa', 'description' => 'Grande maison luxueuse'],
            ['nom' => 'Duplex', 'description' => 'Appartement sur deux niveaux'],
            ['nom' => 'Penthouse', 'description' => 'Appartement de luxe au dernier étage']
        ];

        foreach ($types as $type) {
            TypeBien::create($type);
        }
    }
} 