<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Imovel;
use Faker\Factory as Faker;

class AgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $imoveis = Imovel::all();
        
        if ($imoveis->isEmpty()) {
            $this->command->info('Nenhum imóvel encontrado. Execute primeiro o ImovelSeeder.');
            return;
        }
        
        // Criar agendamentos para os próximos 30 dias
        for ($i = 0; $i < 20; $i++) {
            $dataVisita = now()->addDays(rand(1, 30));
            $horarios = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
            
            Agendamento::create([
                'imovel_id' => $imoveis->random()->id,
                'nome_cliente' => $faker->name,
                'telefone' => $faker->phoneNumber,
                'email' => $faker->email,
                'data_visita' => $dataVisita,
                'horario_visita' => $horarios[array_rand($horarios)],
                'mensagem' => $faker->sentence(10),
                'status' => $faker->randomElement(['pendente', 'confirmado', 'cancelado', 'realizado']),
                'observacoes' => $faker->optional(0.3)->sentence(8),
            ]);
        }
        
        $this->command->info('Agendamentos criados com sucesso!');
    }
}