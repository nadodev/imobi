@extends('layouts.admin')

@section('title', 'Gestão de Imóveis')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-key mr-2"></i>Gestão de Imóveis
        </h1>
        <a href="{{ route('admin.gestao-imoveis.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-chart-pie mr-2"></i> Dashboard Gestão
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        <form method="GET" action="{{ route('admin.gestao-imoveis.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="status_gestao" class="block text-sm font-medium text-gray-700 mb-1">Status de Gestão</label>
                    <select name="status_gestao" id="status_gestao" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="livre" {{ request('status_gestao') == 'livre' ? 'selected' : '' }}>Livre</option>
                        <option value="reservado" {{ request('status_gestao') == 'reservado' ? 'selected' : '' }}>Reservado</option>
                        <option value="vendido" {{ request('status_gestao') == 'vendido' ? 'selected' : '' }}>Vendido</option>
                        <option value="alugado" {{ request('status_gestao') == 'alugado' ? 'selected' : '' }}>Alugado</option>
                        <option value="indisponivel" {{ request('status_gestao') == 'indisponivel' ? 'selected' : '' }}>Indisponível</option>
                    </select>
                </div>
                <div>
                    <label for="corretor_responsavel" class="block text-sm font-medium text-gray-700 mb-1">Corretor Responsável</label>
                    <select name="corretor_responsavel" id="corretor_responsavel" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($corretores as $corretor)
                            <option value="{{ $corretor->id }}" {{ request('corretor_responsavel') == $corretor->id ? 'selected' : '' }}>
                                {{ $corretor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ request('search') }}" placeholder="Título, código ou endereço">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center w-full">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Imóveis -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Imóveis ({{ $imoveis->total() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Gestão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chaves</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corretor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contrato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($imoveis as $imovel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $imovel->titulo }}</div>
                            <div class="text-sm text-gray-500">{{ $imovel->codigo }}</div>
                            <div class="text-sm text-gray-500">{{ $imovel->endereco }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $imovel->status_gestao_color ?? 'gray' }}-100 text-{{ $imovel->status_gestao_color ?? 'gray' }}-800">
                                {{ $imovel->status_gestao_label ?? 'Não definido' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($imovel->numero_chaves)
                                <div class="text-sm">{{ $imovel->numero_chaves }} chaves</div>
                                @if($imovel->localizacao_chaves)
                                    <div class="text-xs text-gray-500">{{ $imovel->localizacao_chaves }}</div>
                                @endif
                            @else
                                <span class="text-gray-400">Não informado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $imovel->corretorResponsavel->name ?? 'Não atribuído' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($imovel->data_vencimento_aluguel)
                                <div class="{{ $imovel->isContratoVencendo() ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $imovel->data_vencimento_aluguel->format('d/m/Y') }}
                                </div>
                                @if($imovel->isContratoVencendo())
                                    <div class="text-xs text-red-500">Vencendo!</div>
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="text-sm font-medium text-blue-600">{{ $imovel->total_visualizacoes ?? 0 }}</div>
                            <div class="text-xs text-gray-500">total</div>
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
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-home text-4xl mb-4"></i>
                            <div class="text-lg">Nenhum imóvel encontrado</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($imoveis->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $imoveis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
