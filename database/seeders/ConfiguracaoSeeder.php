<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;

class ConfiguracaoSeeder extends Seeder
{
    public function run(): void
    {
        $configuracoes = [
            // Dados da empresa
            ['chave' => 'nome_empresa', 'valor' => 'Imobiliária Prime', 'grupo' => 'geral'],
            ['chave' => 'telefone', 'valor' => '(11) 3456-7890', 'grupo' => 'geral'],
            ['chave' => 'email', 'valor' => 'contato@imobiliariaprime.com.br', 'grupo' => 'geral'],
            ['chave' => 'endereco', 'valor' => 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP, 01310-100', 'grupo' => 'geral'],
            
            // Redes sociais
            ['chave' => 'facebook', 'valor' => 'https://facebook.com/imobiliariaprime', 'grupo' => 'geral'],
            ['chave' => 'instagram', 'valor' => 'https://instagram.com/imobiliariaprime', 'grupo' => 'geral'],
            ['chave' => 'whatsapp', 'valor' => '5511999999999', 'grupo' => 'geral'],
            
            // Textos institucionais
            ['chave' => 'sobre', 'valor' => 'A Imobiliária Prime é referência no mercado imobiliário há mais de 20 anos. Nossa missão é conectar pessoas aos seus lares dos sonhos, oferecendo um atendimento personalizado e soluções completas em compra, venda e locação de imóveis.', 'grupo' => 'geral'],
            
            ['chave' => 'politica_privacidade', 'valor' => 'Esta política de privacidade estabelece como a Imobiliária Prime usa e protege qualquer informação que você nos fornece quando usa este website. Estamos comprometidos em garantir que sua privacidade seja protegida.', 'grupo' => 'geral'],
            
            // Integrações
            ['chave' => 'google_maps_api', 'valor' => '', 'grupo' => 'geral'],
            
            // Coordenadas para o mapa de contato (São Paulo - Av. Paulista)
            ['chave' => 'latitude', 'valor' => '-23.5613', 'grupo' => 'geral'],
            ['chave' => 'longitude', 'valor' => '-46.6563', 'grupo' => 'geral'],
        ];

        foreach ($configuracoes as $config) {
            Configuracao::create($config);
        }
    }
}

