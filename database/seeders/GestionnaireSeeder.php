<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur avec le rôle "gestionnaire"
        User::create([
            'name' => 'Gestionnaire Principal',
            'email' => 'gestionnaire@isiburger.com',
            'password' => Hash::make('password123'), // Assurez-vous de définir un mot de passe sécurisé
            'role' => 'gestionnaire', // Attribuer le rôle gestionnaire
        ]);
    }
}