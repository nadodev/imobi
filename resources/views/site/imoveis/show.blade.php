@extends('layouts.site')

@section('title', $imovel->titulo . ' - ' . $imovel->preco_formatado . ' | Sistema Imobiliária')
@section('description', $imovel->resumo ?? 'Imóvel ' . $imovel->tipo->nome . ' em ' . $imovel->bairro . ', ' . $imovel->cidade . '. ' . $imovel->preco_formatado . '. ' . ($imovel->quartos > 0 ? $imovel->quartos . ' quartos' : '') . ($imovel->banheiros > 0 ? ', ' . $imovel->banheiros . ' banheiros' : '') . ($imovel->area_total ? ', ' . $imovel->area_total . 'm²' : ''))
@section('keywords', $imovel->tipo->nome . ', ' . $imovel->finalidade->nome . ', ' . $imovel->bairro . ', ' . $imovel->cidade . ', imóvel, ' . $imovel->preco_formatado)
@section('og_image', $imovel->imagemPrincipal ? asset('storage/' . $imovel->imagemPrincipal->caminho) : asset('images/og-default.jpg'))

@section('title', $imovel->titulo . ' - Imobiliária')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex text-sm">
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('imoveis.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Imóveis</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600 font-medium">{{ $imovel->codigo }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2">
                <!-- Galeria de Imagens -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
                    @if($imovel->imagens->count() > 0)
                        <div class="relative group" id="gallery-container" style="cursor: grab;">
                            <!-- Imagem Principal -->
                            <div class="relative overflow-hidden">
                                <img id="main-image" 
                                     src="{{ asset('storage/' . $imovel->imagens->first()->caminho) }}" 
                                 alt="{{ $imovel->titulo }}" 
                                     class="w-full h-96 md:h-[500px] object-cover transition-all duration-500 ease-in-out cursor-grab"
                                     id="main-gallery-image">
                                
                                <!-- Controles de Navegação -->
                                @if($imovel->imagens->count() > 1)
                                    <button id="prev-btn" 
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200 opacity-0 group-hover:opacity-100 z-20">
                                        <i class="fas fa-chevron-left text-xl"></i>
                                    </button>
                                    <button id="next-btn" 
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200 opacity-0 group-hover:opacity-100 z-20">
                                        <i class="fas fa-chevron-right text-xl"></i>
                                    </button>
                                @endif
                                
                                <!-- Controles de Zoom e Fullscreen -->
                                <div class="absolute top-4 right-4 flex gap-2 z-20">
                                    <button id="zoom-btn" 
                                            class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-200 opacity-0 group-hover:opacity-100"
                                            title="Zoom">
                                        <i class="fas fa-search-plus text-lg"></i>
                                    </button>
                                    <button id="fullscreen-btn" 
                                            class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-200 opacity-0 group-hover:opacity-100"
                                            title="Tela Cheia">
                                        <i class="fas fa-expand text-lg"></i>
                                    </button>
                                </div>
                                
                                <!-- Contador de Imagens -->
                                @if($imovel->imagens->count() > 1)
                                    <div class="absolute top-4 left-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm font-medium opacity-0 group-hover:opacity-100 transition-all duration-200 z-20">
                                        <span id="image-counter">1</span> / {{ $imovel->imagens->count() }}
                                    </div>
                                @endif
                                
                                <!-- Indicadores -->
                                @if($imovel->imagens->count() > 1)
                                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                                        @foreach($imovel->imagens as $index => $imagem)
                                            <button class="gallery-indicator w-3 h-3 rounded-full transition-all duration-200 {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" 
                                                    data-index="{{ $index }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Badges -->
                            <div class="absolute top-6 left-6 flex gap-2 z-10">
                                @if($imovel->destaque)
                                    <span class="px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 text-white font-bold text-sm shadow-lg">
                                        <i class="fas fa-star mr-1"></i> DESTAQUE
                                    </span>
                                @endif
                                <span class="px-4 py-2 rounded-full {{ $imovel->finalidade->slug == 'venda' ? 'bg-green-500' : 'bg-purple-500' }} text-white font-bold text-sm shadow-lg">
                                    {{ $imovel->finalidade->nome }}
                                </span>
                            </div>
                            
                            <!-- Miniaturas -->
                            @if($imovel->imagens->count() > 1)
                                <div class="relative p-4 bg-gray-900/50 backdrop-blur-sm">
                                    <!-- Botões de scroll das miniaturas -->
                                    @if($imovel->imagens->count() > 4)
                                        <button id="thumb-prev" 
                                                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-200 z-10">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button id="thumb-next" 
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-200 z-10">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Container das miniaturas com scroll -->
                                    <div id="thumbnails-container" 
                                         class="flex gap-3 overflow-x-auto scrollbar-hide scroll-smooth"
                                         style="scrollbar-width: none; -ms-overflow-style: none;">
                                        @foreach($imovel->imagens as $index => $imagem)
                                            <div class="relative flex-shrink-0">
                                        <img src="{{ asset('storage/' . $imagem->caminho) }}" 
                                             alt="{{ $imovel->titulo }}" 
                                                     class="gallery-thumbnail w-24 h-24 object-cover rounded-xl cursor-pointer hover:scale-105 hover:opacity-90 transition-all duration-300 border-2 {{ $index === 0 ? 'border-4 border-yellow-400 shadow-lg shadow-yellow-400/50' : 'border-white/50' }}" 
                                                     data-index="{{ $index }}">
                                                @if($index === 0)
                                                    <div class="absolute inset-0 rounded-xl bg-yellow-400/20 pointer-events-none"></div>
                                                    <div class="absolute top-1 right-1 w-3 h-3 bg-yellow-400 rounded-full shadow-lg border border-white"></div>
                                                @endif
                                            </div>
                                    @endforeach
                                    </div>
                                    
                                    <!-- Indicador de scroll -->
                                    @if($imovel->imagens->count() > 4)
                                        <div class="flex justify-center mt-2">
                                            <div class="flex gap-1">
                                                @for($i = 0; $i < ceil($imovel->imagens->count() / 4); $i++)
                                                    <div class="w-2 h-2 rounded-full bg-white/30 scroll-indicator {{ $i === 0 ? 'bg-white' : '' }}" 
                                                         data-page="{{ $i }}"></div>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-8xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Lightbox Modal -->
                <div id="lightbox-modal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center">
                    <div class="relative w-full h-full flex items-center justify-center p-4">
                        <!-- Botão Fechar -->
                        <button id="close-lightbox" 
                                class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 transition-colors z-10">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <!-- Imagem do Lightbox -->
                        <img id="lightbox-image" 
                             src="" 
                             alt="" 
                             class="max-w-full max-h-full object-contain">
                        
                        <!-- Controles do Lightbox -->
                        @if($imovel->imagens->count() > 1)
                            <button id="lightbox-prev" 
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-4 rounded-full transition-all duration-200">
                                <i class="fas fa-chevron-left text-2xl"></i>
                            </button>
                            <button id="lightbox-next" 
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-4 rounded-full transition-all duration-200">
                                <i class="fas fa-chevron-right text-2xl"></i>
                            </button>
                            
                            <!-- Contador do Lightbox -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded-full text-lg font-medium">
                                <span id="lightbox-counter">1</span> / {{ $imovel->imagens->count() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal de Compartilhamento -->
                <div id="share-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                        <!-- Header do Modal -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold flex items-center">
                                    <i class="fas fa-share-alt mr-3"></i>
                                    Compartilhar Imóvel
                                </h3>
                                <button id="close-share-modal" class="text-white/80 hover:text-white text-2xl transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Conteúdo do Modal -->
                        <div class="p-6">
                            <!-- Link para Copiar -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link do Imóvel</label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="share-link" 
                                           value="{!! json_encode(url()->current()) !!}" 
                                           readonly
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button id="copy-link-btn" 
                                            class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors font-medium">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <div id="copy-success" class="hidden mt-2 text-sm text-green-600 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Link copiado com sucesso!
                                </div>
                            </div>

                            <!-- Redes Sociais -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Compartilhar em</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <!-- WhatsApp -->
                                    <a href="#" 
                                       id="share-whatsapp"
                                       class="flex items-center justify-center gap-3 p-4 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fab fa-whatsapp text-xl"></i>
                                        <span class="font-medium">WhatsApp</span>
                                    </a>

                                    <!-- Facebook -->
                                    <a href="#" 
                                       id="share-facebook"
                                       class="flex items-center justify-center gap-3 p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fab fa-facebook text-xl"></i>
                                        <span class="font-medium">Facebook</span>
                                    </a>

                                    <!-- Twitter -->
                                    <a href="#" 
                                       id="share-twitter"
                                       class="flex items-center justify-center gap-3 p-4 bg-sky-500 hover:bg-sky-600 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fab fa-twitter text-xl"></i>
                                        <span class="font-medium">Twitter</span>
                                    </a>

                                    <!-- LinkedIn -->
                                    <a href="#" 
                                       id="share-linkedin"
                                       class="flex items-center justify-center gap-3 p-4 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fab fa-linkedin text-xl"></i>
                                        <span class="font-medium">LinkedIn</span>
                                    </a>

                                    <!-- Telegram -->
                                    <a href="#" 
                                       id="share-telegram"
                                       class="flex items-center justify-center gap-3 p-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fab fa-telegram text-xl"></i>
                                        <span class="font-medium">Telegram</span>
                                    </a>

                                    <!-- Email -->
                                    <a href="#" 
                                       id="share-email"
                                       class="flex items-center justify-center gap-3 p-4 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-envelope text-xl"></i>
                                        <span class="font-medium">Email</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Informações do Imóvel para Compartilhamento -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <h5 class="font-semibold text-gray-800 mb-2">Prévia do Compartilhamento</h5>
                                <div class="flex gap-3">
                                    @if($imovel->imagens->count() > 0)
                                        <img src="{{ asset('storage/' . $imovel->imagens->first()->caminho) }}" 
                                             alt="{{ $imovel->titulo }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @endif
                                    <div class="flex-1">
                                        <h6 class="font-medium text-gray-800 text-sm">{!! json_encode($imovel->titulo) !!}</h6>
                                        <p class="text-gray-600 text-xs">{!! json_encode($imovel->bairro . ' - ' . $imovel->cidade) !!}</p>
                                        <p class="text-blue-600 font-bold text-sm">{!! json_encode($imovel->preco_formatado) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações Principais -->
                <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{ $imovel->titulo }}</h1>
                            <p class="text-gray-600 text-lg flex items-center mb-2">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                {{ $imovel->endereco ? $imovel->endereco . ', ' : '' }}{{ $imovel->bairro }} - {{ $imovel->cidade }}
                            </p>
                            <p class="text-sm text-gray-500">Código: <span class="font-semibold">{{ $imovel->codigo }}</span></p>
                        </div>
                    </div>

                    <!-- Características Principais -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 mb-8">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @if($imovel->area_total)
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                                        <i class="fas fa-ruler-combined text-3xl text-blue-600"></i>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">Área Total</p>
                                    <p class="font-bold text-xl text-gray-800">{{ $imovel->area_total }} m²</p>
                                </div>
                            @endif
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                                    <i class="fas fa-bed text-3xl text-blue-600"></i>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Quartos</p>
                                <p class="font-bold text-xl text-gray-800">{{ $imovel->quartos }}</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                                    <i class="fas fa-bath text-3xl text-blue-600"></i>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Banheiros</p>
                                <p class="font-bold text-xl text-gray-800">{{ $imovel->banheiros }}</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                                    <i class="fas fa-car text-3xl text-blue-600"></i>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Vagas</p>
                                <p class="font-bold text-xl text-gray-800">{{ $imovel->vagas }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="w-1 h-8 bg-blue-600 mr-3 rounded"></span>
                            Descrição
                        </h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">
                            {{ $imovel->descricao ?: 'Imóvel sem descrição disponível no momento. Entre em contato para mais informações.' }}
                        </p>
                    </div>

                    <!-- Detalhes Adicionais -->
                    @if($imovel->area_construida || $imovel->cep)
                        <div class="border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Detalhes Adicionais</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @if($imovel->area_construida)
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-home text-blue-500"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Área Construída</p>
                                            <p class="font-semibold text-gray-800">{{ $imovel->area_construida }} m²</p>
                                        </div>
                                    </div>
                                @endif
                                @if($imovel->cep)
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-map-pin text-blue-500"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">CEP</p>
                                            <p class="font-semibold text-gray-800">{{ $imovel->cep }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-tag text-blue-500"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Tipo</p>
                                        <p class="font-semibold text-gray-800">{{ $imovel->tipo->nome }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Mapa -->
                <div class="bg-white rounded-3xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-1 h-8 bg-blue-600 mr-3 rounded"></span>
                        Localização
                    </h2>
                    
                    @if($imovel->endereco || $imovel->bairro || $imovel->cidade)
                        <!-- Mapa Interativo -->
                        <div class="relative">
                            <div id="property-map" class="w-full h-96 rounded-2xl shadow-lg z-10"></div>
                            
                            <!-- Informações do Endereço -->
                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800 mb-1">Endereço Completo</h3>
                                        <p class="text-gray-600">
                                            @if($imovel->endereco)
                                                {{ $imovel->endereco }}, 
                                            @endif
                                            {{ $imovel->bairro }} - {{ $imovel->cidade }}
                                            @if($imovel->cep)
                                                <br><span class="text-sm text-gray-500">CEP: {{ $imovel->cep }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botões de Ação -->
                            <div class="mt-4 flex flex-wrap gap-3">
                                <button id="get-directions" 
                                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-route"></i>
                                    Como Chegar
                                </button>
                                <button id="open-google-maps" 
                                        class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    <i class="fab fa-google"></i>
                                    Abrir no Google Maps
                                </button>
                                <button id="copy-address" 
                                        class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-copy"></i>
                                    Copiar Endereço
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Placeholder quando não há endereço -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 h-80 rounded-2xl flex items-center justify-center shadow-inner">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt text-6xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 font-medium">Endereço não informado</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Card de Preço e Ações -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 sticky top-24">
                    <div class="mb-8">
                        <p class="text-gray-600 mb-2 text-lg font-semibold">{{ $imovel->finalidade->nome }}</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                            {{ $imovel->preco_formatado }}
                        </p>
                        @if($imovel->finalidade->slug == 'aluguel')
                            <p class="text-sm text-gray-500">* Valor mensal</p>
                        @endif
                    </div>

                    <!-- Formulário de Agendamento -->
                    <form action="{{ route('agendamentos.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="imovel_id" value="{{ $imovel->id }}">

                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-2xl text-center mb-6">
                            <h3 class="font-bold text-lg"><i class="fas fa-calendar-check mr-2"></i>Agende sua Visita</h3>
                        </div>

                        <div>
                            <input type="text" name="nome_cliente" placeholder="Seu nome completo" required
                                   class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        </div>

                        <div>
                            <input type="email" name="email" placeholder="Seu e-mail" required
                                   class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        </div>

                        <div>
                            <input type="tel" name="telefone" placeholder="Seu telefone" required
                                   class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        </div>

                        <div>
                            <input type="date" name="data_visita" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        </div>

                        <div>
                            <textarea name="mensagem" rows="3" placeholder="Mensagem (opcional)"
                                      class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-lg shadow-xl">
                            <i class="fas fa-calendar mr-2"></i> Agendar Visita
                        </button>
                    </form>

                    <div class="mt-6 space-y-3">
                        <a href="https://wa.me/5511999999999?text=Olá, tenho interesse no imóvel {{ $imovel->codigo }}"
                           target="_blank"
                           class="flex items-center justify-center gap-3 w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-bold text-lg transition-all shadow-lg">
                            <i class="fab fa-whatsapp text-xl"></i> WhatsApp
                        </a>

                        <button onclick="window.print()" 
                                class="flex items-center justify-center gap-3 w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-4 rounded-xl font-bold transition-all">
                            <i class="fas fa-print"></i> Imprimir
                        </button>

                        <button id="open-share-modal" class="flex items-center justify-center gap-3 w-full bg-blue-100 hover:bg-blue-200 text-blue-700 py-4 rounded-xl font-bold transition-all">
                            <i class="fas fa-share-alt"></i> Compartilhar
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full lg:col-span-2">
                <div class="">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-3xl font-bold text-gray-900">Avaliações</h2>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center mr-4">
                                    @php
                                        $mediaAvaliacoes = $imovel->avaliacoes()->aprovado()->avg('avaliacao') ?? 0;
                                        $totalAvaliacoes = $imovel->avaliacoes()->aprovado()->count();
                                    @endphp
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $mediaAvaliacoes ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-lg font-semibold text-gray-700">{{ number_format($mediaAvaliacoes, 1) }}</span>
                                </div>
                                <span class="text-gray-600">({{ $totalAvaliacoes }} avaliações)</span>
                                <button onclick="openAvaliacaoModal()" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-star mr-2"></i>Avaliar
                                </button>
                            </div>
                        </div>
            
                        <!-- Lista de Avaliações -->
                        <div id="avaliacoes-container">
                            <div class="text-center py-8">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                                <p class="text-gray-600 mt-2">Carregando avaliações...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imóveis Semelhantes -->
        @if($semelhantes->count() > 0)
            <div class="mt-20">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Imóveis Semelhantes</h2>
                    <p class="text-xl text-gray-600">Você também pode se interessar por estes</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($semelhantes as $similar)
                        <x-card-imovel :imovel="$similar" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
/* Esconder scrollbar mas manter funcionalidade */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Animação de pulso para miniatura ativa */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.6);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(251, 191, 36, 0.2);
    }
}

.thumbnail-active {
    animation: pulse-glow 2s infinite;
}

/* Efeito de brilho na miniatura ativa */
.thumbnail-active::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, rgba(251,191,36,0.4), rgba(251,191,36,0.1), rgba(251,191,36,0.4));
    border-radius: 14px;
    z-index: -1;
    opacity: 0.8;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryContainer = document.getElementById('gallery-container');
    if (!galleryContainer) return;

    const mainImage = document.getElementById('main-image');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    const indicators = document.querySelectorAll('.gallery-indicator');
    const imageCounter = document.getElementById('image-counter');
    
    // Lightbox elements
    const lightboxModal = document.getElementById('lightbox-modal');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');
    const lightboxCounter = document.getElementById('lightbox-counter');
    const closeLightbox = document.getElementById('close-lightbox');
    const zoomBtn = document.getElementById('zoom-btn');
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    
    // Elementos das miniaturas
    const thumbnailsContainer = document.getElementById('thumbnails-container');
    const thumbPrev = document.getElementById('thumb-prev');
    const thumbNext = document.getElementById('thumb-next');
    const scrollIndicators = document.querySelectorAll('.scroll-indicator');
    
    // Dados das imagens
    const images = @json($imovel->imagens->pluck('caminho'));
    let currentIndex = 0;
    let isLightboxOpen = false;
    let isZoomed = false;
    let currentThumbPage = 0;
    const thumbnailsPerPage = 4;
    
    // Função para atualizar a imagem principal
    function updateMainImage(index) {
        if (index < 0 || index >= images.length) return;
        
        currentIndex = index;
        mainImage.src = `/storage/${images[index]}`;
        
        // Atualizar contador
        if (imageCounter) {
            imageCounter.textContent = index + 1;
        }
        
        // Atualizar indicadores
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('bg-white', i === index);
            indicator.classList.toggle('bg-white/50', i !== index);
        });
        
        // Atualizar miniaturas
        thumbnails.forEach((thumb, i) => {
            const container = thumb.parentElement;
            const overlay = container.querySelector('.absolute.inset-0');
            const indicator = container.querySelector('.absolute.top-1.right-1');
            
            if (i === index) {
                // Miniatura ativa
                thumb.classList.remove('border-white/50', 'border-2');
                thumb.classList.add('border-4', 'border-yellow-400', 'shadow-lg', 'shadow-yellow-400/50');
                
                // Adicionar overlay e indicador se não existirem
                if (!overlay) {
                    const newOverlay = document.createElement('div');
                    newOverlay.className = 'absolute inset-0 rounded-xl bg-yellow-400/20 pointer-events-none';
                    container.appendChild(newOverlay);
                }
                
                if (!indicator) {
                    const newIndicator = document.createElement('div');
                    newIndicator.className = 'absolute top-1 right-1 w-3 h-3 bg-yellow-400 rounded-full shadow-lg border border-white';
                    container.appendChild(newIndicator);
                }
            } else {
                // Miniatura inativa
                thumb.classList.remove('border-4', 'border-yellow-400', 'shadow-lg', 'shadow-yellow-400/50');
                thumb.classList.add('border-2', 'border-white/50');
                
                // Remover overlay e indicador
                if (overlay) overlay.remove();
                if (indicator) indicator.remove();
            }
        });
    }
    
    // Função para atualizar lightbox
    function updateLightboxImage(index) {
        if (index < 0 || index >= images.length) return;
        
        currentIndex = index;
        lightboxImage.src = `/storage/${images[index]}`;
        
        if (lightboxCounter) {
            lightboxCounter.textContent = index + 1;
        }
    }
    
    // Função para abrir lightbox
    function openLightbox() {
        lightboxModal.classList.remove('hidden');
        lightboxImage.src = `/storage/${images[currentIndex]}`;
        if (lightboxCounter) {
            lightboxCounter.textContent = currentIndex + 1;
        }
        isLightboxOpen = true;
        document.body.style.overflow = 'hidden';
    }
    
    // Função para fechar lightbox
    function closeLightboxModal() {
        lightboxModal.classList.add('hidden');
        isLightboxOpen = false;
        document.body.style.overflow = 'auto';
    }
    
    // Funções para controlar scroll das miniaturas
    function scrollThumbnails(direction) {
        if (!thumbnailsContainer) return;
        
        const scrollAmount = 120; // Largura da miniatura + gap
        const currentScroll = thumbnailsContainer.scrollLeft;
        const maxScroll = thumbnailsContainer.scrollWidth - thumbnailsContainer.clientWidth;
        
        let newScroll;
        if (direction === 'left') {
            newScroll = Math.max(0, currentScroll - scrollAmount);
        } else {
            newScroll = Math.min(maxScroll, currentScroll + scrollAmount);
        }
        
        thumbnailsContainer.scrollTo({
            left: newScroll,
            behavior: 'smooth'
        });
        
        updateScrollIndicators();
    }
    
    function updateScrollIndicators() {
        if (!thumbnailsContainer || scrollIndicators.length === 0) return;
        
        const scrollLeft = thumbnailsContainer.scrollLeft;
        const scrollWidth = thumbnailsContainer.scrollWidth;
        const clientWidth = thumbnailsContainer.clientWidth;
        const maxScroll = scrollWidth - clientWidth;
        
        // Calcular página atual baseada no scroll
        const pageSize = clientWidth;
        const currentPage = Math.round(scrollLeft / pageSize);
        
        scrollIndicators.forEach((indicator, index) => {
            indicator.classList.toggle('bg-white', index === currentPage);
            indicator.classList.toggle('bg-white/30', index !== currentPage);
        });
        
        currentThumbPage = currentPage;
    }
    
    function scrollToThumbnail(index) {
        if (!thumbnailsContainer) return;
        
        const thumbnail = thumbnailsContainer.children[index];
        if (thumbnail) {
            const containerRect = thumbnailsContainer.getBoundingClientRect();
            const thumbnailRect = thumbnail.getBoundingClientRect();
            const scrollLeft = thumbnailsContainer.scrollLeft;
            
            // Calcular posição para centralizar a miniatura
            const thumbnailLeft = thumbnailRect.left - containerRect.left + scrollLeft;
            const thumbnailCenter = thumbnailLeft + (thumbnailRect.width / 2);
            const containerCenter = containerRect.width / 2;
            const targetScroll = thumbnailCenter - containerCenter;
            
            thumbnailsContainer.scrollTo({
                left: Math.max(0, targetScroll),
                behavior: 'smooth'
            });
        }
    }
    
    // Event listeners para lightbox
    if (zoomBtn) {
        zoomBtn.addEventListener('click', openLightbox);
    }
    
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', openLightbox);
    }
    
    if (closeLightbox) {
        closeLightbox.addEventListener('click', closeLightboxModal);
    }
    
    // Navegação no lightbox
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', () => {
            const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
            updateLightboxImage(newIndex);
        });
    }
    
    if (lightboxNext) {
        lightboxNext.addEventListener('click', () => {
            const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
            updateLightboxImage(newIndex);
        });
    }
    
    // Navegação com botões
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
            updateMainImage(newIndex);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
            updateMainImage(newIndex);
        });
    }
    
    // Event listeners para scroll das miniaturas
    if (thumbPrev) {
        thumbPrev.addEventListener('click', () => scrollThumbnails('left'));
    }
    
    if (thumbNext) {
        thumbNext.addEventListener('click', () => scrollThumbnails('right'));
    }
    
    // Atualizar indicadores quando scrollar
    if (thumbnailsContainer) {
        thumbnailsContainer.addEventListener('scroll', updateScrollIndicators);
    }
    
    // Navegação com miniaturas
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            updateMainImage(index);
            scrollToThumbnail(index); // Centralizar a miniatura clicada
        });
    });
    
    // Navegação com indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            updateMainImage(index);
        });
    });
    
    // Navegação com teclado
    document.addEventListener('keydown', (e) => {
        if (isLightboxOpen) {
            // Controles no lightbox
            if (e.key === 'Escape') {
                closeLightboxModal();
            } else if (e.key === 'ArrowLeft') {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
                updateLightboxImage(newIndex);
            } else if (e.key === 'ArrowRight') {
                const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
                updateLightboxImage(newIndex);
            }
        } else {
            // Controles na galeria principal
            if (e.key === 'ArrowLeft') {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
                updateMainImage(newIndex);
            } else if (e.key === 'ArrowRight') {
                const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
                updateMainImage(newIndex);
            }
        }
    });
    
    // Suporte para touch/swipe
    let startX = 0;
    let startY = 0;
    let endX = 0;
    let endY = 0;
    
    function handleSwipe(diffX, diffY, updateFunction) {
        // Verificar se é um swipe horizontal (não vertical)
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
            if (diffX > 0) {
                // Swipe para esquerda - próxima imagem
                const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
                updateFunction(newIndex);
            } else {
                // Swipe para direita - imagem anterior
                const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
                updateFunction(newIndex);
            }
        }
    }
    
    galleryContainer.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    });
    
    galleryContainer.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        endY = e.changedTouches[0].clientY;
        
        const diffX = startX - endX;
        const diffY = startY - endY;
        
        handleSwipe(diffX, diffY, updateMainImage);
    });
    
    // Touch/swipe no lightbox
    if (lightboxModal) {
        lightboxModal.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        lightboxModal.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            endY = e.changedTouches[0].clientY;
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            handleSwipe(diffX, diffY, updateLightboxImage);
        });
        
        // Fechar lightbox clicando fora da imagem
        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) {
                closeLightboxModal();
            }
        });
    }
    
    // Suporte para mouse drag na imagem principal
    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;
    
    function handleMouseDrag(dragEndX, dragEndY, updateFunction) {
        const diffX = dragStartX - dragEndX;
        const diffY = dragStartY - dragEndY;
        
        // Verificar se é um drag horizontal (não vertical)
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
            if (diffX > 0) {
                // Drag para esquerda - próxima imagem
                const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
                updateFunction(newIndex);
            } else {
                // Drag para direita - imagem anterior
                const newIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
                updateFunction(newIndex);
            }
        }
    }
    
    // Drag na imagem principal
    mainImage.addEventListener('mousedown', (e) => {
        e.preventDefault();
        isDragging = true;
        dragStartX = e.clientX;
        dragStartY = e.clientY;
        mainImage.style.cursor = 'grabbing';
        galleryContainer.style.cursor = 'grabbing';
    });
    
    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
    });
    
    document.addEventListener('mouseup', (e) => {
        if (!isDragging) return;
        
        const dragEndX = e.clientX;
        const dragEndY = e.clientY;
        handleMouseDrag(dragEndX, dragEndY, updateMainImage);
        
        isDragging = false;
        mainImage.style.cursor = 'grab';
        galleryContainer.style.cursor = 'grab';
    });
    
    // Mouse drag no lightbox
    if (lightboxModal) {
        let isLightboxDragging = false;
        let lightboxDragStartX = 0;
        let lightboxDragStartY = 0;
        
        lightboxModal.addEventListener('mousedown', (e) => {
            if (e.target === lightboxImage) {
                e.preventDefault();
                isLightboxDragging = true;
                lightboxDragStartX = e.clientX;
                lightboxDragStartY = e.clientY;
                lightboxModal.style.cursor = 'grabbing';
            }
        });
        
        document.addEventListener('mousemove', (e) => {
            if (!isLightboxDragging) return;
            e.preventDefault();
        });
        
        document.addEventListener('mouseup', (e) => {
            if (!isLightboxDragging) return;
            
            const dragEndX = e.clientX;
            const dragEndY = e.clientY;
            handleMouseDrag(dragEndX, dragEndY, updateLightboxImage);
            
            isLightboxDragging = false;
            lightboxModal.style.cursor = 'default';
        });
    }
    
    // Mostrar/ocultar controles no hover
    galleryContainer.addEventListener('mouseenter', () => {
        if (prevBtn) prevBtn.style.opacity = '1';
        if (nextBtn) nextBtn.style.opacity = '1';
    });
    
    galleryContainer.addEventListener('mouseleave', () => {
        if (prevBtn) prevBtn.style.opacity = '0';
        if (nextBtn) nextBtn.style.opacity = '0';
    });
    
    // Auto-play opcional (descomente se quiser)
    /*
    setInterval(() => {
        const newIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
        updateMainImage(newIndex);
    }, 5000);
    */
});

// Modal de Compartilhamento
document.addEventListener('DOMContentLoaded', function() {
    const shareModal = document.getElementById('share-modal');
    const openShareModal = document.getElementById('open-share-modal');
    const closeShareModal = document.getElementById('close-share-modal');
    const copyLinkBtn = document.getElementById('copy-link-btn');
    const shareLink = document.getElementById('share-link');
    const copySuccess = document.getElementById('copy-success');
    
    // Dados do imóvel para compartilhamento
    const imovelData = {
        titulo: {!! json_encode($imovel->titulo) !!},
        preco: {!! json_encode($imovel->preco_formatado) !!},
        localizacao: {!! json_encode($imovel->bairro . ' - ' . $imovel->cidade) !!},
        url: {!! json_encode(url()->current()) !!},
        descricao: {!! json_encode(Str::limit($imovel->descricao, 100)) !!}
    };
    
    // Abrir modal
    if (openShareModal) {
        openShareModal.addEventListener('click', () => {
            shareModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Fechar modal
    if (closeShareModal) {
        closeShareModal.addEventListener('click', closeModal);
    }
    
    // Fechar modal clicando fora
    if (shareModal) {
        shareModal.addEventListener('click', (e) => {
            if (e.target === shareModal) {
                closeModal();
            }
        });
    }
    
    // Fechar modal com ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !shareModal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    function closeModal() {
        shareModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Copiar link
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(shareLink.value);
                copySuccess.classList.remove('hidden');
                copyLinkBtn.innerHTML = '<i class="fas fa-check"></i>';
                copyLinkBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                copyLinkBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                
                setTimeout(() => {
                    copySuccess.classList.add('hidden');
                    copyLinkBtn.innerHTML = '<i class="fas fa-copy"></i>';
                    copyLinkBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                    copyLinkBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 3000);
            } catch (err) {
                // Fallback para navegadores mais antigos
                shareLink.select();
                document.execCommand('copy');
                copySuccess.classList.remove('hidden');
                setTimeout(() => {
                    copySuccess.classList.add('hidden');
                }, 3000);
            }
        });
    }
    
    // Compartilhamento nas redes sociais
    const shareButtons = {
        whatsapp: document.getElementById('share-whatsapp'),
        facebook: document.getElementById('share-facebook'),
        twitter: document.getElementById('share-twitter'),
        linkedin: document.getElementById('share-linkedin'),
        telegram: document.getElementById('share-telegram'),
        email: document.getElementById('share-email')
    };
    
    // WhatsApp
    if (shareButtons.whatsapp) {
        const whatsappText = '🏠 *' + imovelData.titulo + '*\n\n💰 ' + imovelData.preco + '\n📍 ' + imovelData.localizacao + '\n\n' + imovelData.descricao + '\n\n🔗 ' + imovelData.url;
        shareButtons.whatsapp.href = 'https://wa.me/?text=' + encodeURIComponent(whatsappText);
        shareButtons.whatsapp.target = '_blank';
    }
    
    // Facebook
    if (shareButtons.facebook) {
        shareButtons.facebook.href = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(imovelData.url);
        shareButtons.facebook.target = '_blank';
    }
    
    // Twitter
    if (shareButtons.twitter) {
        const twitterText = '🏠 ' + imovelData.titulo + ' - ' + imovelData.preco + ' em ' + imovelData.localizacao;
        shareButtons.twitter.href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(twitterText) + '&url=' + encodeURIComponent(imovelData.url);
        shareButtons.twitter.target = '_blank';
    }
    
    // LinkedIn
    if (shareButtons.linkedin) {
        shareButtons.linkedin.href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(imovelData.url);
        shareButtons.linkedin.target = '_blank';
    }
    
    // Telegram
    if (shareButtons.telegram) {
        const telegramText = '🏠 *' + imovelData.titulo + '*\n\n💰 ' + imovelData.preco + '\n📍 ' + imovelData.localizacao + '\n\n' + imovelData.descricao + '\n\n🔗 ' + imovelData.url;
        shareButtons.telegram.href = 'https://t.me/share/url?url=' + encodeURIComponent(imovelData.url) + '&text=' + encodeURIComponent(telegramText);
        shareButtons.telegram.target = '_blank';
    }
    
    // Email
    if (shareButtons.email) {
        const emailSubject = 'Imóvel: ' + imovelData.titulo;
        const emailBody = 'Olá!\n\nEncontrei este imóvel que pode te interessar:\n\n🏠 ' + imovelData.titulo + '\n💰 ' + imovelData.preco + '\n📍 ' + imovelData.localizacao + '\n\n' + imovelData.descricao + '\n\n🔗 ' + imovelData.url;
        shareButtons.email.href = 'mailto:?subject=' + encodeURIComponent(emailSubject) + '&body=' + encodeURIComponent(emailBody);
    }
});

// Mapa do Imóvel
document.addEventListener('DOMContentLoaded', function() {
    const mapContainer = document.getElementById('property-map');
    if (!mapContainer) return;

    // Dados do imóvel
    const imovelData = {
        endereco: {!! json_encode($imovel->endereco) !!},
        bairro: {!! json_encode($imovel->bairro) !!},
        cidade: {!! json_encode($imovel->cidade) !!},
        cep: {!! json_encode($imovel->cep) !!},
        latitude: {!! json_encode($imovel->latitude) !!},
        longitude: {!! json_encode($imovel->longitude) !!}
    };

    // Construir endereço completo
    let enderecoCompleto = '';
    if (imovelData.endereco) enderecoCompleto += imovelData.endereco + ', ';
    enderecoCompleto += imovelData.bairro + ', ' + imovelData.cidade;
    if (imovelData.cep) enderecoCompleto += ', ' + imovelData.cep;

    let map;
    let marker;

    // Função para geocodificar endereço
    async function geocodeAddress(address) {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                return {
                    lat: parseFloat(data[0].lat),
                    lng: parseFloat(data[0].lon)
                };
            }
        } catch (error) {
            console.error('Erro ao geocodificar endereço:', error);
        }
        return null;
    }

    // Função para inicializar o mapa
    async function initMap() {
        let lat = -23.5505; // São Paulo como fallback
        let lng = -46.6333;

        // Se tem coordenadas, usar elas
        if (imovelData.latitude && imovelData.longitude) {
            lat = parseFloat(imovelData.latitude);
            lng = parseFloat(imovelData.longitude);
        } else if (enderecoCompleto) {
            // Senão, geocodificar o endereço
            const coords = await geocodeAddress(enderecoCompleto);
            if (coords) {
                lat = coords.lat;
                lng = coords.lng;
            }
        }

        // Inicializar mapa com zoom maior para mostrar a rua
        map = L.map('property-map').setView([lat, lng], 18);

        // Adicionar tiles com zoom máximo maior
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 40
        }).addTo(map);

        // Adicionar marcador personalizado
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div class="marker-pin"><i class="fas fa-home"></i></div>',
            iconSize: [30, 30],
            iconAnchor: [15, 30]
        });

        marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
        
        // Adicionar popup
        marker.bindPopup(`
            <div class="p-2">
                <h3 class="font-bold text-gray-800 mb-1">{!! json_encode($imovel->titulo) !!}</h3>
                <p class="text-sm text-gray-600">${enderecoCompleto}</p>
                <p class="text-sm font-semibold text-blue-600 mt-1">{!! json_encode($imovel->preco_formatado) !!}</p>
            </div>
        `).openPopup();
    }

    // Inicializar mapa
    initMap();

    // Botões de ação
    const getDirectionsBtn = document.getElementById('get-directions');
    const openGoogleMapsBtn = document.getElementById('open-google-maps');
    const copyAddressBtn = document.getElementById('copy-address');

    // Como chegar
    if (getDirectionsBtn) {
        getDirectionsBtn.addEventListener('click', () => {
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(enderecoCompleto)}`;
            window.open(googleMapsUrl, '_blank');
        });
    }

    // Abrir no Google Maps
    if (openGoogleMapsBtn) {
        openGoogleMapsBtn.addEventListener('click', () => {
            const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(enderecoCompleto)}`;
            window.open(googleMapsUrl, '_blank');
        });
    }

    // Copiar endereço
    if (copyAddressBtn) {
        copyAddressBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(enderecoCompleto);
                
                // Feedback visual
                const originalText = copyAddressBtn.innerHTML;
                copyAddressBtn.innerHTML = '<i class="fas fa-check"></i> Copiado!';
                copyAddressBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                copyAddressBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                
                setTimeout(() => {
                    copyAddressBtn.innerHTML = originalText;
                    copyAddressBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                    copyAddressBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                }, 2000);
            } catch (err) {
                // Fallback
                const textArea = document.createElement('textarea');
                textArea.value = enderecoCompleto;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                // Feedback visual
                const originalText = copyAddressBtn.innerHTML;
                copyAddressBtn.innerHTML = '<i class="fas fa-check"></i> Copiado!';
                setTimeout(() => {
                    copyAddressBtn.innerHTML = originalText;
                }, 2000);
            }
        });
    }
});
</script>

<style>
/* Estilo do marcador personalizado */
.custom-marker {
    background: none;
    border: none;
}

.marker-pin {
    width: 30px;
    height: 30px;
    background: #3B82F6;
    border: 3px solid white;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.marker-pin i {
    color: white;
    font-size: 12px;
    transform: rotate(45deg);
}

/* Estilo do popup */
.leaflet-popup-content {
    margin: 8px 12px;
    line-height: 1.4;
}

.leaflet-popup-content-wrapper {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>

<!-- Seção de Avaliações -->


<!-- Modal de Avaliação -->
<div id="avaliacaoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Avaliar Imóvel</h3>
                    <button onclick="closeAvaliacaoModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="avaliacaoForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="imovel_id" value="{{ $imovel->id }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                        <input type="text" name="nome" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Avaliação *</label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-rating" data-rating="{{ $i }}">
                                    <i class="fas fa-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors"></i>
                                </button>
                            @endfor
                            <input type="hidden" name="avaliacao" value="0" required>
                            <span id="rating-text" class="ml-3 text-sm text-gray-600">Selecione uma avaliação</span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comentário (opcional)</label>
                        <textarea name="comentario" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Conte-nos sua experiência com este imóvel..."></textarea>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeAvaliacaoModal()" 
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Enviar Avaliação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Sistema de avaliações
let selectedRating = 0;

// Funções do modal
function openAvaliacaoModal() {
    document.getElementById('avaliacaoModal').classList.remove('hidden');
}

function closeAvaliacaoModal() {
    document.getElementById('avaliacaoModal').classList.add('hidden');
    // Resetar formulário
    document.getElementById('avaliacaoForm').reset();
    selectedRating = 0;
    updateStars();
    updateRatingText();
}

// Fechar modal ao clicar fora
document.getElementById('avaliacaoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAvaliacaoModal();
    }
});

// Estrelas interativas
document.querySelectorAll('.star-rating').forEach((star, index) => {
    star.addEventListener('click', () => {
        selectedRating = index + 1;
        updateStars();
        updateRatingText();
    });
    
    star.addEventListener('mouseenter', () => {
        highlightStars(index + 1);
    });
});

document.querySelector('.star-rating').parentElement.addEventListener('mouseleave', () => {
    updateStars();
});

function updateStars() {
    document.querySelectorAll('.star-rating i').forEach((star, index) => {
        if (index < selectedRating) {
            star.className = 'fas fa-star text-2xl text-yellow-400';
        } else {
            star.className = 'fas fa-star text-2xl text-gray-300';
        }
    });
}

function highlightStars(rating) {
    document.querySelectorAll('.star-rating i').forEach((star, index) => {
        if (index < rating) {
            star.className = 'fas fa-star text-2xl text-yellow-400';
        } else {
            star.className = 'fas fa-star text-2xl text-gray-300';
        }
    });
}

function updateRatingText() {
    const texts = ['', 'Muito Ruim', 'Ruim', 'Regular', 'Bom', 'Excelente'];
    document.getElementById('rating-text').textContent = texts[selectedRating];
    document.querySelector('input[name="avaliacao"]').value = selectedRating;
}

// Envio do formulário
document.getElementById('avaliacaoForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    if (selectedRating === 0) {
        alert('Por favor, selecione uma avaliação');
        return;
    }
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('{{ route("avaliacoes.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            closeAvaliacaoModal();
            loadAvaliacoes();
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Erro:', error);
        alert('Erro ao enviar avaliação. Tente novamente.');
    }
});

// Carregar avaliações
async function loadAvaliacoes() {
    try {
        const response = await fetch('{{ route("avaliacoes.get", $imovel->id) }}');
        const data = await response.json();

        const container = document.getElementById('avaliacoes-container');

        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(avaliacao => {
                const estrelas = '★'.repeat(avaliacao.avaliacao) + '☆'.repeat(5 - avaliacao.avaliacao);
                const dataFormatada = new Date(avaliacao.created_at).toLocaleDateString('pt-BR');
                const comentario = avaliacao.comentario ? `<p class="text-gray-700 mt-2">${avaliacao.comentario}</p>` : '';
                
                return `
                    <div class="border-b border-gray-200 pb-6 mb-6 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">${avaliacao.nome || 'Anônimo'}</h4>
                                <div class="flex items-center mt-1">
                                    <span class="text-yellow-400 mr-2">${estrelas}</span>
                                    <span class="text-sm text-gray-600">${avaliacao.avaliacao || 'Sem avaliação'}</span>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">${dataFormatada}</span>
                        </div>
                        ${comentario}
                    </div>
                `;
            }).join('');
        } else {
            container.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Erro ao carregar avaliações:', error);
        document.getElementById('avaliacoes-container').innerHTML = `
            <div class="text-center py-8">
                <p class="text-red-600">Erro ao carregar avaliações</p>
            </div>
        `;
    }
}

// Carregar avaliações ao carregar a página
document.addEventListener('DOMContentLoaded', loadAvaliacoes);
</script>
@endsection
@endsection
