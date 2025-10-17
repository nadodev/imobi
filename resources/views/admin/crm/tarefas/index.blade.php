@extends('layouts.admin')

@section('title', 'Gestão de Tarefas')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-tasks mr-2"></i>Gestão de Tarefas
        </h1>
        <a href="{{ route('admin.crm.tarefas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Nova Tarefa
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        <form method="GET" action="{{ route('admin.crm.tarefas') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                        <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div>
                    <label for="prioridade" class="block text-sm font-medium text-gray-700 mb-1">Prioridade</label>
                    <select name="prioridade" id="prioridade" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas</option>
                        <option value="baixa" {{ request('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ request('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ request('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ request('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="tipo" id="tipo" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="ligacao" {{ request('tipo') == 'ligacao' ? 'selected' : '' }}>Ligação</option>
                        <option value="email" {{ request('tipo') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="whatsapp" {{ request('tipo') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="visita" {{ request('tipo') == 'visita' ? 'selected' : '' }}>Visita</option>
                        <option value="proposta" {{ request('tipo') == 'proposta' ? 'selected' : '' }}>Proposta</option>
                        <option value="followup" {{ request('tipo') == 'followup' ? 'selected' : '' }}>Follow-up</option>
                        <option value="outro" {{ request('tipo') == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Responsável</label>
                    <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('user_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex space-x-2 mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                <a href="{{ route('admin.crm.tarefas') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Tarefas -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tarefas ({{ $tarefas->total() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lead/Imóvel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tarefas as $tarefa)
                    <tr class="hover:bg-gray-50 {{ $tarefa->isVencida() ? 'bg-red-50' : ($tarefa->isVencendoHoje() ? 'bg-yellow-50' : '') }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $tarefa->titulo }}</div>
                            @if($tarefa->descricao)
                                <div class="text-sm text-gray-500">{{ Str::limit($tarefa->descricao, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <i class="fas fa-{{ $tarefa->tipo_icon }} mr-1"></i>
                            {{ ucfirst($tarefa->tipo) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $tarefa->prioridade_color }}-100 text-{{ $tarefa->prioridade_color }}-800">
                                {{ ucfirst($tarefa->prioridade) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $tarefa->status_color }}-100 text-{{ $tarefa->status_color }}-800">
                                {{ ucfirst($tarefa->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $tarefa->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="{{ $tarefa->isVencida() ? 'text-red-600 font-semibold' : ($tarefa->isVencendoHoje() ? 'text-yellow-600 font-semibold' : '') }}">
                                {{ $tarefa->data_vencimento->format('d/m/Y H:i') }}
                            </div>
                            @if($tarefa->isVencida())
                                <div class="text-xs text-red-500">Vencida há {{ $tarefa->data_vencimento->diffForHumans() }}</div>
                            @elseif($tarefa->isVencendoHoje())
                                <div class="text-xs text-yellow-600">Vence hoje!</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($tarefa->lead)
                                <div class="text-blue-600">
                                    <i class="fas fa-user mr-1"></i>{{ $tarefa->lead->nome }}
                                </div>
                            @endif
                            @if($tarefa->imovel)
                                <div class="text-green-600">
                                    <i class="fas fa-home mr-1"></i>{{ $tarefa->imovel->codigo }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($tarefa->status !== 'concluida')
                                <form method="POST" action="{{ route('admin.crm.tarefas.concluir', $tarefa) }}" 
                                      style="display: inline;" onsubmit="return confirm('Marcar como concluída?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Concluir">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-tasks text-4xl mb-4"></i>
                            <div class="text-lg">Nenhuma tarefa encontrada</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($tarefas->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $tarefas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection