<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Imovel;
use Carbon\Carbon;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        $imoveis = Imovel::limit(5)->get();

        $agendamentos = [
            [
                'imovel_id' => $imoveis[0]->id,
                'nome_cliente' => 'Carlos Eduardo Silva',
                'telefone' => '(11) 98765-4321',
                'email' => 'carlos.silva@email.com',
                'data_visita' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'horario_visita' => '14:00',
                'mensagem' => 'Gostaria de agendar uma visita para conhecer o imóvel. Tenho interesse em mudança para breve.',
                'status' => 'pendente',
            ],
            [
                'imovel_id' => $imoveis[1]->id,
                'nome_cliente' => 'Ana Paula Oliveira',
                'telefone' => '(11) 97654-3210',
                'email' => 'ana.oliveira@email.com',
                'data_visita' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'horario_visita' => '10:00',
                'mensagem' => 'Tenho interesse no apartamento. Disponibilidade pela manhã.',
                'status' => 'confirmado',
            ],
            [
                'imovel_id' => $imoveis[2]->id,
                'nome_cliente' => 'Roberto Fernandes',
                'telefone' => '(11) 96543-2109',
                'email' => 'roberto.fernandes@email.com',
                'data_visita' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'horario_visita' => '16:00',
                'mensagem' => 'Gostaria de visitar o imóvel com minha esposa no final de semana.',
                'status' => 'pendente',
            ],
            [
                'imovel_id' => $imoveis[3]->id,
                'nome_cliente' => 'Fernanda Costa',
                'telefone' => '(11) 95432-1098',
                'email' => 'fernanda.costa@email.com',
                'data_visita' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'horario_visita' => '15:00',
                'mensagem' => 'Visita realizada. Gostei muito do imóvel!',
                'status' => 'realizado',
                'observacoes' => 'Cliente demonstrou muito interesse. Fazer follow-up.',
            ],
            [
                'imovel_id' => $imoveis[4]->id,
                'nome_cliente' => 'Lucas Pereira',
                'telefone' => '(11) 94321-0987',
                'email' => 'lucas.pereira@email.com',
                'data_visita' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'horario_visita' => '11:00',
                'mensagem' => 'Precisei cancelar devido a compromisso urgente.',
                'status' => 'cancelado',
            ],
        ];

        foreach ($agendamentos as $agendamento) {
            Agendamento::create($agendamento);
        }
    }
}

