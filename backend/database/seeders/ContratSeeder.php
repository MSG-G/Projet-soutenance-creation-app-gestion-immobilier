<?php

namespace Database\Seeders;

use App\Models\Contrat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContratSeeder extends Seeder
{
    public function run(): void
    {
        // Les clients ont les IDs 5, 6, 7
        // Les agents ont les IDs 2, 3, 4
        $contrats = [
            [
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addYears(1),
                'montant' => 1200.00,
                'type' => 'location',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 1
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => null,
                'montant' => 450000.00,
                'type' => 'vente',
                'client_id' => 6,
                'agent_id' => 3,
                'bien_id' => 2
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addYears(1),
                'montant' => 800.00,
                'type' => 'location',
                'client_id' => 7,
                'agent_id' => 4,
                'bien_id' => 3
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => null,
                'montant' => 380000.00,
                'type' => 'vente',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 4
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addYears(1),
                'montant' => 2500.00,
                'type' => 'location',
                'client_id' => 6,
                'agent_id' => 3,
                'bien_id' => 5
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => null,
                'montant' => 320000.00,
                'type' => 'vente',
                'client_id' => 7,
                'agent_id' => 4,
                'bien_id' => 6
            ],
            [
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addYears(1),
                'montant' => 3000.00,
                'type' => 'location',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 7
            ]
        ];

        foreach ($contrats as $contrat) {
            Contrat::create($contrat);
        }
    }
} 