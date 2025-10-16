<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finalidade;

class FinalidadeSeeder extends Seeder
{
    public function run(): void
    {
        $finalidades = [
            ['nome' => 'Venda'],
            ['nome' => 'Aluguel'],
        ];

        foreach ($finalidades as $finalidade) {
            Finalidade::create($finalidade);
        }
    }
}

