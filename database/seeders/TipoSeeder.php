<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nome' => 'Casa', 'ordem' => 1],
            ['nome' => 'Apartamento', 'ordem' => 2],
            ['nome' => 'Terreno', 'ordem' => 3],
            ['nome' => 'Chácara', 'ordem' => 4],
            ['nome' => 'Sala Comercial', 'ordem' => 5],
            ['nome' => 'Galpão', 'ordem' => 6],
            ['nome' => 'Cobertura', 'ordem' => 7],
            ['nome' => 'Sobrado', 'ordem' => 8],
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}

