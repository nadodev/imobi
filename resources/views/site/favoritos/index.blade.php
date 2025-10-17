@extends('layouts.site')

@section('title', 'Meus Favoritos - ImobiJoaçaba')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100 py-12">
    <div class="container-custom">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Meus Favoritos</h1>
            <p class="text-xl text-gray-600">Imóveis que você salvou para consultar depois</p>
        </div>

        @if($favoritos->count() > 0)
            <!-- Stats -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200/50 mb-8">
                <div class="flex items-center justify-center space-x-8">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-red-600">{{ $favoritos->total() }}</p>
                        <p class="text-sm text-gray-600">Imóveis Favoritos</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $favoritos->where('tipo.nome', 'Casa')->count() }}</p>
                        <p class="text-sm text-gray-600">Casas</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $favoritos->where('tipo.nome', 'Apartamento')->count() }}</p>
                        <p class="text-sm text-gray-600">Apartamentos</p>
                    </div>
                </div>
            </div>

            <!-- Favoritos Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favoritos as $imovel)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            @if($imovel->imagemPrincipal)
                                <img src="{{ asset('storage/' . $imovel->imagemPrincipal->caminho) }}" 
                                     alt="{{ $imovel->titulo }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                            
                            <!-- Favorite Button -->
                            <button onclick="toggleFavorito({{ $imovel->id }})" 
                                    class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-300 group/fav">
                                <i class="fas fa-heart text-red-500 group-hover/fav:scale-110 transition-transform"></i>
                            </button>
                            
                            <!-- Status Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded-full shadow-lg">
                                    {{ $imovel->finalidade->nome }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="mb-3">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2">
                                    {{ $imovel->titulo }}
                                </h3>
                                <p class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $imovel->endereco }}
                                </p>
                            </div>

                            <!-- Features -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <div class="flex items-center space-x-4">
                                    @if($imovel->quartos)
                                        <span class="flex items-center">
                                            <i class="fas fa-bed mr-1"></i>
                                            {{ $imovel->quartos }}
                                        </span>
                                    @endif
                                    @if($imovel->banheiros)
                                        <span class="flex items-center">
                                            <i class="fas fa-bath mr-1"></i>
                                            {{ $imovel->banheiros }}
                                        </span>
                                    @endif
                                    @if($imovel->area)
                                        <span class="flex items-center">
                                            <i class="fas fa-ruler-combined mr-1"></i>
                                            {{ $imovel->area }}m²
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-2xl font-bold text-blue-600">{{ $imovel->preco_formatado }}</p>
                                    <p class="text-sm text-gray-600">{{ $imovel->tipo->nome }}</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('imoveis.show', $imovel->slug) }}" 
                                   class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver Detalhes
                                </a>
                                <button onclick="removeFavorito({{ $imovel->id }})" 
                                        class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                        title="Remover dos favoritos">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $favoritos->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum favorito ainda</h3>
                <p class="text-gray-600 mb-8">Você ainda não salvou nenhum imóvel nos favoritos. Explore nossos imóveis e salve os que mais gostar!</p>
                <div class="space-y-4">
                    <a href="{{ route('imoveis.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>
                        Explorar Imóveis
                    </a>
                    <div>
                        <a href="{{ route('admin.cliente.dashboard') }}" 
                           class="text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Voltar ao Painel
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleFavorito(imovelId) {
    fetch('{{ route("favoritos.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            imovel_id: imovelId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.is_favorito) {
                // Adicionado aos favoritos
                showNotification(data.message, 'success');
            } else {
                // Removido dos favoritos
                showNotification(data.message, 'info');
                // Recarregar a página para atualizar a lista
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            if (data.requires_auth) {
                showNotification('Você precisa estar logado para favoritar imóveis', 'warning');
            } else {
                showNotification(data.message || 'Erro ao favoritar imóvel', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showNotification('Erro ao favoritar imóvel', 'error');
    });
}

function removeFavorito(imovelId) {
    if (confirm('Tem certeza que deseja remover este imóvel dos favoritos?')) {
        fetch(`{{ route("favoritos.destroy", ":id") }}`.replace(':id', imovelId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Erro ao remover favorito', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showNotification('Erro ao remover favorito', 'error');
        });
    }
}

function showNotification(message, type = 'info') {
    // Criar elemento de notificação
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        type === 'warning' ? 'bg-yellow-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remover após 3 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endsection
