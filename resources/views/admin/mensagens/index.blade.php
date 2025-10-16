@extends('layouts.admin')

@section('page-title', 'Mensagens')

@section('content')
<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os status</option>
            <option value="nao_lida" {{ request('status') == 'nao_lida' ? 'selected' : '' }}>Não lida</option>
            <option value="lida" {{ request('status') == 'lida' ? 'selected' : '' }}>Lida</option>
            <option value="respondida" {{ request('status') == 'respondida' ? 'selected' : '' }}>Respondida</option>
        </select>

        <button type="submit" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-search"></i> Filtrar
        </button>
    </form>
</div>

<!-- Lista de Mensagens -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contato</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mensagem</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($mensagens as $mensagem)
                <tr class="{{ $mensagem->status === 'nao_lida' ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ $mensagem->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4">{{ $mensagem->nome }}</td>
                    <td class="px-6 py-4 text-sm">
                        {{ $mensagem->email }}<br>
                        <span class="text-gray-500">{{ $mensagem->telefone }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="line-clamp-2 text-sm">{{ $mensagem->mensagem }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $mensagem->status === 'nao_lida' ? 'bg-red-100 text-red-800' : 
                               ($mensagem->status === 'respondida' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ str_replace('_', ' ', ucfirst($mensagem->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.mensagens.show', $mensagem) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.mensagens.destroy', $mensagem) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza?')"
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Nenhuma mensagem encontrada
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="mt-6">
    {{ $mensagens->links() }}
</div>
@endsection

