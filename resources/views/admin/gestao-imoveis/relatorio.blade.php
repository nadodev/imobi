@extends('layouts.admin')

@section('title', 'Relatório - ' . $imovel->titulo)

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-chart-bar mr-2"></i>Relatório - {{ $imovel->titulo }}
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.gestao-imoveis.show', $imovel) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-eye mr-2"></i> Ver Detalhes
            </a>
            <a href="{{ route('admin.gestao-imoveis.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros de Período</h3>
        <form method="GET" action="{{ route('admin.gestao-imoveis.relatorio', $imovel) }}">
            <div class="flex space-x-4">
                <div>
                    <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Período (dias)</label>
                    <select name="periodo" id="periodo" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="7" {{ $periodo == '7' ? 'selected' : '' }}>Últimos 7 dias</option>
                        <option value="30" {{ $periodo == '30' ? 'selected' : '' }}>Últimos 30 dias</option>
                        <option value="90" {{ $periodo == '90' ? 'selected' : '' }}>Últimos 90 dias</option>
                        <option value="365" {{ $periodo == '365' ? 'selected' : '' }}>Último ano</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Resumo Geral -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-eye text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Visualizações</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $visualizacoesPorPeriodo->sum('total') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Leads Gerados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $leadsPorPeriodo->sum('total') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Taxa de Conversão</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $visualizacoesPorPeriodo->sum('total') > 0 ? number_format(($leadsPorPeriodo->sum('total') / $visualizacoesPorPeriodo->sum('total')) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-trophy text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Posição no Ranking</p>
                    <p class="text-2xl font-bold text-gray-900">#{{ $posicaoRanking }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Visualizações por Período -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualizações por Período</h3>
            <canvas id="visualizacoesChart" width="400" height="200"></canvas>
        </div>

        <!-- Gráfico de Visualizações por Origem -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualizações por Origem</h3>
            <canvas id="origemChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tabela de Conversão por Origem -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Conversão por Origem</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leads</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxa de Conversão</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($conversaoPorOrigem as $origem => $dados)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <i class="fas fa-{{ $origem == 'site' ? 'globe' : ($origem == 'whatsapp' ? 'whatsapp' : ($origem == 'instagram' ? 'instagram' : ($origem == 'facebook' ? 'facebook' : 'search'))) }} mr-2"></i>
                            {{ ucfirst($origem) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dados['visualizacoes'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dados['leads'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 text-xs rounded-full {{ $dados['taxa_conversao'] > 5 ? 'bg-green-100 text-green-800' : ($dados['taxa_conversao'] > 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($dados['taxa_conversao'], 1) }}%
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Comparação com Média -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Comparação com Média do Mercado</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-md font-medium text-gray-700 mb-2">Visualizações</h4>
                <div class="flex items-center">
                    <div class="flex-1 bg-gray-200 rounded-full h-2 mr-4">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $mediaVisualizacoes > 0 ? min(($visualizacoesPorPeriodo->sum('total') / $mediaVisualizacoes) * 100, 100) : 0 }}%"></div>
                    </div>
                    <span class="text-sm text-gray-600">
                        {{ $visualizacoesPorPeriodo->sum('total') }} / {{ number_format($mediaVisualizacoes, 1) }} média
                    </span>
                </div>
            </div>
            <div>
                <h4 class="text-md font-medium text-gray-700 mb-2">Performance</h4>
                <div class="text-center">
                    @if($visualizacoesPorPeriodo->sum('total') > $mediaVisualizacoes)
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-arrow-up mr-1"></i> Acima da média
                        </span>
                    @elseif($visualizacoesPorPeriodo->sum('total') < $mediaVisualizacoes)
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-arrow-down mr-1"></i> Abaixo da média
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                            <i class="fas fa-minus mr-1"></i> Na média
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de Visualizações por Período
const visualizacoesCtx = document.getElementById('visualizacoesChart').getContext('2d');
const visualizacoesData = @json($visualizacoesPorPeriodo);
const leadsData = @json($leadsPorPeriodo);

new Chart(visualizacoesCtx, {
    type: 'line',
    data: {
        labels: visualizacoesData.map(item => {
            const date = new Date(item.data);
            return date.toLocaleDateString('pt-BR');
        }),
        datasets: [{
            label: 'Visualizações',
            data: visualizacoesData.map(item => item.total),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.1
        }, {
            label: 'Leads',
            data: leadsData.map(item => item.total),
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Visualizações por Origem
const origemCtx = document.getElementById('origemChart').getContext('2d');
const origemData = @json($visualizacoesPorOrigem);

new Chart(origemCtx, {
    type: 'doughnut',
    data: {
        labels: origemData.map(item => item.origem.charAt(0).toUpperCase() + item.origem.slice(1)),
        datasets: [{
            data: origemData.map(item => item.total),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
@endsection
