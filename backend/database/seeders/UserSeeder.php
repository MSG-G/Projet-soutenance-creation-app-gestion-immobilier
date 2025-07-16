<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0123456789'
        ]);

        // Agents
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Agent $i",
                'email' => "agent$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'agent',
                'phone' => "0123456" . sprintf("%02d", $i)
            ]);
        }

        // Clients
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Client $i",
                'email' => "client$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => "0987654" . sprintf("%02d", $i)
            ]);
        }
    }
} 