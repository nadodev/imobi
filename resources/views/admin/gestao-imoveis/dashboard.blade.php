@extends('layouts.admin')

@section('title', 'Dashboard de Gestão de Imóveis')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-chart-pie mr-2"></i>Dashboard de Gestão de Imóveis
        </h1>
        <a href="{{ route('admin.gestao-imoveis.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-list mr-2"></i> Ver Todos os Imóveis
        </a>
    </div>

    <!-- Alertas de Contratos Vencendo -->
    @if($contratosVencendoHoje > 0)
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <span class="text-red-700 font-medium">
                    Atenção: {{ $contratosVencendoHoje }} contrato(s) vencendo hoje!
                </span>
            </div>
        </div>
    @endif

    @if($contratosVencendo > 0)
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                <span class="text-yellow-700 font-medium">
                    {{ $contratosVencendo }} contrato(s) vencendo nos próximos 30 dias
                </span>
            </div>
        </div>
    @endif

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-home text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Imóveis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalImoveis }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Livre</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $imoveisLivres }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Reservado</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $imoveisReservados }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-handshake text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Vendido</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $imoveisVendidos }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-key text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Alugado</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $imoveisAlugados }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Status de Gestão -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status de Gestão</h3>
            <canvas id="statusChart" width="400" height="200"></canvas>
        </div>

        <!-- Performance por Corretor -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance por Corretor</h3>
            <div class="space-y-4">
                @foreach($performanceCorretores as $corretor)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $corretor->name }}</p>
                            <p class="text-sm text-gray-500">{{ $corretor->imoveis_total }} imóveis</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600">{{ $corretor->imoveis_vendidos }}</p>
                            <p class="text-xs text-gray-500">vendidos</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Imóveis Mais Visualizados -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Imóveis Mais Visualizados</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corretor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($imoveisMaisVisualizados as $imovel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $imovel->titulo }}</div>
                            <div class="text-sm text-gray-500">{{ $imovel->codigo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $imovel->status_gestao_color ?? 'gray' }}-100 text-{{ $imovel->status_gestao_color ?? 'gray' }}-800">
                                {{ $imovel->status_gestao_label ?? 'Não definido' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $imovel->corretorResponsavel->name ?? 'Não atribuído' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="text-lg font-bold text-blue-600">{{ $imovel->visualizacoes instanceof \Illuminate\Database\Eloquent\Collection ? $imovel->visualizacoes->count() : 0 }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.gestao-imoveis.show', $imovel) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.gestao-imoveis.edit', $imovel) }}" 
                                   class="text-green-600 hover:text-green-900" title="Editar Gestão">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.gestao-imoveis.relatorio', $imovel) }}" 
                                   class="text-purple-600 hover:text-purple-900" title="Relatório">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-home text-4xl mb-4"></i>
                            <div class="text-lg">Nenhum imóvel encontrado</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de Status de Gestão
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = @json($statusGestao);

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Livre', 'Reservado', 'Vendido', 'Alugado', 'Indisponível'],
        datasets: [{
            data: [
                statusData.livre,
                statusData.reservado,
                statusData.vendido,
                statusData.alugado,
                statusData.indisponivel
            ],
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(107, 114, 128, 0.8)'
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
