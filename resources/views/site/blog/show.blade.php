@extends('layouts.site')

@section('title', $artigo->titulo . ' - Blog Imobiliário')
@section('description', $artigo->resumo)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Início</a></li>
                <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
                <li><a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Blog</a></li>
                <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
                <li><a href="{{ route('blog.categoria', $artigo->categoria) }}" class="text-gray-500 hover:text-blue-600 transition-colors">{{ ucfirst($artigo->categoria) }}</a></li>
                <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
                <li class="text-gray-900 font-medium">{{ $artigo->titulo_formatado }}</li>
            </ol>
        </nav>

        <article class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            @if($artigo->imagem_destaque)
                <div class="relative">
                    <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                         alt="{{ $artigo->titulo }}" 
                         class="w-full h-80 md:h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div class="absolute top-6 left-6 flex flex-col space-y-3">
                        <span class="inline-flex items-center bg-white/90 backdrop-blur-sm text-blue-700 text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                            {{ ucfirst($artigo->categoria) }}
                        </span>
                        @if($artigo->destaque)
                            <span class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                                <i class="fas fa-star mr-2"></i> Destaque
                            </span>
                        @endif
                    </div>
                </div>
            @endif
            
            <div class="p-4">
                <!-- Cabeçalho do Artigo -->
                <header class="mb-10">
                   
                    
                    <div class="flex flex-wrap items-center justify-between gap-4 py-6 border-b border-gray-200">
                        <div class="flex flex-wrap items-center gap-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $artigo->user->name }}</p>
                                    <p class="text-sm text-gray-500">Autor</p>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $artigo->publicado_em->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $artigo->tempo_leitura }} min de leitura</span>
                            </div>
                        </div>
                        <div class="flex items-center bg-gray-50 px-4 py-2 rounded-full">
                            <i class="fas fa-eye mr-2 text-gray-500"></i>
                            <span class="font-semibold text-gray-700">{{ $artigo->visualizacoes }} visualizações</span>
                        </div>
                    </div>
                </header>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">{{ $artigo->titulo }}</h1>
                <!-- Resumo -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-8 mb-10 rounded-r-2xl">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4 mt-1">
                            <i class="fas fa-lightbulb text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">Resumo do Artigo</h3>
                            <p class="text-gray-700 text-lg leading-relaxed">{{ $artigo->resumo }}</p>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-p:text-gray-700 prose-p:leading-relaxed prose-strong:text-gray-900 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700">
                    {!! nl2br(e($artigo->conteudo)) !!}
                </div>

                <!-- Tags -->
                @if($artigo->tags && count($artigo->tags) > 0)
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-tags text-white text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Tags Relacionadas</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach($artigo->tags as $tag)
                                <span class="inline-flex items-center bg-gradient-to-r from-gray-100 to-gray-200 hover:from-blue-100 hover:to-indigo-200 text-gray-700 hover:text-blue-700 text-sm px-4 py-2 rounded-full transition-all duration-300 cursor-pointer">
                                    <i class="fas fa-hashtag mr-1"></i>
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Compartilhamento -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Compartilhar Artigo</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-facebook-f mr-2"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($artigo->titulo) }}" 
                           target="_blank" 
                           class="flex items-center justify-center px-6 py-3 bg-blue-400 text-white rounded-xl hover:bg-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-twitter mr-2"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($artigo->titulo . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           class="flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                        <button onclick="copiarLink()" 
                                class="flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-link mr-2"></i> Copiar Link
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Artigos Relacionados -->
        @if($artigosRelacionados->count() > 0)
            <section class="mt-16">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full px-6 py-3 mb-4">
                        <i class="fas fa-newspaper text-blue-600 mr-2"></i>
                        <span class="text-blue-700 font-semibold">Leia Também</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Artigos Relacionados</h2>
                    <p class="text-gray-600 text-lg">Continue explorando nosso conteúdo especializado</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($artigosRelacionados as $artigoRelacionado)
                        <article class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            @if($artigoRelacionado->imagem_destaque)
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('blog.show', $artigoRelacionado->slug) }}">
                                        <img src="{{ asset('storage/' . $artigoRelacionado->imagem_destaque) }}" 
                                             alt="{{ $artigoRelacionado->titulo }}" 
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                    </a>
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center bg-white/90 backdrop-blur-sm text-blue-700 text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            {{ ucfirst($artigoRelacionado->categoria) }}
                                        </span>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-4xl text-blue-300"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $artigoRelacionado->slug) }}">
                                        {{ $artigoRelacionado->titulo_formatado }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $artigoRelacionado->resumo_formatado }}</p>
                                
                                <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $artigoRelacionado->publicado_em->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $artigoRelacionado->tempo_leitura }} min
                                    </span>
                                </div>
                                
                                <div class="mt-4">
                                    <a href="{{ route('blog.show', $artigoRelacionado->slug) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm group-hover:translate-x-1 transition-transform duration-300">
                                        Ler artigo
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>

<script>
function copiarLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Criar notificação personalizada
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Link copiado com sucesso!';
        
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
    }).catch(function() {
        // Fallback para navegadores mais antigos
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        alert('Link copiado para a área de transferência!');
    });
}
</script>

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

/* Estilos para o conteúdo do artigo */
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    line-height: 1.25;
}

.prose h1 {
    font-size: 2.25rem;
}

.prose h2 {
    font-size: 1.875rem;
}

.prose h3 {
    font-size: 1.5rem;
}

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.prose ul, .prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose strong {
    font-weight: 700;
    color: #1f2937;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8fafc;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
@endsection
