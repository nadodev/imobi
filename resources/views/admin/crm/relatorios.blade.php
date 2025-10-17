@extends('layouts.admin')

@section('title', 'Relatórios de Performance')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-chart-bar mr-2"></i>Relatórios de Performance
        </h1>
        <a href="{{ route('admin.crm.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar ao Dashboard
        </a>
    </div>

    <!-- Filtros de Período -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        <form method="GET" action="{{ route('admin.crm.relatorios') }}">
            <div class="flex items-center space-x-4">
                <div>
                    <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Período (dias)</label>
                    <select name="periodo" id="periodo" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="7" {{ $periodo == 7 ? 'selected' : '' }}>Últimos 7 dias</option>
                        <option value="30" {{ $periodo == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                        <option value="90" {{ $periodo == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                        <option value="365" {{ $periodo == 365 ? 'selected' : '' }}>Último ano</option>
                    </select>
                </div>
                <div class="pt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-filter mr-2"></i> Aplicar Filtro
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Performance por Imóvel -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance por Imóvel</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leads Gerados</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxa de Conversão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($performanceImoveis as $imovel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $imovel->titulo }}</div>
                            <div class="text-sm text-gray-500">{{ $imovel->codigo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $imovel->visualizacoes_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">{{ $imovel->leads_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $taxaConversao = $imovel->visualizacoes_count > 0 ? 
                                    ($imovel->leads_count / $imovel->visualizacoes_count) * 100 : 0;
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $taxaConversao > 5 ? 'bg-green-100 text-green-800' : ($taxaConversao > 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($taxaConversao, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                {{ $imovel->status_gestao_label ?? 'Não definido' }}
                            </span>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Performance por Origem -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance por Origem</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% do Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $totalVisualizacoes = $performanceOrigem->sum('total'); @endphp
                        @forelse($performanceOrigem as $origem)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <i class="fas fa-{{ $origem->origem === 'site' ? 'globe' : ($origem->origem === 'whatsapp' ? 'whatsapp' : ($origem->origem === 'instagram' ? 'instagram' : ($origem->origem === 'facebook' ? 'facebook' : 'google'))) }} mr-2"></i>
                                {{ ucfirst($origem->origem) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $origem->total }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $percentual = $totalVisualizacoes > 0 ? ($origem->total / $totalVisualizacoes) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentual }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($percentual, 1) }}%</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-chart-pie text-4xl mb-4"></i>
                                <div class="text-lg">Nenhum dado encontrado</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Conversão por Canal -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Conversão por Canal</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Canal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leads</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxa de Conversão</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($conversaoCanal as $canal => $dados)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <i class="fas fa-{{ $canal === 'site' ? 'globe' : ($canal === 'whatsapp' ? 'whatsapp' : ($canal === 'instagram' ? 'instagram' : ($canal === 'facebook' ? 'facebook' : 'google'))) }} mr-2"></i>
                                {{ ucfirst($canal) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $dados['visualizacoes'] }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">{{ $dados['leads'] }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $dados['taxa_conversao'] > 5 ? 'bg-green-100 text-green-800' : ($dados['taxa_conversao'] > 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ number_format($dados['taxa_conversao'], 1) }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-chart-line text-4xl mb-4"></i>
                                <div class="text-lg">Nenhum dado encontrado</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Performance por Corretor -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance por Corretor</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corretor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Leads</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leads Fechados</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxa de Fechamento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóveis Responsável</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($performanceCorretores as $corretor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $corretor->name }}</div>
                            <div class="text-sm text-gray-500">{{ $corretor->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $corretor->leads_total }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">{{ $corretor->leads_fechados }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $taxaFechamento = $corretor->leads_total > 0 ? 
                                    ($corretor->leads_fechados / $corretor->leads_total) * 100 : 0;
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $taxaFechamento > 20 ? 'bg-green-100 text-green-800' : ($taxaFechamento > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($taxaFechamento, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">{{ $corretor->imoveis_total ?? 0 }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-4"></i>
                            <div class="text-lg">Nenhum corretor encontrado</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection