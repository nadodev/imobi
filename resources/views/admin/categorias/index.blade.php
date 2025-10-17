@extends('layouts.admin')

@section('page-title', 'Gestão de Categorias')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Categorias do Blog</h1>
        <p class="text-gray-600">Gerencie as categorias dos artigos</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.categorias.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Nova Categoria
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categorias..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todas as categorias</option>
            <option value="ativa" {{ request('status') == 'ativa' ? 'selected' : '' }}>Ativas</option>
            <option value="inativa" {{ request('status') == 'inativa' ? 'selected' : '' }}>Inativas</option>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($categorias as $categoria)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center" 
                                     style="background-color: {{ $categoria->cor_formatada }}">
                                    <i class="{{ $categoria->icone_formatada }} text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $categoria->nome }}</div>
                                <div class="text-sm text-gray-500">{{ $categoria->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs">
                            {{ $categoria->descricao ? Str::limit($categoria->descricao, 100) : 'Sem descrição' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $categoria->total_artigos }} artigos
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $categoria->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $categoria->ativa ? 'Ativa' : 'Inativa' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $categoria->ordem }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categorias.show', $categoria) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categorias.edit', $categoria) }}" 
                               class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categorias.destroy', $categoria) }}" 
                                  class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
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
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-folder text-4xl text-gray-300 mb-4"></i>
                        <p>Nenhuma categoria encontrada</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
@if($categorias->hasPages())
    <div class="mt-6">
        {{ $categorias->links() }}
    </div>
@endif
@endsection

