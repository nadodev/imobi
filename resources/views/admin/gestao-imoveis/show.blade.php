@extends('layouts.admin')

@section('title', 'Detalhes da Gestão - ' . $imovel->titulo)

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-home mr-2"></i>{{ $imovel->titulo }}
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.gestao-imoveis.edit', $imovel) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> Editar Gestão
            </a>
            <a href="{{ route('admin.gestao-imoveis.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if($imovel->data_vencimento_aluguel && $imovel->isContratoVencendo())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <span class="text-red-700 font-medium">Atenção: Contrato de aluguel vencendo em {{ $imovel->data_vencimento_aluguel->diffForHumans() }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações do Imóvel -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações do Imóvel</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Código</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $imovel->codigo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipo</label>
                        <p class="text-lg text-gray-900">{{ $imovel->tipo->nome }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Finalidade</label>
                        <p class="text-lg text-gray-900">{{ $imovel->finalidade->nome }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Preço</label>
                        <p class="text-lg font-semibold text-green-600">{{ $imovel->preco_formatado }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Endereço</label>
                        <p class="text-lg text-gray-900">{{ $imovel->endereco }}</p>
                    </div>
                </div>
            </div>

            <!-- Status de Gestão -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status de Gestão</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Atual</label>
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-{{ $imovel->status_gestao_color ?? 'gray' }}-100 text-{{ $imovel->status_gestao_color ?? 'gray' }}-800">
                            {{ $imovel->status_gestao_label ?? 'Não definido' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Corretor Responsável</label>
                        <p class="text-lg text-gray-900">{{ $imovel->corretorResponsavel->name ?? 'Não atribuído' }}</p>
                    </div>
                </div>
            </div>

            <!-- Controle de Chaves -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Controle de Chaves</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Número de Chaves</label>
                        <p class="text-lg text-gray-900">{{ $imovel->numero_chaves ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Localização</label>
                        <p class="text-lg text-gray-900">{{ $imovel->localizacao_chaves ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Datas Importantes -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Datas Importantes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Revisão do Contrato</label>
                        <p class="text-lg text-gray-900">
                            @if($imovel->data_revisao_contrato)
                                {{ $imovel->data_revisao_contrato->format('d/m/Y') }}
                            @else
                                Não definida
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Vencimento do Aluguel</label>
                        <p class="text-lg {{ $imovel->isContratoVencendo() ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                            @if($imovel->data_vencimento_aluguel)
                                {{ $imovel->data_vencimento_aluguel->format('d/m/Y') }}
                                @if($imovel->isContratoVencendo())
                                    <span class="text-sm text-red-500">(Vencendo!)</span>
                                @endif
                            @else
                                Não definida
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            @if($imovel->observacoes_gestao)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Observações de Gestão</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $imovel->observacoes_gestao }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Métricas de Visualização -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Métricas de Visualização</h3>
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $imovel->total_visualizacoes ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Total de Visualizações</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $imovel->visualizacoes_hoje ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Hoje</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $imovel->visualizacoes_esta_semana ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Esta Semana</div>
                    </div>
                </div>
            </div>

            <!-- Leads Relacionados -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Leads Relacionados</h3>
                @if($imovel->leads->count() > 0)
                    <div class="space-y-3">
                        @foreach($imovel->leads->take(5) as $lead)
                            <div class="border-l-4 border-blue-500 pl-3">
                                <div class="text-sm font-medium text-gray-900">{{ $lead->nome }}</div>
                                <div class="text-xs text-gray-500">{{ $lead->email }}</div>
                                <span class="inline-flex px-2 py-1 text-xs rounded-full bg-{{ $lead->status_color }}-100 text-{{ $lead->status_color }}-800">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </div>
                        @endforeach
                        @if($imovel->leads->count() > 5)
                            <div class="text-center">
                                <a href="{{ route('admin.crm.leads') }}?imovel={{ $imovel->id }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Ver todos ({{ $imovel->leads->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Nenhum lead relacionado</p>
                @endif
            </div>

            <!-- Tarefas Relacionadas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tarefas Relacionadas</h3>
                @if($imovel->tarefas->count() > 0)
                    <div class="space-y-3">
                        @foreach($imovel->tarefas->where('status', '!=', 'concluida')->take(5) as $tarefa)
                            <div class="border-l-4 border-{{ $tarefa->prioridade_color }}-500 pl-3">
                                <div class="text-sm font-medium text-gray-900">{{ $tarefa->titulo }}</div>
                                <div class="text-xs text-gray-500">{{ $tarefa->data_vencimento->format('d/m/Y H:i') }}</div>
                                <span class="inline-flex px-2 py-1 text-xs rounded-full bg-{{ $tarefa->status_color }}-100 text-{{ $tarefa->status_color }}-800">
                                    {{ ucfirst($tarefa->status) }}
                                </span>
                            </div>
                        @endforeach
                        @if($imovel->tarefas->count() > 5)
                            <div class="text-center">
                                <a href="{{ route('admin.crm.tarefas') }}?imovel={{ $imovel->id }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Ver todas ({{ $imovel->tarefas->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Nenhuma tarefa relacionada</p>
                @endif
            </div>

            <!-- Ações Rápidas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ações Rápidas</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.gestao-imoveis.relatorio', $imovel) }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar mr-2"></i> Relatório
                    </a>
                    <a href="{{ route('admin.crm.leads.create') }}?imovel={{ $imovel->id }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i> Novo Lead
                    </a>
                    <a href="{{ route('admin.crm.tarefas.create') }}?imovel={{ $imovel->id }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tasks mr-2"></i> Nova Tarefa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
