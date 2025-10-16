@extends('layouts.site')

@section('title', 'Imóveis - Imobiliária')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Nossos Imóveis</h1>
        
        <!-- Filtros -->
        <x-filtro-imoveis :tipos="$tipos" :finalidades="$finalidades" :cidades="$cidades" />

        <!-- Resultados -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600">
                    Encontrados <strong>{{ $imoveis->total() }}</strong> imóveis
                </p>
            </div>

            @if($imoveis->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($imoveis as $imovel)
                        <x-card-imovel :imovel="$imovel" />
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-8">
                    {{ $imoveis->links() }}
                </div>
            @else
                <div class="bg-white p-12 rounded-lg shadow-md text-center">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Nenhum imóvel encontrado</h3>
                    <p class="text-gray-500 mb-6">Tente ajustar seus filtros de busca</p>
                    <a href="{{ route('imoveis.index') }}" class="text-blue-600 hover:underline">
                        Limpar filtros
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

