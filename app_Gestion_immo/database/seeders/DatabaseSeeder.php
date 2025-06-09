<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProprietaireSeeder::class,
            VilleSeeder::class,
            TypeBienSeeder::class,
            BienSeeder::class,
            ReservationSeeder::class,
            ContratSeeder::class,
        ]);
    }
}
