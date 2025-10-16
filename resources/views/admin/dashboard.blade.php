@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total de Imóveis</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_imoveis'] }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <i class="fas fa-building text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Imóveis Ativos</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['imoveis_ativos'] }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Vendidos</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['imoveis_vendidos'] }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <i class="fas fa-dollar-sign text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Alugados</p>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['imoveis_alugados'] }}</p>
            </div>
            <div class="bg-orange-100 p-4 rounded-full">
                <i class="fas fa-key text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Agendamentos Pendentes</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['agendamentos_pendentes'] }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-full">
                <i class="fas fa-calendar text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Mensagens Não Lidas</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['mensagens_nao_lidas'] }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-full">
                <i class="fas fa-envelope text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Últimos Agendamentos -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Últimos Agendamentos</h2>
        </div>
        <div class="p-6">
            @if($ultimosAgendamentos->count() > 0)
                <div class="space-y-4">
                    @foreach($ultimosAgendamentos as $agendamento)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold">{{ $agendamento->nome_cliente }}</p>
                                <p class="text-sm text-gray-600">{{ $agendamento->imovel->codigo }} - {{ $agendamento->data_formatada }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs rounded-full bg-{{ $agendamento->status_badge }}-100 text-{{ $agendamento->status_badge }}-800">
                                {{ ucfirst($agendamento->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.agendamentos.index') }}" class="block mt-4 text-blue-600 hover:underline text-center">
                    Ver todos
                </a>
            @else
                <p class="text-gray-500 text-center py-8">Nenhum agendamento recente</p>
            @endif
        </div>
    </div>

    <!-- Últimas Mensagens -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Últimas Mensagens</h2>
        </div>
        <div class="p-6">
            @if($ultimasMensagens->count() > 0)
                <div class="space-y-4">
                    @foreach($ultimasMensagens as $mensagem)
                        <div class="border-b pb-3">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-semibold">{{ $mensagem->nome }}</p>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $mensagem->status === 'nao_lida' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ str_replace('_', ' ', ucfirst($mensagem->status)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $mensagem->mensagem }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.mensagens.index') }}" class="block mt-4 text-blue-600 hover:underline text-center">
                    Ver todas
                </a>
            @else
                <p class="text-gray-500 text-center py-8">Nenhuma mensagem recente</p>
            @endif
        </div>
    </div>
</div>

<!-- Imóveis Recentes -->
<div class="bg-white rounded-lg shadow mt-6">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Imóveis Recentes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preço</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($imoveisRecentes as $imovel)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->codigo }}</td>
                        <td class="px-6 py-4">{{ $imovel->titulo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->tipo->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $imovel->preco_formatado }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $imovel->status === 'ativo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($imovel->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

