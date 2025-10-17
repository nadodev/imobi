@extends('layouts.admin')

@section('page-title', 'Visualizar Categoria')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $categoria->nome }}</h1>
        <p class="text-gray-600">Visualizar categoria do blog</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.categorias.edit', $categoria) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-edit mr-2"></i> Editar
        </a>
        <a href="{{ route('admin.categorias.index') }}" 
           class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Conteúdo Principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Informações da Categoria -->
            <div class="mb-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center" 
                         style="background-color: {{ $categoria->cor_formatada }}">
                        <i class="{{ $categoria->icone_formatada }} text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $categoria->nome }}</h2>
                        <p class="text-gray-600">{{ $categoria->slug }}</p>
                    </div>
                </div>

                @if($categoria->descricao)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Descrição</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $categoria->descricao }}</p>
                    </div>
                @endif
            </div>

            <!-- Artigos da Categoria -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Artigos desta Categoria</h3>
                
                @if($categoria->artigos->count() > 0)
                    <div class="space-y-4">
                        @foreach($categoria->artigos as $artigo)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start space-x-4">
                                    @if($artigo->imagem_destaque)
                                        <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                                             alt="{{ $artigo->titulo }}"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-newspaper text-gray-400"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $artigo->titulo }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($artigo->resumo, 100) }}</p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $artigo->status === 'publicado' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $artigo->status === 'rascunho' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $artigo->status === 'arquivado' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($artigo->status) }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-eye mr-1"></i>{{ $artigo->visualizacoes }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ $artigo->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.artigos.show', $artigo) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.artigos.edit', $artigo) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Nenhum artigo encontrado nesta categoria</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Informações da Categoria -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $categoria->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $categoria->ativa ? 'Ativa' : 'Inativa' }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ordem</label>
                    <p class="text-sm text-gray-900">{{ $categoria->ordem }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Cor</label>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-full" style="background-color: {{ $categoria->cor_formatada }}"></div>
                        <span class="text-sm text-gray-900">{{ $categoria->cor_formatada }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ícone</label>
                    <div class="flex items-center space-x-2">
                        <i class="{{ $categoria->icone_formatada }} text-gray-600"></i>
                        <span class="text-sm text-gray-900">{{ $categoria->icone ?: 'fas fa-folder' }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Total de Artigos</label>
                    <p class="text-sm text-gray-900">{{ $categoria->total_artigos }}</p>
                </div>
            </div>
        </div>

        <!-- Datas -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Datas</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Criada em</label>
                    <p class="text-sm text-gray-900">{{ $categoria->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Atualizada em</label>
                    <p class="text-sm text-gray-900">{{ $categoria->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.categorias.edit', $categoria) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                    <i class="fas fa-edit mr-2"></i> Editar Categoria
                </a>

                @if($categoria->artigos->count() === 0)
                    <form method="POST" action="{{ route('admin.categorias.destroy', $categoria) }}" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i> Excluir Categoria
                        </button>
                    </form>
                @else
                    <div class="text-center py-2">
                        <p class="text-sm text-gray-500">Não é possível excluir categoria com artigos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

