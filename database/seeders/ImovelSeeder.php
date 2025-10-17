<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imovel;
use App\Models\ImagemImovel;
use App\Models\Tipo;
use App\Models\Finalidade;
use Illuminate\Support\Facades\File;

class ImovelSeeder extends Seeder
{
    public function run(): void
    {
        $tipoVenda = Finalidade::where('slug', 'venda')->first()->id;
        $tipoAluguel = Finalidade::where('slug', 'aluguel')->first()->id;

        $tipoCasa = Tipo::where('slug', 'casa')->first()->id;
        $tipoApto = Tipo::where('slug', 'apartamento')->first()->id;
        $tipoTerreno = Tipo::where('slug', 'terreno')->first()->id;
        $tipoSobrado = Tipo::where('slug', 'sobrado')->first()->id;

        $imoveis = [
            [
                'titulo' => 'Casa Moderna com Piscina - Jardim Europa',
                'descricao' => "Belíssima casa em condomínio fechado com área de lazer completa.\n\nCaracterísticas:\n- Sala ampla com pé direito duplo\n- Cozinha planejada\n- 4 suítes com closet\n- Área gourmet com churrasqueira\n- Piscina aquecida\n- Jardim paisagístico\n- Sistema de segurança\n\nCondomínio oferece: portaria 24h, quadra poliesportiva, playground e salão de festas.",
                'tipo_id' => $tipoCasa,
                'finalidade_id' => $tipoVenda,
                'preco' => 1250000,
                'area_total' => 450,
                'area_construida' => 320,
                'quartos' => 4,
                'banheiros' => 5,
                'vagas' => 4,
                'endereco' => 'Rua das Flores, 123',
                'cidade' => 'São Paulo',
                'bairro' => 'Jardim Europa',
                'cep' => '01234-567',
                'status' => 'ativo',
                'destaque' => true,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Apartamento Alto Padrão Vista Mar - Riviera',
                'descricao' => "Apartamento de luxo em frente ao mar, com acabamento impecável.\n\nDestaques:\n- Vista panorâmica para o mar\n- Sala de estar e jantar integradas\n- Varanda gourmet\n- 3 suítes sendo 1 master com hidro\n- Totalmente mobiliado\n- 2 vagas de garagem\n\nEdifício com: piscina, sauna, academia, salão de festas, churrasqueira e segurança 24h.",
                'tipo_id' => $tipoApto,
                'finalidade_id' => $tipoVenda,
                'preco' => 980000,
                'area_total' => 180,
                'area_construida' => 180,
                'quartos' => 3,
                'banheiros' => 3,
                'vagas' => 2,
                'endereco' => 'Av. Beira Mar, 456',
                'cidade' => 'Bertioga',
                'bairro' => 'Riviera de São Lourenço',
                'cep' => '11250-000',
                'status' => 'ativo',
                'destaque' => true,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Sobrado Novo em Condomínio Fechado - Alphaville',
                'descricao' => "Sobrado novo, nunca habitado, em um dos melhores condomínios de Alphaville.\n\nPronto para morar:\n- Arquitetura moderna\n- 4 suítes com armários planejados\n- Sala com 3 ambientes\n- Lavabo\n- Cozinha americana\n- Área de serviço\n- Quintal com espaço gourmet\n\nCondomínio com infraestrutura completa.",
                'tipo_id' => $tipoSobrado,
                'finalidade_id' => $tipoVenda,
                'preco' => 1750000,
                'area_total' => 380,
                'area_construida' => 285,
                'quartos' => 4,
                'banheiros' => 5,
                'vagas' => 4,
                'endereco' => 'Alameda dos Pinheiros, 789',
                'cidade' => 'Barueri',
                'bairro' => 'Alphaville',
                'cep' => '06454-000',
                'status' => 'ativo',
                'destaque' => true,
                'user_id' => 3,
            ],
            [
                'titulo' => 'Apartamento 2 Dormitórios - Vila Mariana',
                'descricao' => "Apartamento aconchegante em bairro nobre de São Paulo.\n\n- 2 dormitórios\n- Sala\n- Cozinha\n- Banheiro social\n- Área de serviço\n- 1 vaga de garagem\n\nPróximo ao metrô e comércio local.",
                'tipo_id' => $tipoApto,
                'finalidade_id' => $tipoAluguel,
                'preco' => 3200,
                'area_total' => 65,
                'area_construida' => 65,
                'quartos' => 2,
                'banheiros' => 1,
                'vagas' => 1,
                'endereco' => 'Rua Domingos de Morais, 234',
                'cidade' => 'São Paulo',
                'bairro' => 'Vila Mariana',
                'cep' => '04010-100',
                'status' => 'ativo',
                'destaque' => false,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Casa 3 Quartos com Quintal - Tatuapé',
                'descricao' => "Casa térrea em rua tranquila, ideal para famílias.\n\n- 3 quartos sendo 1 suíte\n- Sala de estar e jantar\n- Cozinha americana\n- 2 banheiros\n- Quintal amplo\n- Churrasqueira\n- 2 vagas de garagem",
                'tipo_id' => $tipoCasa,
                'finalidade_id' => $tipoAluguel,
                'preco' => 4500,
                'area_total' => 200,
                'area_construida' => 140,
                'quartos' => 3,
                'banheiros' => 2,
                'vagas' => 2,
                'endereco' => 'Rua Serra de Botucatu, 567',
                'cidade' => 'São Paulo',
                'bairro' => 'Tatuapé',
                'cep' => '03317-000',
                'status' => 'ativo',
                'destaque' => false,
                'user_id' => 3,
            ],
            [
                'titulo' => 'Terreno Comercial - Marginal Tietê',
                'descricao' => "Excelente terreno para investimento comercial.\n\n- Localização privilegiada\n- Frente para avenida movimentada\n- Zoneamento comercial\n- 600m² de área\n- Documentação em ordem\n\nIdeal para construção de galpão, posto de gasolina ou estabelecimento comercial.",
                'tipo_id' => $tipoTerreno,
                'finalidade_id' => $tipoVenda,
                'preco' => 850000,
                'area_total' => 600,
                'area_construida' => 0,
                'quartos' => 0,
                'banheiros' => 0,
                'vagas' => 0,
                'endereco' => 'Av. Marginal Tietê, 1000',
                'cidade' => 'São Paulo',
                'bairro' => 'Vila Leopoldina',
                'cep' => '05083-000',
                'status' => 'ativo',
                'destaque' => false,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Apartamento Studio Mobiliado - Pinheiros',
                'descricao' => "Studio compacto e moderno, totalmente mobiliado.\n\n- Ambiente integrado\n- Cozinha americana equipada\n- Banheiro completo\n- Armários embutidos\n- Ar condicionado\n- Vaga de garagem\n\nPrédio com portaria 24h e elevador.",
                'tipo_id' => $tipoApto,
                'finalidade_id' => $tipoAluguel,
                'preco' => 2800,
                'area_total' => 35,
                'area_construida' => 35,
                'quartos' => 1,
                'banheiros' => 1,
                'vagas' => 1,
                'endereco' => 'Rua dos Pinheiros, 890',
                'cidade' => 'São Paulo',
                'bairro' => 'Pinheiros',
                'cep' => '05422-001',
                'status' => 'ativo',
                'destaque' => false,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Cobertura Duplex - Moema',
                'descricao' => "Cobertura luxuosa em dois andares.\n\n- 4 suítes sendo 1 master\n- Living com 3 ambientes\n- Lavabo\n- Cozinha gourmet\n- Terraço com piscina e churrasqueira\n- Sauna\n- 4 vagas de garagem\n\nPrédio com infraestrutura completa.",
                'tipo_id' => $tipoApto,
                'finalidade_id' => $tipoVenda,
                'preco' => 2500000,
                'area_total' => 380,
                'area_construida' => 380,
                'quartos' => 4,
                'banheiros' => 5,
                'vagas' => 4,
                'endereco' => 'Av. Ibirapuera, 3456',
                'cidade' => 'São Paulo',
                'bairro' => 'Moema',
                'cep' => '04029-200',
                'status' => 'ativo',
                'destaque' => true,
                'user_id' => 3,
            ],
            [
                'titulo' => 'Casa em Condomínio - Granja Viana',
                'descricao' => "Casa maravilhosa em condomínio de alto padrão.\n\n- Terreno de 1000m²\n- Casa de 400m²\n- 5 suítes\n- Piscina com deck\n- Campo de futebol\n- Quadra de tênis\n- Área gourmet completa\n\nContato com a natureza e segurança.",
                'tipo_id' => $tipoCasa,
                'finalidade_id' => $tipoVenda,
                'preco' => 3200000,
                'area_total' => 1000,
                'area_construida' => 400,
                'quartos' => 5,
                'banheiros' => 6,
                'vagas' => 6,
                'endereco' => 'Rua das Acácias, 100',
                'cidade' => 'Cotia',
                'bairro' => 'Granja Viana',
                'cep' => '06709-015',
                'status' => 'ativo',
                'destaque' => true,
                'user_id' => 2,
            ],
            [
                'titulo' => 'Apartamento 3 Quartos - Santo André',
                'descricao' => "Apartamento espaçoso em localização privilegiada.\n\n- 3 dormitórios sendo 1 suíte\n- Sala para 2 ambientes\n- Cozinha planejada\n- 2 banheiros\n- Área de serviço\n- 1 vaga de garagem\n\nPrédio com elevador e portaria.",
                'tipo_id' => $tipoApto,
                'finalidade_id' => $tipoVenda,
                'preco' => 420000,
                'area_total' => 85,
                'area_construida' => 85,
                'quartos' => 3,
                'banheiros' => 2,
                'vagas' => 1,
                'endereco' => 'Av. Industrial, 2000',
                'cidade' => 'Santo André',
                'bairro' => 'Jardim',
                'cep' => '09080-500',
                'status' => 'ativo',
                'destaque' => false,
                'user_id' => 3,
            ],
        ];

        foreach ($imoveis as $imovelData) {
            // Adicionar campos de gestão baseados no status
            $imovelData['status_gestao'] = $imovelData['status'] === 'ativo' ? 'livre' : 
                                          ($imovelData['status'] === 'vendido' ? 'vendido' : 
                                          ($imovelData['status'] === 'alugado' ? 'alugado' : 'indisponivel'));
            
            // Adicionar dados de gestão aleatórios
            $imovelData['numero_chaves'] = rand(1, 3);
            $imovelData['localizacao_chaves'] = ['Escritório', 'Corretor', 'Imóvel'][rand(0, 2)];
            $imovelData['data_revisao_contrato'] = now()->addDays(rand(30, 365))->format('Y-m-d');
            $imovelData['data_vencimento_aluguel'] = $imovelData['finalidade_id'] == $tipoAluguel ? 
                now()->addDays(rand(30, 365))->format('Y-m-d') : null;
            $imovelData['observacoes_gestao'] = 'Imóvel em excelente estado de conservação.';
            $imovelData['corretor_responsavel'] = rand(2, 3); // IDs dos corretores
            
            $imovel = Imovel::create($imovelData);

            // Criar imagens placeholder (você pode substituir por imagens reais)
            $numImagens = rand(3, 5);
            for ($i = 0; $i < $numImagens; $i++) {
                ImagemImovel::create([
                    'imovel_id' => $imovel->id,
                    'caminho' => 'imoveis/placeholder.jpg', // Placeholder - você deve adicionar imagens reais
                    'ordem' => $i
                ]);
            }
        }
    }
}

