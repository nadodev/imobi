@extends('layouts.admin')

@section('title', 'Dashboard CRM')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-chart-line mr-2"></i>Dashboard CRM
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.crm.leads') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-users mr-2"></i> Leads
            </a>
            <a href="{{ route('admin.crm.tarefas') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-tasks mr-2"></i> Tarefas
            </a>
            <a href="{{ route('admin.crm.funil') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-funnel-dollar mr-2"></i> Funil
            </a>
        </div>
    </div>

    <!-- Métricas Principais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total de Leads -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 uppercase tracking-wide">Total de Leads</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalLeads }}</p>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Leads Novos -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 uppercase tracking-wide">Leads Novos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $leadsNovos }}</p>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-user-plus text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Leads Qualificados -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 uppercase tracking-wide">Qualificados</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $leadsQualificados }}</p>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-user-check text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Leads Fechados -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 uppercase tracking-wide">Fechados</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $leadsFechados }}</p>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-handshake text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas de Tarefas e Visualizações -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Tarefas Pendentes -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600 uppercase tracking-wide">Tarefas Pendentes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $tarefasPendentes }}</p>
                </div>
                <div class="text-red-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Tarefas Vencidas -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Tarefas Vencidas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $tarefasVencidas }}</p>
                </div>
                <div class="text-gray-500">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Visualizações Hoje -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 uppercase tracking-wide">Visualizações Hoje</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $visualizacoesHoje }}</p>
                </div>
                <div class="text-indigo-500">
                    <i class="fas fa-eye text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Visualizações Este Mês -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-pink-600 uppercase tracking-wide">Visualizações Este Mês</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $visualizacoesEsteMes }}</p>
                </div>
                <div class="text-pink-500">
                    <i class="fas fa-chart-bar text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Funil de Vendas -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Funil de Vendas</h3>
                    <a href="{{ route('admin.crm.funil') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Ver Detalhes</a>
                </div>
                <div class="funil-container">
                    @foreach($funilVendas as $status => $quantidade)
                    <div class="funil-stage">
                        <div class="funil-bar" style="height: {{ max(20, ($quantidade / max($funilVendas)) * 200) }}px;">
                            <span class="funil-count">{{ $quantidade }}</span>
                        </div>
                        <div class="funil-label">{{ ucfirst($status) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Leads por Origem -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Leads por Origem</h3>
            <div class="space-y-3">
                @foreach($leadsPorOrigem as $origem => $total)
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-circle text-{{ $origem === 'site' ? 'blue' : ($origem === 'whatsapp' ? 'green' : ($origem === 'instagram' ? 'pink' : 'yellow')) }} mr-2"></i>
                        <span class="capitalize">{{ $origem }}</span>
                    </div>
                    <span class="font-bold">{{ $total }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Imóveis Mais Visualizados -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Imóveis Mais Visualizados</h3>
            <div class="space-y-4">
                @foreach($imoveisMaisVisualizados as $imovel)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <div class="font-semibold">{{ $imovel->titulo }}</div>
                        <small class="text-gray-500">{{ $imovel->codigo }}</small>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-600">{{ $imovel->visualizacoes_count }}</div>
                        <small class="text-gray-500">visualizações</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tarefas Urgentes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tarefas Urgentes</h3>
            <div class="space-y-4">
                @foreach($tarefasUrgentes as $tarefa)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <div class="font-semibold">{{ $tarefa->titulo }}</div>
                        <small class="text-gray-500">
                            <i class="fas fa-{{ $tarefa->tipo_icon }} mr-1"></i>
                            {{ ucfirst($tarefa->tipo) }} - {{ $tarefa->data_vencimento->format('d/m/Y') }}
                        </small>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $tarefa->prioridade_color }}-100 text-{{ $tarefa->prioridade_color }}-800">
                            {{ ucfirst($tarefa->prioridade) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Leads Recentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Leads Recentes</h3>
            <a href="{{ route('admin.crm.leads') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Ver Todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corretor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($leadsRecentes as $lead)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $lead->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $lead->email }}</div>
                            <div class="text-sm text-gray-500">{{ $lead->telefone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <i class="fas fa-{{ $lead->origem_icon }} mr-1"></i>
                            {{ ucfirst($lead->origem) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $lead->status_color }}-100 text-{{ $lead->status_color }}-800">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lead->corretor->name ?? 'Não atribuído' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $lead->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.funil-container {
    display: flex;
    align-items: end;
    justify-content: space-between;
    height: 250px;
    padding: 20px 0;
}

.funil-stage {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 5px;
}

.funil-bar {
    width: 100%;
    background: linear-gradient(to top, #4f46e5, #06b6d4);
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    min-height: 20px;
}

.funil-count {
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.funil-label {
    margin-top: 10px;
    font-size: 12px;
    text-align: center;
    font-weight: 500;
    color: #6b7280;
}
</style>
@endsection