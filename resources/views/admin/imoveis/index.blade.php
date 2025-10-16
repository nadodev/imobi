@extends('layouts.admin')

@section('page-title', 'Gestão de Imóveis')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin.imoveis.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus"></i> Novo Imóvel
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="tipo_id" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os tipos</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->nome }}
                </option>
            @endforeach
        </select>

        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os status</option>
            <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
            <option value="vendido" {{ request('status') == 'vendido' ? 'selected' : '' }}>Vendido</option>
            <option value="alugado" {{ request('status') == 'alugado' ? 'selected' : '' }}>Alugado</option>
            <option value="oculto" {{ request('status') == 'oculto' ? 'selected' : '' }}>Oculto</option>
        </select>

        <button type="submit" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-search"></i> Filtrar
        </button>
    </form>
</div>

<!-- Tabela -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagem</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preço</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($imoveis as $imovel)
                <tr>
                    <td class="px-6 py-4">
                        @if($imovel->imagemPrincipal)
                            <img src="{{ asset('storage/' . $imovel->imagemPrincipal->caminho) }}" 
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->codigo }}</td>
                    <td class="px-6 py-4">
                        {{ $imovel->titulo }}
                        @if($imovel->destaque)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->tipo->nome }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->preco_formatado }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $imovel->status === 'ativo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($imovel->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('imoveis.show', $imovel->slug) }}" target="_blank"
                           class="text-blue-600 hover:text-blue-900 mr-3" title="Visualizar">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.imoveis.edit', $imovel) }}" 
                           class="text-yellow-600 hover:text-yellow-900 mr-3" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.imoveis.destroy', $imovel) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza?')"
                                    class="text-red-600 hover:text-red-900" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        Nenhum imóvel encontrado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="mt-6">
    {{ $imoveis->links() }}
</div>
@endsection

