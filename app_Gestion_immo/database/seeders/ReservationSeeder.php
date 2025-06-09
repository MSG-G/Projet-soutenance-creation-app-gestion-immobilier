<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // Les clients ont les IDs 5, 6, 7
        // Les agents ont les IDs 2, 3, 4
        $reservations = [
            [
                'date_visite' => Carbon::now()->addDays(2),
                'etat' => 'planifiee',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 1
            ],
            [
                'date_visite' => Carbon::now()->addDays(3),
                'etat' => 'confirmee',
                'client_id' => 6,
                'agent_id' => 3,
                'bien_id' => 2
            ],
            [
                'date_visite' => Carbon::now()->addDays(4),
                'etat' => 'planifiee',
                'client_id' => 7,
                'agent_id' => 4,
                'bien_id' => 3
            ],
            [
                'date_visite' => Carbon::now()->addDays(5),
                'etat' => 'planifiee',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 4
            ],
            [
                'date_visite' => Carbon::now()->addDays(6),
                'etat' => 'confirmee',
                'client_id' => 6,
                'agent_id' => 3,
                'bien_id' => 5
            ],
            [
                'date_visite' => Carbon::now()->addDays(7),
                'etat' => 'planifiee',
                'client_id' => 7,
                'agent_id' => 4,
                'bien_id' => 6
            ],
            [
                'date_visite' => Carbon::now()->addDays(8),
                'etat' => 'planifiee',
                'client_id' => 5,
                'agent_id' => 2,
                'bien_id' => 7
            ]
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
} 