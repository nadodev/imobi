<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar diretório de banners se não existir
        if (!file_exists(public_path('storage/banners'))) {
            mkdir(public_path('storage/banners'), 0755, true);
        }

        // Banners de exemplo (você pode substituir por imagens reais)
        $banners = [
            [
                'titulo' => 'Encontre o Imóvel dos Seus Sonhos',
                'descricao' => 'Milhares de opções para venda e aluguel com a melhor assessoria do mercado',
                'imagem' => 'banners/hero-banner-1.jpg', // Você precisará adicionar esta imagem
                'link' => null,
                'posicao' => 'hero',
                'ordem' => 1,
                'ativo' => true,
                'data_inicio' => null,
                'data_fim' => null,
            ],
            [
                'titulo' => 'Apartamentos de Luxo',
                'descricao' => 'Conheça nossos apartamentos de alto padrão com vista para o mar',
                'imagem' => 'banners/hero-banner-2.jpg',
                'link' => '/imoveis?tipo=apartamento',
                'posicao' => 'hero',
                'ordem' => 2,
                'ativo' => true,
                'data_inicio' => null,
                'data_fim' => null,
            ],
            [
                'titulo' => 'Casas com Piscina',
                'descricao' => 'Viva o sonho da casa própria com piscina e área de lazer completa',
                'imagem' => 'banners/hero-banner-3.jpg',
                'link' => '/imoveis?finalidade=venda',
                'posicao' => 'hero',
                'ordem' => 3,
                'ativo' => true,
                'data_inicio' => null,
                'data_fim' => null,
            ],
            [
                'titulo' => 'Apartamentos de Luxo',
                'descricao' => 'Conheça nossos apartamentos de alto padrão',
                'imagem' => 'banners/sidebar-banner-1.jpg',
                'link' => '/imoveis?tipo=apartamento',
                'posicao' => 'sidebar',
                'ordem' => 1,
                'ativo' => true,
                'data_inicio' => null,
                'data_fim' => null,
            ],
            [
                'titulo' => 'Casas com Piscina',
                'descricao' => 'Viva o sonho da casa própria com piscina',
                'imagem' => 'banners/sidebar-banner-2.jpg',
                'link' => '/imoveis?finalidade=venda',
                'posicao' => 'sidebar',
                'ordem' => 2,
                'ativo' => true,
                'data_inicio' => null,
                'data_fim' => null,
            ],
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
        }
    }
}
