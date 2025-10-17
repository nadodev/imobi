@extends('layouts.admin')

@section('page-title', 'Gestão de Avaliações')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Avaliações de Imóveis</h1>
        <p class="text-gray-600">Gerencie as avaliações e comentários dos clientes</p>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou email..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os status</option>
            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
            <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
        </select>

        <select name="avaliacao" class="px-4 py-2 border rounded-lg">
            <option value="">Todas as avaliações</option>
            <option value="5" {{ request('avaliacao') == '5' ? 'selected' : '' }}>5 estrelas</option>
            <option value="4" {{ request('avaliacao') == '4' ? 'selected' : '' }}>4 estrelas</option>
            <option value="3" {{ request('avaliacao') == '3' ? 'selected' : '' }}>3 estrelas</option>
            <option value="2" {{ request('avaliacao') == '2' ? 'selected' : '' }}>2 estrelas</option>
            <option value="1" {{ request('avaliacao') == '1' ? 'selected' : '' }}>1 estrela</option>
        </select>

        <button type="submit" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-search"></i> Filtrar
        </button>
    </form>
</div>

<!-- Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pendentes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pendentes'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Aprovadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['aprovadas'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <i class="fas fa-times text-red-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Rejeitadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['rejeitadas'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-star text-blue-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Média Geral</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['media_geral'] ?? 0, 1) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabela -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avaliação</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comentário</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($avaliacoes as $avaliacao)
                <tr>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $avaliacao->nome }}</div>
                            <div class="text-sm text-gray-500">{{ $avaliacao->email }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $avaliacao->imovel->titulo }}</div>
                        <div class="text-sm text-gray-500">{{ $avaliacao->imovel->cidade }}, {{ $avaliacao->imovel->bairro }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $avaliacao->avaliacao ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ $avaliacao->avaliacao_texto }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs">
                            {{ $avaliacao->comentario ? Str::limit($avaliacao->comentario, 100) : 'Sem comentário' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $avaliacao->status === 'aprovado' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $avaliacao->status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $avaliacao->status === 'rejeitado' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($avaliacao->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.avaliacoes.show', $avaliacao) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Ver detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($avaliacao->status === 'pendente')
                                <form method="POST" action="{{ route('admin.avaliacoes.aprovar', $avaliacao) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Aprovar"
                                            onclick="return confirm('Aprovar esta avaliação?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.avaliacoes.rejeitar', $avaliacao) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Rejeitar"
                                            onclick="return confirm('Rejeitar esta avaliação?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.avaliacoes.destroy', $avaliacao) }}" 
                                  class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?')">
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
                        <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                        <p>Nenhuma avaliação encontrada</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
@if($avaliacoes->hasPages())
    <div class="mt-6">
        {{ $avaliacoes->links() }}
    </div>
@endif
@endsection

