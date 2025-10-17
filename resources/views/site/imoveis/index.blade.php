@extends('layouts.site')

@section('title', 'Imóveis - Imobiliária')

@section('content')
<!-- Hero Pequeno -->
<section class="gradient-bg py-16 text-white relative">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-3">Nossos Imóveis</h1>
        <p class="text-xl text-white/90">Encontre o imóvel perfeito para você</p>
    </div>
</section>

<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Filtros -->
        <div class="mb-10">
            <x-filtro-imoveis :tipos="$tipos" :finalidades="$finalidades" :cidades="$cidades" />
        </div>

        <!-- Resultados -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-2xl shadow-md">
            <p class="text-gray-700 font-medium text-lg mb-4 md:mb-0">
                <span class="font-bold text-2xl text-blue-600">{{ $imoveis->total() }}</span> 
                <span class="text-gray-600">{{ $imoveis->total() == 1 ? 'imóvel encontrado' : 'imóveis encontrados' }}</span>
            </p>
            
            @if(request()->hasAny(['tipo_id', 'finalidade_id', 'cidade', 'preco_min', 'preco_max', 'quartos', 'busca']))
                <a href="{{ route('imoveis.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-xl transition-all flex items-center gap-2">
                    <i class="fas fa-times"></i> Limpar Filtros
                </a>
            @endif
        </div>

        @if($imoveis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($imoveis as $imovel)
                    <x-card-imovel :imovel="$imovel" />
                @endforeach
            </div>

            <!-- Paginação -->
            @if($imoveis->hasPages())
                <div class="mt-12">
                    <div class="flex justify-center">
                        {{ $imoveis->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="bg-white p-16 rounded-3xl shadow-lg text-center">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-gray-300 text-6xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-4">Nenhum imóvel encontrado</h3>
                <p class="text-gray-600 text-lg mb-8">Tente ajustar seus filtros de busca ou procure por outra região</p>
                <a href="{{ route('imoveis.index') }}" 
                   class="inline-flex items-center gap-2 px-8 py-4 btn-primary text-white font-bold rounded-xl shadow-lg">
                    <i class="fas fa-redo"></i> Ver Todos os Imóveis
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
