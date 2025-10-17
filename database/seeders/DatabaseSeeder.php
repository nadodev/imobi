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
            TipoSeeder::class,
            FinalidadeSeeder::class,
            ImovelSeeder::class,
            AgendamentoSeeder::class,
            MensagemSeeder::class,
            ConfiguracaoSeeder::class,
            BannerSeeder::class,
            CRMSeeder::class,
            CategoriaSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
