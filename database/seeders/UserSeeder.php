<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@imobiliaria.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'admin',
            'ativo' => true,
        ]);

        // Corretor
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@imobiliaria.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'corretor',
            'ativo' => true,
        ]);

        // Corretor
        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@imobiliaria.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'corretor',
            'ativo' => true,
        ]);
    }
}

