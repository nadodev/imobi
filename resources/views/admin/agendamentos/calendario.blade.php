@extends('layouts.admin')

@section('page-title', 'Calendário de Visitas')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Calendário de Visitas</h1>
        <p class="text-gray-600">Visualize e gerencie todos os agendamentos de visitas</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.agendamentos.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-list mr-2"></i> Lista
        </a>
    </div>
</div>

<!-- Navegação do Calendário -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.agendamentos.calendario', ['ano' => $ano, 'mes' => $mes - 1]) }}" 
               class="p-2 rounded-lg hover:bg-gray-100 {{ $mes == 1 ? 'pointer-events-none opacity-50' : '' }}">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="text-xl font-semibold text-gray-800">
                {{ \Carbon\Carbon::create($ano, $mes, 1)->locale('pt_BR')->translatedFormat('F Y') }}
            </h2>
            <a href="{{ route('admin.agendamentos.calendario', ['ano' => $ano, 'mes' => $mes + 1]) }}" 
               class="p-2 rounded-lg hover:bg-gray-100 {{ $mes == 12 ? 'pointer-events-none opacity-50' : '' }}">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.agendamentos.calendario') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-calendar-day mr-2"></i> Hoje
            </a>
        </div>
    </div>
</div>

<!-- Calendário -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Cabeçalho dos dias da semana -->
    <div class="grid grid-cols-7 bg-gray-50 border-b">
        @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $dia)
            <div class="p-4 text-center font-semibold text-gray-700 border-r last:border-r-0">
                {{ $dia }}
            </div>
        @endforeach
    </div>

    <!-- Dias do mês -->
    <div class="grid grid-cols-7">
        @php
            $primeiroDia = \Carbon\Carbon::create($ano, $mes, 1);
            $ultimoDia = \Carbon\Carbon::create($ano, $mes, 1)->endOfMonth();
            $inicioSemana = $primeiroDia->startOfWeek();
            $fimSemana = $ultimoDia->endOfWeek();
            $dias = [];
            
            for ($data = $inicioSemana->copy(); $data <= $fimSemana; $data->addDay()) {
                $dias[] = $data->copy();
            }
        @endphp

        @foreach($dias as $dia)
            @php
                $isCurrentMonth = $dia->month == $mes;
                $isToday = $dia->isToday();
                $dataFormatada = $dia->format('Y-m-d');
                $agendamentosDoDia = $agendamentosPorData->get($dataFormatada, collect());
            @endphp
            
            <div class="min-h-[120px] border-r border-b last:border-r-0 p-2 {{ $isCurrentMonth ? 'bg-white' : 'bg-gray-50' }} {{ $isToday ? 'bg-blue-50' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-sm font-medium {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }} {{ $isToday ? 'text-blue-600 font-bold' : '' }}">
                        {{ $dia->day }}
                    </span>
                    @if($agendamentosDoDia->count() > 0)
                        <span class="bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $agendamentosDoDia->count() }}
                        </span>
                    @endif
                </div>
                
                <!-- Agendamentos do dia -->
                <div class="space-y-1">
                    @foreach($agendamentosDoDia->take(3) as $agendamento)
                        <div class="text-xs p-1 rounded cursor-pointer hover:bg-gray-100 transition-colors
                            {{ $agendamento->status == 'pendente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $agendamento->status == 'confirmado' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $agendamento->status == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $agendamento->status == 'realizado' ? 'bg-blue-100 text-blue-800' : '' }}"
                            onclick="showAgendamentoDetails({{ $agendamento->id }})"
                            title="{{ $agendamento->nome_cliente }} - {{ $agendamento->horario_visita }}">
                            <div class="font-medium truncate">{{ $agendamento->horario_visita }}</div>
                            <div class="truncate">{{ $agendamento->nome_cliente }}</div>
                        </div>
                    @endforeach
                    
                    @if($agendamentosDoDia->count() > 3)
                        <div class="text-xs text-gray-500 text-center">
                            +{{ $agendamentosDoDia->count() - 3 }} mais
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal de Detalhes do Agendamento -->
<div id="agendamentoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Detalhes da Visita</h3>
                    <button onclick="closeAgendamentoModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="agendamentoContent">
                    <!-- Conteúdo será carregado via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showAgendamentoDetails(agendamentoId) {
    // Buscar detalhes do agendamento
    fetch(`/admin/agendamentos/${agendamentoId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('agendamentoContent').innerHTML = html;
            document.getElementById('agendamentoModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erro ao carregar detalhes:', error);
        });
}

function closeAgendamentoModal() {
    document.getElementById('agendamentoModal').classList.add('hidden');
}

// Fechar modal ao clicar fora
document.getElementById('agendamentoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAgendamentoModal();
    }
});
</script>
@endpush
