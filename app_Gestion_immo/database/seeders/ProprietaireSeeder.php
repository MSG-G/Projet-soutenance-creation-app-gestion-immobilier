<?php

namespace Database\Seeders;

use App\Models\Proprietaire;
use Illuminate\Database\Seeder;

class ProprietaireSeeder extends Seeder
{
    public function run(): void
    {
        $proprietaires = [
            [
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@example.com',
                'telephone' => '0123456701',
                'adresse' => '1 rue de Paris, 75001 Paris'
            ],
            [
                'nom' => 'Martin',
                'prenom' => 'Marie',
                'email' => 'marie.martin@example.com',
                'telephone' => '0123456702',
                'adresse' => '2 avenue des Champs-Élysées, 75008 Paris'
            ],
            [
                'nom' => 'Bernard',
                'prenom' => 'Pierre',
                'email' => 'pierre.bernard@example.com',
                'telephone' => '0123456703',
                'adresse' => '3 rue de la Paix, 75002 Paris'
            ],
            [
                'nom' => 'Petit',
                'prenom' => 'Sophie',
                'email' => 'sophie.petit@example.com',
                'telephone' => '0123456704',
                'adresse' => '4 boulevard Haussmann, 75009 Paris'
            ],
            [
                'nom' => 'Robert',
                'prenom' => 'Michel',
                'email' => 'michel.robert@example.com',
                'telephone' => '0123456705',
                'adresse' => '5 rue de Rivoli, 75004 Paris'
            ],
            [
                'nom' => 'Richard',
                'prenom' => 'Anne',
                'email' => 'anne.richard@example.com',
                'telephone' => '0123456706',
                'adresse' => '6 place Vendôme, 75001 Paris'
            ],
            [
                'nom' => 'Moreau',
                'prenom' => 'Philippe',
                'email' => 'philippe.moreau@example.com',
                'telephone' => '0123456707',
                'adresse' => '7 rue du Faubourg Saint-Honoré, 75008 Paris'
            ]
        ];

        foreach ($proprietaires as $proprietaire) {
            Proprietaire::create($proprietaire);
        }
    }
} 