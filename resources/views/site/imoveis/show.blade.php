@extends('layouts.site')

@section('title', $imovel->titulo . ' - Imobiliária')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('imoveis.index') }}" class="text-blue-600 hover:underline">Imóveis</a>
            <span class="mx-2">/</span>
            <span class="text-gray-600">{{ $imovel->codigo }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2">
                <!-- Galeria de Imagens -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    @if($imovel->imagens->count() > 0)
                        <div id="galeria" class="relative">
                            <img src="{{ asset('storage/' . $imovel->imagens->first()->caminho) }}" 
                                 alt="{{ $imovel->titulo }}" 
                                 class="w-full h-96 object-cover">
                            
                            @if($imovel->imagens->count() > 1)
                                <div class="grid grid-cols-4 gap-2 p-4">
                                    @foreach($imovel->imagens->take(4) as $imagem)
                                        <img src="{{ asset('storage/' . $imagem->caminho) }}" 
                                             alt="{{ $imovel->titulo }}" 
                                             class="w-full h-24 object-cover rounded cursor-pointer hover:opacity-75">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Informações -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $imovel->titulo }}</h1>
                            <p class="text-gray-600 mt-2">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $imovel->endereco }}, {{ $imovel->bairro }} - {{ $imovel->cidade }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Código: {{ $imovel->codigo }}</p>
                        </div>
                    </div>

                    <div class="border-t border-b py-4 my-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if($imovel->area_total)
                                <div class="text-center">
                                    <i class="fas fa-ruler-combined text-2xl text-blue-600"></i>
                                    <p class="text-sm text-gray-600 mt-1">Área Total</p>
                                    <p class="font-semibold">{{ $imovel->area_total }} m²</p>
                                </div>
                            @endif
                            
                            <div class="text-center">
                                <i class="fas fa-bed text-2xl text-blue-600"></i>
                                <p class="text-sm text-gray-600 mt-1">Quartos</p>
                                <p class="font-semibold">{{ $imovel->quartos }}</p>
                            </div>
                            
                            <div class="text-center">
                                <i class="fas fa-bath text-2xl text-blue-600"></i>
                                <p class="text-sm text-gray-600 mt-1">Banheiros</p>
                                <p class="font-semibold">{{ $imovel->banheiros }}</p>
                            </div>
                            
                            <div class="text-center">
                                <i class="fas fa-car text-2xl text-blue-600"></i>
                                <p class="text-sm text-gray-600 mt-1">Vagas</p>
                                <p class="font-semibold">{{ $imovel->vagas }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-3">Descrição</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ $imovel->descricao ?: 'Sem descrição disponível.' }}</p>
                    </div>

                    <!-- Mapa -->
                    @if($imovel->latitude && $imovel->longitude)
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-3">Localização</h2>
                            <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">
                                    <i class="fas fa-map-marked-alt text-4xl"></i><br>
                                    Mapa ({{ $imovel->latitude }}, {{ $imovel->longitude }})
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Preço e Ações -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-4">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">{{ $imovel->finalidade->nome }}</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $imovel->preco_formatado }}</p>
                    </div>

                    <!-- Formulário de Agendamento -->
                    <form action="{{ route('agendamentos.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="imovel_id" value="{{ $imovel->id }}">

                        <h3 class="font-semibold text-lg">Agendar Visita</h3>

                        <div>
                            <input type="text" name="nome_cliente" placeholder="Seu nome" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <input type="email" name="email" placeholder="Seu e-mail" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <input type="tel" name="telefone" placeholder="Seu telefone" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <input type="date" name="data_visita" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <textarea name="mensagem" rows="3" placeholder="Mensagem (opcional)"
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-calendar"></i> Agendar Visita
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t space-y-2">
                        <a href="https://wa.me/5511999999999?text=Olá, tenho interesse no imóvel {{ $imovel->codigo }}"
                           target="_blank"
                           class="block w-full bg-green-500 text-white text-center py-3 rounded-lg hover:bg-green-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>

                        <button onclick="window.print()" 
                                class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imóveis Semelhantes -->
        @if($semelhantes->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Imóveis Semelhantes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($semelhantes as $imovel)
                        <x-card-imovel :imovel="$imovel" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

