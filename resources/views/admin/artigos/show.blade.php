@extends('layouts.admin')

@section('page-title', 'Visualizar Artigo')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $artigo->titulo }}</h1>
        <p class="text-gray-600">Visualizar artigo do blog</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.artigos.edit', $artigo) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-edit mr-2"></i> Editar
        </a>
        <a href="{{ route('admin.artigos.index') }}" 
           class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Conteúdo Principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Imagem de Destaque -->
            @if($artigo->imagem_destaque)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                         alt="{{ $artigo->titulo }}"
                         class="w-full h-64 object-cover rounded-lg">
                </div>
            @endif

            <!-- Resumo -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Resumo</h2>
                <p class="text-gray-700 leading-relaxed">{{ $artigo->resumo }}</p>
            </div>

            <!-- Conteúdo -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Conteúdo</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($artigo->conteudo)) !!}
                </div>
            </div>

            <!-- Tags -->
            @if($artigo->tags && count($artigo->tags) > 0)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($artigo->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Informações do Artigo -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $artigo->status === 'publicado' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $artigo->status === 'rascunho' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $artigo->status === 'arquivado' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ ucfirst($artigo->status) }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Categoria</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($artigo->categoria) }}
                    </span>
                </div>

                @if($artigo->destaque)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Destaque</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i> Em Destaque
                        </span>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700">Autor</label>
                    <p class="text-sm text-gray-900">{{ $artigo->user->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Visualizações</label>
                    <p class="text-sm text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-1 text-gray-400"></i>
                        {{ $artigo->visualizacoes }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Datas -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Datas</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Criado em</label>
                    <p class="text-sm text-gray-900">{{ $artigo->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Atualizado em</label>
                    <p class="text-sm text-gray-900">{{ $artigo->updated_at->format('d/m/Y H:i') }}</p>
                </div>

                @if($artigo->publicado_em)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Publicado em</label>
                        <p class="text-sm text-gray-900">{{ $artigo->publicado_em->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ações -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
            
            <div class="space-y-3">
                <a href="{{ route('blog.show', $artigo->slug) }}" target="_blank"
                   class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                    <i class="fas fa-external-link-alt mr-2"></i> Ver no Site
                </a>

                <a href="{{ route('admin.artigos.edit', $artigo) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                    <i class="fas fa-edit mr-2"></i> Editar Artigo
                </a>

                <form method="POST" action="{{ route('admin.artigos.destroy', $artigo) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir este artigo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i> Excluir Artigo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

