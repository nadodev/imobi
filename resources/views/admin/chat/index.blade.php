@extends('layouts.admin')

@section('title', 'Chat - Conversas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100">
    <div class="container-fluid py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-comments text-blue-600 mr-3"></i>
                        Chat Online
                    </h1>
                    <p class="text-gray-600">Gerencie as conversas com os clientes em tempo real</p>
                </div>
                
                <!-- Stats Cards -->
                <div class="flex space-x-4">
                    <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-circle text-green-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">{{ $conversasAtivas }}</p>
                                <p class="text-sm text-gray-600">Ativas</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-lock text-gray-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-600">{{ $conversasEncerradas }}</p>
                                <p class="text-sm text-gray-600">Encerradas</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-bell text-red-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-red-600">{{ $mensagensNaoLidas }}</p>
                                <p class="text-sm text-gray-600">Não lidas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conversas List -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-list mr-2"></i>
                        Lista de Conversas
                    </h2>
                    <div class="text-blue-200 text-sm">
                        {{ $conversas->count() }} conversas encontradas
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if($conversas->count() > 0)
                    <div class="space-y-4">
                        @foreach($conversas as $conversa)
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all duration-300 bg-gradient-to-r from-white to-gray-50/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                                <i class="fas fa-user text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $conversa->nome_cliente }}</h3>
                                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                    <span>
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $conversa->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                    @if($conversa->ultima_mensagem_em)
                                                        <span>
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Última: {{ $conversa->ultima_mensagem_em->format('d/m/Y H:i') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            <div class="flex items-center space-x-3">
                                                @if($conversa->status === 'ativa')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                        Ativa
                                                    </span>
                                                @elseif($conversa->status === 'encerrada')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                                        Encerrada
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                                        Aguardando
                                                    </span>
                                                @endif
                                                
                                                @php
                                                    $naoLidas = $conversa->mensagensNaoLidas->count();
                                                @endphp
                                                @if($naoLidas > 0)
                                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white text-sm font-bold rounded-full shadow-lg">
                                                        {{ $naoLidas }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Contact Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            @if($conversa->email_cliente)
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-envelope text-blue-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Email</p>
                                                        <p class="text-sm text-gray-600">{{ $conversa->email_cliente }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($conversa->telefone_cliente)
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-phone text-green-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Telefone</p>
                                                        <p class="text-sm text-gray-600">{{ $conversa->telefone_cliente }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Last Message -->
                                        @if($conversa->ultimaMensagem)
                                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                                <p class="text-sm text-gray-700 mb-1">
                                                    <span class="font-medium">Última mensagem:</span>
                                                    {{ Str::limit($conversa->ultimaMensagem->mensagem, 100) }}
                                                </p>
                                            </div>
                                        @endif
                                        
                                        <!-- Actions -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('admin.chat.show', $conversa) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                                                    <i class="fas fa-comments mr-2"></i>
                                                    Abrir Conversa
                                                </a>
                                                
                                                @if($conversa->status === 'ativa')
                                                    <button onclick="encerrarConversa({{ $conversa->id }})" 
                                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Encerrar
                                                    </button>
                                                @else
                                                    <button onclick="reativarConversa({{ $conversa->id }})" 
                                                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                                                        <i class="fas fa-play mr-2"></i>
                                                        Reativar
                                                    </button>
                                                @endif
                                            </div>
                                            
                                            <!-- Quick Actions -->
                                            <div class="flex items-center space-x-2">
                                                @if($conversa->telefone_cliente)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $conversa->telefone_cliente) }}" 
                                                       target="_blank"
                                                       class="w-10 h-10 bg-green-600 text-white rounded-lg flex items-center justify-center hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl"
                                                       title="WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($conversa->email_cliente)
                                                    <a href="mailto:{{ $conversa->email_cliente }}" 
                                                       class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl"
                                                       title="Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $conversas->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-comments text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhuma conversa encontrada</h3>
                        <p class="text-gray-600 mb-8">Ainda não há conversas iniciadas pelos clientes.</p>
                        <div class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-refresh mr-2"></i>
                            Atualizar
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<script>
function encerrarConversa(conversaId) {
    if (confirm('Tem certeza que deseja encerrar esta conversa?')) {
        fetch(`/admin/chat/${conversaId}/encerrar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao encerrar conversa');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao encerrar conversa');
        });
    }
}

function reativarConversa(conversaId) {
    if (confirm('Tem certeza que deseja reativar esta conversa?')) {
        fetch(`/admin/chat/${conversaId}/reativar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao reativar conversa');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao reativar conversa');
        });
    }
}
</script>
@endsection
