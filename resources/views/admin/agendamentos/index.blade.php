@extends('layouts.admin')

@section('page-title', 'Agendamentos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Agendamentos</h1>
        <p class="text-gray-600">Gerencie todas as visitas agendadas</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.agendamentos.calendario') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-calendar-alt mr-2"></i> Calendário
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar cliente..."
               class="px-4 py-2 border rounded-lg">
        
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Todos os status</option>
            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            <option value="realizado" {{ request('status') == 'realizado' ? 'selected' : '' }}>Realizado</option>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contato</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imóvel</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($agendamentos as $agendamento)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $agendamento->data_formatada }}</td>
                    <td class="px-6 py-4">{{ $agendamento->nome_cliente }}</td>
                    <td class="px-6 py-4">
                        {{ $agendamento->telefone }}<br>
                        <span class="text-sm text-gray-500">{{ $agendamento->email }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($agendamento->imovel)
                            <a href="{{ route('imoveis.show', $agendamento->imovel->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $agendamento->imovel->codigo }}
                            </a>
                        @else
                            <span class="text-gray-400">Imóvel removido</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $agendamento->status_badge }}-100 text-{{ $agendamento->status_badge }}-800">
                            {{ ucfirst($agendamento->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.agendamentos.show', $agendamento) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.agendamentos.destroy', $agendamento) }}" method="POST" class="inline">
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
                        Nenhum agendamento encontrado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="mt-6">
    {{ $agendamentos->links() }}
</div>
@endsection

