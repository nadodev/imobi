@props(['imovel'])

<div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-scale group">
    <div class="relative overflow-hidden">
        <a href="{{ route('imoveis.show', $imovel->slug) }}">
            @if($imovel->imagemPrincipal)
                <img src="{{ asset('storage/' . $imovel->imagemPrincipal->caminho) }}" 
                     alt="{{ $imovel->titulo }}" 
                     class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
            @else
                <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-5xl"></i>
                </div>
            @endif
        </a>
        
        @if($imovel->destaque)
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg">
                    <i class="fas fa-star mr-1"></i> DESTAQUE
                </span>
            </div>
        @endif
        
        <div class="absolute top-4 right-4 flex gap-2">
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-blue-600 shadow-md">
                {{ $imovel->tipo->nome }}
            </span>
            
            <!-- Favorite Button -->
            <button onclick="toggleFavorito({{ $imovel->id }})" 
                    class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md hover:bg-white transition-all duration-300 group/fav"
                    title="Adicionar aos favoritos">
                <i class="fas fa-heart text-gray-400 group-hover/fav:text-red-500 group-hover/fav:scale-110 transition-all duration-300"></i>
            </button>
        </div>
        
        <div class="absolute bottom-4 right-4">
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $imovel->finalidade->slug == 'venda' ? 'bg-green-500' : 'bg-purple-500' }} text-white shadow-lg">
                {{ $imovel->finalidade->nome }}
            </span>
        </div>
    </div>

    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
            <a href="{{ route('imoveis.show', $imovel->slug) }}">
                {{ $imovel->titulo }}
            </a>
        </h3>

        <p class="text-gray-600 text-sm mb-4 flex items-center">
            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
            {{ $imovel->bairro }}, {{ $imovel->cidade }}
        </p>

        <div class="flex items-center gap-4 text-sm text-gray-700 mb-5 pb-5 border-b">
            @if($imovel->quartos > 0)
                <span class="flex items-center">
                    <i class="fas fa-bed text-blue-500 mr-1.5"></i> 
                    <span class="font-medium">{{ $imovel->quartos }}</span>
                </span>
            @endif
            @if($imovel->banheiros > 0)
                <span class="flex items-center">
                    <i class="fas fa-bath text-blue-500 mr-1.5"></i> 
                    <span class="font-medium">{{ $imovel->banheiros }}</span>
                </span>
            @endif
            @if($imovel->vagas > 0)
                <span class="flex items-center">
                    <i class="fas fa-car text-blue-500 mr-1.5"></i> 
                    <span class="font-medium">{{ $imovel->vagas }}</span>
                </span>
            @endif
            @if($imovel->area_total)
                <span class="flex items-center">
                    <i class="fas fa-ruler-combined text-blue-500 mr-1.5"></i> 
                    <span class="font-medium">{{ $imovel->area_total }}m²</span>
                </span>
            @endif
        </div>

        <div class="flex justify-between items-center flex-col">
            <div class="text-left w-full mb-4">
                <p class="text-xs text-gray-500 mb-1">{{ $imovel->finalidade->nome }}</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $imovel->preco_formatado }}
                </p>
            </div>
            <a href="{{ route('imoveis.show', $imovel->slug) }}" 
               class="w-full text-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                Detalhes <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

