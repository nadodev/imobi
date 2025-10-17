@extends('layouts.site')

@section('title', 'Sobre Nós - ' . $paginaSobre->titulo_principal)

@section('meta_description', $paginaSobre->subtitulo ?? 'Conheça nossa história, missão e valores. Somos uma imobiliária comprometida com a excelência no atendimento.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grid\" width=\"10\" height=\"10\" patternUnits=\"userSpaceOnUse\"><path d=\"M 10 0 L 0 0 0 10\" fill=\"none\" stroke=\"white\" stroke-width=\"0.5\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grid)\"/></svg>');"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                        {{ $paginaSobre->titulo_principal }}
                    </h1>
                    @if($paginaSobre->subtitulo)
                        <p class="text-xl lg:text-2xl text-blue-100 leading-relaxed">
                            {{ $paginaSobre->subtitulo }}
                        </p>
                    @endif
                </div>
                
                <div class="prose prose-lg prose-invert max-w-none">
                    {!! nl2br(e($paginaSobre->descricao_principal)) !!}
                </div>
                
                <!-- Quick Stats -->
                @if($paginaSobre->estatisticas)
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
                        @if($paginaSobre->estatisticas['anos_mercado'])
                            <div class="text-center">
                                <div class="text-3xl lg:text-4xl font-bold text-yellow-400">{{ $paginaSobre->estatisticas['anos_mercado'] }}+</div>
                                <div class="text-sm text-blue-200">Anos no Mercado</div>
                            </div>
                        @endif
                        
                        @if($paginaSobre->estatisticas['imoveis_vendidos'])
                            <div class="text-center">
                                <div class="text-3xl lg:text-4xl font-bold text-yellow-400">{{ number_format($paginaSobre->estatisticas['imoveis_vendidos']) }}</div>
                                <div class="text-sm text-blue-200">Imóveis Vendidos</div>
                            </div>
                        @endif
                        
                        @if($paginaSobre->estatisticas['clientes_atendidos'])
                            <div class="text-center">
                                <div class="text-3xl lg:text-4xl font-bold text-yellow-400">{{ number_format($paginaSobre->estatisticas['clientes_atendidos']) }}+</div>
                                <div class="text-sm text-blue-200">Clientes Atendidos</div>
                            </div>
                        @endif
                        
                        @if($paginaSobre->estatisticas['equipe_profissionais'])
                            <div class="text-center">
                                <div class="text-3xl lg:text-4xl font-bold text-yellow-400">{{ $paginaSobre->estatisticas['equipe_profissionais'] }}+</div>
                                <div class="text-sm text-blue-200">Profissionais</div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Image -->
            @if($paginaSobre->imagem_principal_url)
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ $paginaSobre->imagem_principal_url }}" 
                             alt="{{ $paginaSobre->titulo_principal }}"
                             class="w-full h-96 lg:h-[500px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-yellow-400 rounded-full opacity-20"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-blue-400 rounded-full opacity-20"></div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Mission, Vision, Values Section -->
@if($paginaSobre->missao || $paginaSobre->visao || $paginaSobre->valores)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Nossos Pilares
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Os valores que nos guiam e nos fazem ser referência no mercado imobiliário
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Mission -->
            @if($paginaSobre->missao)
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nossa Missão</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $paginaSobre->missao }}
                    </p>
                </div>
            @endif
            
            <!-- Vision -->
            @if($paginaSobre->visao)
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nossa Visão</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $paginaSobre->visao }}
                    </p>
                </div>
            @endif
            
            <!-- Values -->
            @if($paginaSobre->valores)
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nossos Valores</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $paginaSobre->valores }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($paginaSobre->galeria->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Nossa Galeria
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Conheça um pouco mais sobre nossa empresa através das imagens que capturam nossa história e valores
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($paginaSobre->galeria as $index => $imagem)
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <img src="{{ $imagem->imagem_url }}" 
                             alt="{{ $imagem->titulo ?? 'Imagem da galeria' }}"
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            @if($imagem->titulo)
                                <h3 class="text-lg font-semibold mb-2">{{ $imagem->titulo }}</h3>
                            @endif
                            @if($imagem->descricao)
                                <p class="text-sm text-gray-200">{{ Str::limit($imagem->descricao, 100) }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute top-4 right-4 w-8 h-8 bg-white/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
@if($paginaSobre->imagem_equipe_url)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                    Nossa Equipe
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Contamos com uma equipe de profissionais altamente qualificados e experientes, 
                    prontos para oferecer o melhor atendimento e encontrar a solução ideal para suas necessidades imobiliárias.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Profissionais certificados e experientes</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Atendimento personalizado e humanizado</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Conhecimento profundo do mercado local</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Tecnologia de ponta para melhor experiência</span>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ $paginaSobre->imagem_equipe_url }}" 
                         alt="Nossa Equipe"
                         class="w-full h-96 lg:h-[500px] object-cover">
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-6 -left-6 w-24 h-24 bg-blue-500 rounded-full opacity-20"></div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-yellow-400 rounded-full opacity-20"></div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Contact Info Section -->
@if($paginaSobre->dados_empresa)
<section class="py-20 bg-gradient-to-br from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                Entre em Contato
            </h2>
            <p class="text-xl text-blue-100">
                Estamos aqui para ajudá-lo a encontrar o imóvel dos seus sonhos
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @if($paginaSobre->dados_empresa['telefone'])
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Telefone</h3>
                    <p class="text-blue-100">{{ $paginaSobre->dados_empresa['telefone'] }}</p>
                </div>
            @endif
            
            @if($paginaSobre->dados_empresa['email'])
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Email</h3>
                    <p class="text-blue-100">{{ $paginaSobre->dados_empresa['email'] }}</p>
                </div>
            @endif
            
            @if($paginaSobre->dados_empresa['endereco'])
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Endereço</h3>
                    <p class="text-blue-100">{{ $paginaSobre->dados_empresa['endereco'] }}</p>
                </div>
            @endif
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('imoveis.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-yellow-400 text-gray-900 font-semibold rounded-xl hover:bg-yellow-300 transition-colors duration-300 shadow-lg">
                <i class="fas fa-search mr-2"></i>
                Ver Nossos Imóveis
            </a>
        </div>
    </div>
</section>
@endif
@endsection
