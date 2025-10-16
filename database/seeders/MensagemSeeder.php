<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mensagem;
use App\Models\Imovel;

class MensagemSeeder extends Seeder
{
    public function run(): void
    {
        $imoveis = Imovel::limit(3)->get();

        $mensagens = [
            [
                'imovel_id' => $imoveis[0]->id ?? null,
                'nome' => 'Pedro Henrique',
                'email' => 'pedro.henrique@email.com',
                'telefone' => '(11) 99876-5432',
                'assunto' => 'Dúvida sobre financiamento',
                'mensagem' => 'Olá, gostaria de saber se vocês trabalham com financiamento para este imóvel. Quais são as condições?',
                'status' => 'nao_lida',
            ],
            [
                'imovel_id' => $imoveis[1]->id ?? null,
                'nome' => 'Juliana Martins',
                'email' => 'juliana.martins@email.com',
                'telefone' => '(11) 98765-4321',
                'assunto' => 'Interesse no apartamento',
                'mensagem' => 'Tenho interesse no apartamento anunciado. Ele aceita animais de estimação? Qual o valor do condomínio?',
                'status' => 'lida',
            ],
            [
                'imovel_id' => null,
                'nome' => 'Ricardo Alves',
                'email' => 'ricardo.alves@email.com',
                'telefone' => '(11) 97654-3210',
                'assunto' => 'Procuro casa em condomínio',
                'mensagem' => 'Estou procurando uma casa em condomínio fechado na região de Alphaville, com 3 ou 4 quartos. Orçamento até R$ 800.000. Vocês têm opções disponíveis?',
                'status' => 'nao_lida',
            ],
            [
                'imovel_id' => $imoveis[2]->id ?? null,
                'nome' => 'Mariana Souza',
                'email' => 'mariana.souza@email.com',
                'telefone' => '(11) 96543-2109',
                'assunto' => 'Informações sobre documentação',
                'mensagem' => 'Gostaria de saber quais documentos são necessários para iniciar o processo de compra deste imóvel.',
                'status' => 'respondida',
                'resposta' => 'Olá Mariana! Para iniciar o processo de compra, você precisará dos seguintes documentos: RG, CPF, comprovante de residência, comprovante de renda e certidão de casamento (se aplicável). Nossa equipe está à disposição para ajudá-la em todo o processo. Aguardamos seu contato!',
                'respondido_em' => now()->subHours(2),
                'respondido_por' => 1,
            ],
            [
                'imovel_id' => null,
                'nome' => 'Paulo Roberto',
                'email' => 'paulo.roberto@email.com',
                'telefone' => '(11) 95432-1098',
                'assunto' => 'Avaliação de imóvel',
                'mensagem' => 'Tenho um apartamento para vender e gostaria de uma avaliação. Vocês fazem este tipo de serviço? Como funciona?',
                'status' => 'nao_lida',
            ],
        ];

        foreach ($mensagens as $mensagem) {
            Mensagem::create($mensagem);
        }
    }
}

