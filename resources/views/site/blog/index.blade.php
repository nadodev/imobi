@extends('layouts.site')

@section('title', 'Blog - Dicas e Notícias do Mercado Imobiliário')
@section('description', 'Fique por dentro das últimas tendências, dicas e notícias do mercado imobiliário. Artigos especializados para compradores, vendedores e investidores.')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 mb-8">
                <i class="fas fa-newspaper text-2xl mr-3"></i>
                <span class="text-lg font-medium">Blog Imobiliário</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                Conhecimento que Transforma
            </h1>
            <p class="text-xl md:text-2xl mb-12 text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Descubra insights valiosos, tendências do mercado e dicas especializadas para tomar as melhores decisões imobiliárias
            </p>
            
            <!-- Busca Avançada -->
            <div class="max-w-3xl mx-auto">
                <form method="GET" class="relative">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Buscar artigos, dicas, tendências..." 
                                   class="w-full bg-white px-6 py-4 pl-14 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-300/50 shadow-xl">
                            <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 px-8 py-4 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <i class="fas fa-search mr-2"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Wave -->
   
</div>

<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Categorias -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-folder text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Categorias</h3>
                </div>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('blog.index') }}" 
                           class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 {{ !request('categoria') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-md' : 'text-gray-600 hover:text-blue-600' }}">
                            <i class="fas fa-th-large mr-3"></i>
                            <span class="font-medium">Todas as categorias</span>
                        </a>
                    </li>
                    @foreach($categorias as $categoria)
                        <li>
                            <a href="{{ route('blog.index', ['categoria' => $categoria]) }}" 
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 {{ request('categoria') == $categoria ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-md' : 'text-gray-600 hover:text-blue-600' }}">
                                <i class="fas fa-tag mr-3"></i>
                                <span class="font-medium">{{ ucfirst($categoria) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Artigos em Destaque -->
            @if($artigosDestaque->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Em Destaque</h3>
                    </div>
                    <div class="space-y-6">
                        @foreach($artigosDestaque as $artigo)
                            <div class="group">
                                <a href="{{ route('blog.show', $artigo->slug) }}" class="block">
                                    @if($artigo->imagem_destaque)
                                        <div class="relative overflow-hidden rounded-xl mb-4">
                                            <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                                                 alt="{{ $artigo->titulo }}" 
                                                 class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                        </div>
                                    @endif
                                    <h4 class="font-bold text-gray-800 hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                                        {{ $artigo->titulo_formatado }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $artigo->resumo_formatado }}</p>
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $artigo->publicado_em->format('d/m/Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $artigo->tempo_leitura }} min
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Conteúdo Principal -->
        <div class="lg:col-span-3">
            @if($artigos->count() > 0)
                <!-- Header da Seção -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Artigos Recentes</h2>
                        <p class="text-gray-600">Descubra os últimos insights do mercado imobiliário</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ $artigos->total() }} artigos encontrados</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($artigos as $artigo)
                        <article class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            @if($artigo->imagem_destaque)
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('blog.show', $artigo->slug) }}">
                                        <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                                             alt="{{ $artigo->titulo }}" 
                                             class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                                    </a>
                                    <div class="absolute top-4 left-4 flex flex-col space-y-2">
                                        <span class="inline-flex items-center bg-white/90 backdrop-blur-sm text-blue-700 text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            {{ ucfirst($artigo->categoria) }}
                                        </span>
                                        @if($artigo->destaque)
                                            <span class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                                <i class="fas fa-star mr-1"></i> Destaque
                                            </span>
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @else
                                <div class="h-56 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-6xl text-blue-300"></i>
                                </div>
                            @endif
                            
                            <div class="p-8">
                                <h2 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $artigo->slug) }}">
                                        {{ $artigo->titulo }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">{{ $artigo->resumo_formatado }}</p>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ $artigo->user->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span>{{ $artigo->visualizacoes }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <span>{{ $artigo->publicado_em->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>{{ $artigo->tempo_leitura }} min</span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <a href="{{ route('blog.show', $artigo->slug) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm group-hover:translate-x-1 transition-transform duration-300">
                                        Ler mais
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg p-4">
                        {{ $artigos->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-4xl text-blue-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum artigo encontrado</h3>
                        <p class="text-gray-600 mb-8">Tente ajustar os filtros de busca ou explore nossas categorias para encontrar conteúdo interessante.</p>
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-home mr-2"></i>
                            Ver todos os artigos
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Estilos customizados para o blog */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animações suaves */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

/* Hover effects personalizados */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

/* Gradientes personalizados */
.bg-gradient-blog {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Sombras personalizadas */
.shadow-blog {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Transições suaves */
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endsection
