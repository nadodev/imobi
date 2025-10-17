<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Tarefa;
use App\Models\Visualizacao;
use App\Models\Imovel;
use App\Models\User;
use Carbon\Carbon;

class CRMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuários e imóveis existentes
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        $imoveis = Imovel::all();
        
        if ($corretores->isEmpty() || $imoveis->isEmpty()) {
            $this->command->info('Necessário ter corretores e imóveis cadastrados primeiro.');
            return;
        }

        // Criar leads de exemplo
        $this->createLeads($corretores, $imoveis);
        
        // Criar tarefas de exemplo
        $this->createTarefas($corretores, $imoveis);
        
        // Criar visualizações de exemplo
        $this->createVisualizacoes($imoveis);
        
        $this->command->info('Dados do CRM criados com sucesso!');
    }
    
    private function createLeads($corretores, $imoveis)
    {
        $leads = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'telefone' => '(11) 99999-1111',
                'origem' => 'site',
                'status' => 'novo',
                'tipo_interesse' => 'compra',
                'valor_interesse' => 500000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Vila Madalena',
                'quartos_interesse' => 3,
                'banheiros_interesse' => 2,
                'observacoes' => 'Interessado em apartamento com varanda',
                'proximo_followup' => now()->addDays(2),
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'telefone' => '(11) 99999-2222',
                'origem' => 'whatsapp',
                'status' => 'contatado',
                'tipo_interesse' => 'aluguel',
                'valor_interesse' => 2500.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Pinheiros',
                'quartos_interesse' => 2,
                'banheiros_interesse' => 1,
                'observacoes' => 'Procura imóvel próximo ao metrô',
                'ultimo_contato' => now()->subDays(1),
                'proximo_followup' => now()->addDays(3),
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'telefone' => '(11) 99999-3333',
                'origem' => 'instagram',
                'status' => 'qualificado',
                'tipo_interesse' => 'compra',
                'valor_interesse' => 800000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Jardins',
                'quartos_interesse' => 4,
                'banheiros_interesse' => 3,
                'observacoes' => 'Investidor, procura imóvel para alugar',
                'ultimo_contato' => now()->subDays(2),
                'proximo_followup' => now()->addDays(1),
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@email.com',
                'telefone' => '(11) 99999-4444',
                'origem' => 'facebook',
                'status' => 'proposta',
                'tipo_interesse' => 'venda',
                'valor_interesse' => 600000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Moema',
                'quartos_interesse' => 3,
                'banheiros_interesse' => 2,
                'observacoes' => 'Quer vender apartamento herdado',
                'ultimo_contato' => now()->subHours(6),
                'proximo_followup' => now()->addDays(1),
            ],
            [
                'nome' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@email.com',
                'telefone' => '(11) 99999-5555',
                'origem' => 'indicacao',
                'status' => 'negociacao',
                'tipo_interesse' => 'compra',
                'valor_interesse' => 450000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Vila Olímpia',
                'quartos_interesse' => 2,
                'banheiros_interesse' => 2,
                'observacoes' => 'Indicado por cliente satisfeito',
                'ultimo_contato' => now()->subHours(2),
                'proximo_followup' => now()->addHours(6),
            ],
            [
                'nome' => 'Lucia Mendes',
                'email' => 'lucia.mendes@email.com',
                'telefone' => '(11) 99999-6666',
                'origem' => 'site',
                'status' => 'fechado',
                'tipo_interesse' => 'aluguel',
                'valor_interesse' => 3000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Itaim Bibi',
                'quartos_interesse' => 3,
                'banheiros_interesse' => 2,
                'observacoes' => 'Contrato assinado, cliente satisfeita',
                'ultimo_contato' => now()->subDays(5),
            ],
            [
                'nome' => 'Roberto Alves',
                'email' => 'roberto.alves@email.com',
                'telefone' => '(11) 99999-7777',
                'origem' => 'whatsapp',
                'status' => 'perdido',
                'tipo_interesse' => 'compra',
                'valor_interesse' => 700000.00,
                'cidade_interesse' => 'São Paulo',
                'bairro_interesse' => 'Brooklin',
                'quartos_interesse' => 3,
                'banheiros_interesse' => 2,
                'observacoes' => 'Comprou com outra imobiliária',
                'ultimo_contato' => now()->subDays(10),
            ],
        ];
        
        foreach ($leads as $leadData) {
            $leadData['user_id'] = 1; // Admin
            $leadData['corretor_id'] = $corretores->random()->id;
            $leadData['imovel_id'] = $imoveis->random()->id;
            
            Lead::create($leadData);
        }
    }
    
    private function createTarefas($corretores, $imoveis)
    {
        $tarefas = [
            [
                'titulo' => 'Ligar para João Silva',
                'descricao' => 'Retornar ligação sobre apartamento na Vila Madalena',
                'tipo' => 'ligacao',
                'prioridade' => 'alta',
                'status' => 'pendente',
                'data_vencimento' => now()->addHours(2),
            ],
            [
                'titulo' => 'Enviar proposta para Ana Costa',
                'descricao' => 'Preparar proposta de venda do apartamento em Moema',
                'tipo' => 'proposta',
                'prioridade' => 'urgente',
                'status' => 'em_andamento',
                'data_vencimento' => now()->addHours(4),
            ],
            [
                'titulo' => 'Agendar visita com Pedro Oliveira',
                'descricao' => 'Mostrar apartamento nos Jardins',
                'tipo' => 'visita',
                'prioridade' => 'media',
                'status' => 'pendente',
                'data_vencimento' => now()->addDays(1),
            ],
            [
                'titulo' => 'Enviar email para Maria Santos',
                'descricao' => 'Enviar lista de imóveis para aluguel em Pinheiros',
                'tipo' => 'email',
                'prioridade' => 'baixa',
                'status' => 'pendente',
                'data_vencimento' => now()->addDays(2),
            ],
            [
                'titulo' => 'Follow-up com Carlos Ferreira',
                'descricao' => 'Verificar interesse na negociação',
                'tipo' => 'followup',
                'prioridade' => 'alta',
                'status' => 'pendente',
                'data_vencimento' => now()->addHours(6),
            ],
            [
                'titulo' => 'Revisar contrato de aluguel',
                'descricao' => 'Verificar vencimento do contrato do apartamento em Itaim',
                'tipo' => 'outro',
                'prioridade' => 'media',
                'status' => 'concluida',
                'data_vencimento' => now()->subDays(1),
                'data_conclusao' => now()->subHours(2),
            ],
        ];
        
        foreach ($tarefas as $tarefaData) {
            $tarefaData['user_id'] = $corretores->random()->id;
            $tarefaData['criado_por'] = 1; // Admin
            $tarefaData['imovel_id'] = $imoveis->random()->id;
            
            Tarefa::create($tarefaData);
        }
    }
    
    private function createVisualizacoes($imoveis)
    {
        $origens = ['site', 'whatsapp', 'instagram', 'facebook', 'google'];
        $cidades = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Salvador', 'Brasília'];
        $estados = ['SP', 'RJ', 'MG', 'BA', 'DF'];
        
        // Criar visualizações para os últimos 30 dias
        for ($i = 0; $i < 30; $i++) {
            $data = now()->subDays($i);
            $visualizacoesPorDia = rand(5, 25);
            
            for ($j = 0; $j < $visualizacoesPorDia; $j++) {
                Visualizacao::create([
                    'imovel_id' => $imoveis->random()->id,
                    'ip_address' => '192.168.1.' . rand(1, 254),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'referer' => rand(0, 1) ? 'https://google.com' : null,
                    'origem' => $origens[array_rand($origens)],
                    'cidade' => $cidades[array_rand($cidades)],
                    'estado' => $estados[array_rand($estados)],
                    'pais' => 'BR',
                    'visualizado_em' => $data->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                ]);
            }
        }
    }
}