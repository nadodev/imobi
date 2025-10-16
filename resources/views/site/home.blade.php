@extends('layouts.site')

@section('title', 'Home - Imobiliária')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Encontre o Imóvel dos Seus Sonhos</h1>
        <p class="text-xl mb-8">Milhares de opções para venda e aluguel</p>
        
        <!-- Quick Search -->
        <form action="{{ route('imoveis.index') }}" method="GET" class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select name="finalidade_id" class="px-4 py-3 rounded-lg border text-gray-700">
                        <option value="">Finalidade</option>
                        @foreach($finalidades as $finalidade)
                            <option value="{{ $finalidade->id }}">{{ $finalidade->nome }}</option>
                        @endforeach
                    </select>
                    
                    <select name="tipo_id" class="px-4 py-3 rounded-lg border text-gray-700">
                        <option value="">Tipo de Imóvel</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                    
                    <input type="text" name="cidade" placeholder="Cidade" 
                           class="px-4 py-3 rounded-lg border text-gray-700">
                    
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Imóveis em Destaque -->
@if($imoveisDestaque->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">
            <i class="fas fa-star text-yellow-400"></i> Imóveis em Destaque
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($imoveisDestaque as $imovel)
                <x-card-imovel :imovel="$imovel" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Imóveis Recentes -->
@if($imoveisRecentes->count() > 0)
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Imóveis Recentes</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($imoveisRecentes as $imovel)
                <x-card-imovel :imovel="$imovel" />
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('imoveis.index') }}" 
               class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">
                Ver Todos os Imóveis <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categorias -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Buscar por Categoria</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($tipos as $tipo)
                <a href="{{ route('imoveis.index', ['tipo_id' => $tipo->id]) }}" 
                   class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-xl transition">
                    <i class="fas fa-home text-4xl text-blue-600 mb-3"></i>
                    <p class="font-semibold">{{ $tipo->nome }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Não encontrou o que procura?</h2>
        <p class="text-xl mb-8">Entre em contato conosco e vamos te ajudar!</p>
        <a href="{{ route('contato') }}" 
           class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Fale Conosco
        </a>
    </div>
</section>
@endsection

