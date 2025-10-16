@props(['imovel'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
    <a href="{{ route('imoveis.show', $imovel->slug) }}">
        @if($imovel->imagemPrincipal)
            <img src="{{ asset('storage/' . $imovel->imagemPrincipal->caminho) }}" 
                 alt="{{ $imovel->titulo }}" 
                 class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-image text-gray-400 text-4xl"></i>
            </div>
        @endif
    </a>

    <div class="p-4">
        @if($imovel->destaque)
            <span class="inline-block bg-yellow-400 text-yellow-900 text-xs px-2 py-1 rounded mb-2">
                <i class="fas fa-star"></i> DESTAQUE
            </span>
        @endif

        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                {{ $imovel->tipo->nome }}
            </span>
            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                {{ $imovel->finalidade->nome }}
            </span>
        </div>

        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
            <a href="{{ route('imoveis.show', $imovel->slug) }}" class="hover:text-blue-600">
                {{ $imovel->titulo }}
            </a>
        </h3>

        <p class="text-gray-600 text-sm mb-3">
            <i class="fas fa-map-marker-alt"></i>
            {{ $imovel->bairro }}, {{ $imovel->cidade }}
        </p>

        <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
            @if($imovel->quartos > 0)
                <span><i class="fas fa-bed"></i> {{ $imovel->quartos }}</span>
            @endif
            @if($imovel->banheiros > 0)
                <span><i class="fas fa-bath"></i> {{ $imovel->banheiros }}</span>
            @endif
            @if($imovel->vagas > 0)
                <span><i class="fas fa-car"></i> {{ $imovel->vagas }}</span>
            @endif
        </div>

        <div class="border-t pt-3 flex justify-between items-center">
            <span class="text-2xl font-bold text-blue-600">
                {{ $imovel->preco_formatado }}
            </span>
            <a href="{{ route('imoveis.show', $imovel->slug) }}" 
               class="text-blue-600 hover:text-blue-800">
                Ver detalhes <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

