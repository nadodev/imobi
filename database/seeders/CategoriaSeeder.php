<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Geral',
                'descricao' => 'Artigos gerais sobre o mercado imobiliário',
                'cor' => '#3B82F6',
                'icone' => 'fas fa-home',
                'ativa' => true,
                'ordem' => 1,
            ],
            [
                'nome' => 'Dicas',
                'descricao' => 'Dicas práticas para compradores, vendedores e investidores',
                'cor' => '#10B981',
                'icone' => 'fas fa-lightbulb',
                'ativa' => true,
                'ordem' => 2,
            ],
            [
                'nome' => 'Mercado',
                'descricao' => 'Análises e tendências do mercado imobiliário',
                'cor' => '#F59E0B',
                'icone' => 'fas fa-chart-line',
                'ativa' => true,
                'ordem' => 3,
            ],
            [
                'nome' => 'Financiamento',
                'descricao' => 'Informações sobre financiamento imobiliário e crédito',
                'cor' => '#8B5CF6',
                'icone' => 'fas fa-credit-card',
                'ativa' => true,
                'ordem' => 4,
            ],
            [
                'nome' => 'Investimento',
                'descricao' => 'Estratégias e oportunidades de investimento imobiliário',
                'cor' => '#EF4444',
                'icone' => 'fas fa-chart-pie',
                'ativa' => true,
                'ordem' => 5,
            ],
            [
                'nome' => 'Decoração',
                'descricao' => 'Dicas de decoração e organização de espaços',
                'cor' => '#EC4899',
                'icone' => 'fas fa-palette',
                'ativa' => true,
                'ordem' => 6,
            ],
            [
                'nome' => 'Legislação',
                'descricao' => 'Informações sobre leis e regulamentações imobiliárias',
                'cor' => '#6B7280',
                'icone' => 'fas fa-gavel',
                'ativa' => true,
                'ordem' => 7,
            ],
        ];

        foreach ($categorias as $categoriaData) {
            Categoria::create($categoriaData);
        }
    }
}