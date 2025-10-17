<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artigo;
use App\Models\User;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar usuário admin
        $admin = User::where('tipo_usuario', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        $artigos = [
            [
                'titulo' => 'Como Escolher o Imóvel Ideal para Investimento',
                'resumo' => 'Descubra os principais fatores que devem ser considerados na hora de escolher um imóvel para investimento e maximizar seus retornos.',
                'conteudo' => 'Investir em imóveis é uma das formas mais seguras e rentáveis de fazer seu dinheiro trabalhar para você. No entanto, escolher o imóvel certo é fundamental para o sucesso do seu investimento.

**Fatores Importantes:**

1. **Localização**: A localização é o fator mais importante. Imóveis em áreas bem localizadas tendem a valorizar mais e ter maior liquidez.

2. **Potencial de Valorização**: Analise o histórico de valorização da região e as perspectivas futuras de desenvolvimento.

3. **Renda de Aluguel**: Calcule o potencial de renda de aluguel comparando com imóveis similares na região.

4. **Condições do Imóvel**: Verifique a estrutura, instalações elétricas, hidráulicas e a necessidade de reformas.

5. **Documentação**: Certifique-se de que toda a documentação está em dia e o imóvel está livre de pendências.

**Dicas Práticas:**

- Visite o imóvel em diferentes horários
- Converse com vizinhos sobre a região
- Verifique a infraestrutura local
- Analise o histórico de aluguéis da região
- Considere os custos de manutenção

Lembre-se: um bom investimento imobiliário é aquele que se alinha com seus objetivos financeiros e oferece boa relação risco/retorno.',
                'categoria' => 'investimento',
                'tags' => ['investimento', 'imóveis', 'aluguel', 'valorização'],
                'status' => 'publicado',
                'destaque' => true,
                'publicado_em' => now()->subDays(5),
                'visualizacoes' => 1250,
            ],
            [
                'titulo' => 'Financiamento Imobiliário: Guia Completo 2024',
                'resumo' => 'Tudo que você precisa saber sobre financiamento imobiliário, tipos de financiamento, documentação necessária e dicas para conseguir as melhores condições.',
                'conteudo' => 'O financiamento imobiliário é uma das principais formas de adquirir um imóvel no Brasil. Com as taxas de juros em queda, é um excelente momento para investir.

**Tipos de Financiamento:**

1. **Sistema de Amortização Constante (SAC)**: A amortização é fixa, mas os juros diminuem ao longo do tempo.

2. **Sistema de Prestação Constante (Tabela Price)**: A prestação é fixa durante todo o financiamento.

3. **Sistema de Amortização Mista (SAM)**: Combina características do SAC e da Tabela Price.

**Documentação Necessária:**

- CPF e RG
- Comprovante de renda
- Comprovante de residência
- Comprovante de estado civil
- Documentos do imóvel
- ITR ou IPTU

**Dicas para Conseguir Melhores Condições:**

- Mantenha um bom score de crédito
- Tenha uma entrada de pelo menos 20%
- Compare propostas de diferentes bancos
- Considere usar o FGTS como entrada
- Negocie as taxas e condições

**Benefícios do Financiamento:**

- Possibilidade de adquirir um imóvel sem ter todo o valor
- Taxas de juros menores que outros tipos de crédito
- Possibilidade de usar o FGTS
- Imóvel como garantia do financiamento

Lembre-se de fazer uma análise cuidadosa de sua capacidade de pagamento antes de se comprometer com um financiamento.',
                'categoria' => 'financiamento',
                'tags' => ['financiamento', 'imóveis', 'crédito', 'FGTS'],
                'status' => 'publicado',
                'destaque' => true,
                'publicado_em' => now()->subDays(3),
                'visualizacoes' => 980,
            ],
            [
                'titulo' => '5 Dicas para Decorar seu Apartamento Pequeno',
                'resumo' => 'Aprenda como aproveitar melhor o espaço em apartamentos pequenos com dicas práticas de decoração e organização.',
                'conteudo' => 'Morar em um apartamento pequeno não significa abrir mão do conforto e da beleza. Com algumas dicas simples, é possível criar um ambiente funcional e aconchegante.

**1. Use Cores Claras**

Cores claras ajudam a dar sensação de amplitude. Prefira tons de branco, bege, cinza claro e pastéis nas paredes e móveis principais.

**2. Móveis Multifuncionais**

Invista em móveis que tenham mais de uma função:
- Sofá-cama
- Mesa que vira escrivaninha
- Cama com gavetas embaixo
- Pufes com compartimento interno

**3. Aproveite a Altura**

Use prateleiras e estantes altas para aproveitar o espaço vertical. Isso ajuda a manter o chão livre e organizado.

**4. Espelhos Estratégicos**

Espelhos criam a ilusão de espaço maior. Coloque-os em paredes opostas às janelas para refletir a luz natural.

**5. Organização é Fundamental**

Mantenha tudo organizado:
- Use caixas organizadoras
- Tenha um lugar para cada coisa
- Evite acúmulo de objetos desnecessários
- Use gavetas e prateleiras de forma inteligente

**Dicas Extras:**

- Use cortinas leves para não sobrecarregar o ambiente
- Prefira móveis com pés para dar sensação de leveza
- Use plantas para trazer vida ao ambiente
- Mantenha o ambiente sempre limpo e organizado

Com essas dicas, seu apartamento pequeno pode se tornar um lar funcional e acolhedor!',
                'categoria' => 'dicas',
                'tags' => ['decoração', 'apartamento', 'organização', 'pequenos espaços'],
                'status' => 'publicado',
                'destaque' => false,
                'publicado_em' => now()->subDays(7),
                'visualizacoes' => 750,
            ],
            [
                'titulo' => 'Mercado Imobiliário 2024: Tendências e Perspectivas',
                'resumo' => 'Análise completa do mercado imobiliário brasileiro em 2024, com tendências, perspectivas e oportunidades de investimento.',
                'conteudo' => 'O mercado imobiliário brasileiro em 2024 apresenta cenários interessantes para investidores e compradores. Com a queda nas taxas de juros e programas governamentais, o setor mostra sinais de recuperação.

**Principais Tendências:**

1. **Digitalização do Setor**: A tecnologia está transformando a forma como compramos e vendemos imóveis, com tours virtuais e plataformas online.

2. **Sustentabilidade**: Imóveis com certificações ambientais e tecnologias sustentáveis estão ganhando destaque.

3. **Flexibilidade**: Espaços adaptáveis e coworking estão se tornando mais populares.

4. **Localização Premium**: Áreas bem localizadas continuam sendo as mais valorizadas.

**Perspectivas por Região:**

- **São Paulo**: Mercado aquecido, especialmente em áreas centrais
- **Rio de Janeiro**: Recuperação gradual, foco em Zona Sul e Barra
- **Brasília**: Estabilidade com crescimento moderado
- **Cidades do Interior**: Crescimento acelerado devido ao home office

**Oportunidades de Investimento:**

- Imóveis para aluguel em áreas universitárias
- Apartamentos pequenos em centros urbanos
- Imóveis comerciais em bairros em crescimento
- Terrenos em regiões com expansão planejada

**Fatores que Influenciam o Mercado:**

- Taxa de juros
- Política econômica
- Crescimento populacional
- Infraestrutura urbana
- Emprego e renda

**Dicas para Investidores:**

- Faça uma análise detalhada da região
- Considere o potencial de valorização
- Avalie a liquidez do investimento
- Mantenha-se informado sobre mudanças regulatórias

O mercado imobiliário em 2024 oferece oportunidades interessantes para quem souber analisar e investir com sabedoria.',
                'categoria' => 'mercado',
                'tags' => ['mercado imobiliário', 'investimento', 'tendências', '2024'],
                'status' => 'publicado',
                'destaque' => true,
                'publicado_em' => now()->subDays(1),
                'visualizacoes' => 2100,
            ],
            [
                'titulo' => 'Como Organizar a Mudança para seu Novo Lar',
                'resumo' => 'Guia completo para organizar uma mudança sem estresse, com checklist, dicas práticas e cronograma de atividades.',
                'conteudo' => 'Mudar de casa pode ser um processo estressante, mas com organização e planejamento, é possível tornar essa experiência mais tranquila e eficiente.

**Planejamento Pré-Mudança (2-3 meses antes):**

1. **Defina a Data**: Escolha uma data que funcione para todos os envolvidos
2. **Contrate uma Empresa**: Pesquise e contrate uma empresa de mudanças confiável
3. **Organize a Documentação**: Separe todos os documentos importantes
4. **Faça um Inventário**: Liste todos os seus pertences

**1 Mês Antes:**

- Comece a separar objetos que não usa mais
- Organize documentos e papéis importantes
- Notifique mudança de endereço para bancos, cartões, etc.
- Reserve elevador e vaga de estacionamento no novo local

**2 Semanas Antes:**

- Comece a embalar objetos não essenciais
- Organize roupas por estação
- Separe objetos frágeis
- Prepare um kit de primeiros dias

**1 Semana Antes:**

- Embalagem dos objetos essenciais
- Limpeza do imóvel atual
- Confirmação com a empresa de mudanças
- Preparação do novo imóvel

**Dia da Mudança:**

- Supervisione o carregamento
- Verifique se todos os objetos foram carregados
- Faça uma limpeza final
- Confirme a entrega no novo endereço

**Kit de Primeiros Dias:**

- Roupas para 3-4 dias
- Produtos de higiene pessoal
- Utensílios básicos de cozinha
- Ferramentas básicas
- Medicamentos
- Documentos importantes

**Dicas Importantes:**

- Fotografe objetos frágeis antes de embalar
- Use etiquetas coloridas para organizar
- Mantenha um inventário atualizado
- Contrate seguro para objetos de valor
- Tenha um plano B para imprevistos

Com organização e planejamento, sua mudança será muito mais tranquila!',
                'categoria' => 'dicas',
                'tags' => ['mudança', 'organização', 'planejamento', 'dicas práticas'],
                'status' => 'publicado',
                'destaque' => false,
                'publicado_em' => now()->subDays(10),
                'visualizacoes' => 650,
            ],
        ];

        foreach ($artigos as $artigoData) {
            $artigoData['user_id'] = $admin->id;
            $artigoData['slug'] = \Illuminate\Support\Str::slug($artigoData['titulo']);
            
            Artigo::create($artigoData);
        }
    }
}