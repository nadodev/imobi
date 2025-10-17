@extends('layouts.admin')

@section('page-title', 'Gestão do Blog')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Artigos do Blog</h1>
        <p class="text-gray-600">Gerencie os artigos e conteúdo do blog</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.artigos.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Novo Artigo
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar artigos..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os status</option>
            <option value="rascunho" {{ request('status') == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
            <option value="publicado" {{ request('status') == 'publicado' ? 'selected' : '' }}>Publicado</option>
            <option value="arquivado" {{ request('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
        </select>

        <select name="categoria" class="px-4 py-2 border rounded-lg">
            <option value="">Todas as categorias</option>
            <option value="geral" {{ request('categoria') == 'geral' ? 'selected' : '' }}>Geral</option>
            <option value="dicas" {{ request('categoria') == 'dicas' ? 'selected' : '' }}>Dicas</option>
            <option value="mercado" {{ request('categoria') == 'mercado' ? 'selected' : '' }}>Mercado</option>
            <option value="financiamento" {{ request('categoria') == 'financiamento' ? 'selected' : '' }}>Financiamento</option>
            <option value="investimento" {{ request('categoria') == 'investimento' ? 'selected' : '' }}>Investimento</option>
        </select>

        <button type="submit" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-search"></i> Filtrar
        </button>
    </form>
</div>

<!-- Tabela -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($artigos as $artigo)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($artigo->imagem_destaque)
                                <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                                     class="w-12 h-12 object-cover rounded mr-4">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-4 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $artigo->titulo }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($artigo->resumo, 60) }}</div>
                                @if($artigo->destaque)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                        <i class="fas fa-star mr-1"></i> Destaque
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($artigo->categoria) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $artigo->status === 'publicado' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $artigo->status === 'rascunho' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $artigo->status === 'arquivado' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ ucfirst($artigo->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $artigo->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-1 text-gray-400"></i>
                            {{ $artigo->visualizacoes }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $artigo->created_at->format('d/m/Y') }}
                        @if($artigo->publicado_em)
                            <br><span class="text-xs text-green-600">Publicado: {{ $artigo->publicado_em->format('d/m/Y') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.artigos.show', $artigo) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.artigos.edit', $artigo) }}" 
                               class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.artigos.destroy', $artigo) }}" 
                                  class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este artigo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                        <p>Nenhum artigo encontrado</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
@if($artigos->hasPages())
    <div class="mt-6">
        {{ $artigos->links() }}
    </div>
@endif
@endsection
