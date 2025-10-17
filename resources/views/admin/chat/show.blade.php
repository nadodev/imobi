@extends('layouts.admin')

@section('title', 'Chat - Conversa com ' . $conversa->nome_cliente)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100">
    <div class="container-fluid py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.chat.index') }}" 
                       class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 text-gray-600 hover:text-blue-600">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-comments text-blue-600 mr-3"></i>
                            Conversa com {{ $conversa->nome_cliente }}
                        </h1>
                        <div class="flex items-center space-x-4">
                            @if($conversa->status === 'ativa')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                    Conversa ativa
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                    Conversa encerrada
                                </span>
                            @endif
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-calendar mr-1"></i>
                                Iniciada em {{ $conversa->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    @if($conversa->status === 'ativa')
                        <button onclick="encerrarConversa({{ $conversa->id }})" 
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-times mr-2"></i>
                            Encerrar Conversa
                        </button>
                    @else
                        <button onclick="reativarConversa({{ $conversa->id }})" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-play mr-2"></i>
                            Reativar Conversa
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Chat Messages -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden h-[600px] flex flex-col">
                    <!-- Chat Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">{{ $conversa->nome_cliente }}</h3>
                                    <p class="text-blue-200 text-sm">
                                        @if($conversa->status === 'ativa')
                                            <i class="fas fa-circle text-green-400 mr-1"></i>
                                            Online agora
                                        @else
                                            <i class="fas fa-circle text-gray-400 mr-1"></i>
                                            Offline
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="text-blue-200 text-sm">
                                <i class="fas fa-comments mr-2"></i>
                                {{ $conversa->mensagens->count() }} mensagens
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div id="messages-container" class="flex-1 overflow-y-auto p-6 bg-gray-50">
                        @if($conversa->mensagens->count() > 0)
                            <div class="space-y-4">
                                @foreach($conversa->mensagens as $mensagem)
                                    <div class="flex {{ $mensagem->tipo === 'admin' ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-xs lg:max-w-md">
                                            <div class="flex items-end space-x-2 {{ $mensagem->tipo === 'admin' ? 'flex-row-reverse space-x-reverse' : '' }}">
                                                <!-- Avatar -->
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg
                                                    {{ $mensagem->tipo === 'admin' ? 'bg-blue-600' : 'bg-gray-500' }}">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </div>
                                                
                                                <!-- Message Bubble -->
                                                <div class="px-4 py-3 rounded-2xl shadow-lg
                                                    {{ $mensagem->tipo === 'admin' 
                                                        ? 'bg-blue-600 text-white rounded-br-md' 
                                                        : 'bg-white text-gray-800 rounded-bl-md border border-gray-200' }}">
                                                    <p class="text-sm mb-1">{{ $mensagem->mensagem }}</p>
                                                    <p class="text-xs opacity-70">
                                                        {{ $mensagem->created_at->format('H:i') }}
                                                        @if($mensagem->tipo === 'admin' && $mensagem->user)
                                                            - {{ $mensagem->user->name }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-comments text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma mensagem ainda</h3>
                                <p class="text-gray-600">Esta conversa ainda não possui mensagens.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Message Input -->
                    @if($conversa->status === 'ativa')
                        <div class="bg-white border-t border-gray-200 p-4">
                            <form id="message-form" class="flex space-x-3">
                                <input type="text" 
                                       id="message-input" 
                                       placeholder="Digite sua mensagem..." 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            <div class="mt-3 text-center">
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ao encerrar a conversa, o cliente receberá um botão para confirmar o encerramento.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border-t border-gray-200 p-4 text-center">
                            <p class="text-gray-600 text-sm mb-2">
                                <i class="fas fa-lock mr-2"></i>
                                Esta conversa está encerrada. Reative para enviar mensagens.
                            </p>
                            <p class="text-xs text-gray-500">
                                O cliente recebeu o botão para confirmar o encerramento da conversa.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Client Info -->
            <div class="space-y-6">
                <!-- Client Profile Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-user mr-2"></i>
                            Informações do Cliente
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Client Avatar -->
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $conversa->nome_cliente }}</h4>
                            <p class="text-sm text-gray-600">Cliente</p>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-4">
                            @if($conversa->email_cliente)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Email</p>
                                        <p class="text-sm text-gray-600">{{ $conversa->email_cliente }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($conversa->telefone_cliente)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-phone text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Telefone</p>
                                        <p class="text-sm text-gray-600">{{ $conversa->telefone_cliente }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Iniciada em</p>
                                    <p class="text-sm text-gray-600">{{ $conversa->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            @if($conversa->ultima_mensagem_em)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Última mensagem</p>
                                        <p class="text-sm text-gray-600">{{ $conversa->ultima_mensagem_em->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            <i class="fas fa-bolt mr-2"></i>
                            Ações Rápidas
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($conversa->telefone_cliente)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $conversa->telefone_cliente) }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                                <i class="fab fa-whatsapp mr-2"></i>
                                WhatsApp
                            </a>
                        @endif
                        
                        @if($conversa->email_cliente)
                            <a href="mailto:{{ $conversa->email_cliente }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                                <i class="fas fa-envelope mr-2"></i>
                                Enviar Email
                            </a>
                        @endif
                        
                        <button onclick="window.print()" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Conversa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
console.log('Chat admin script carregado');
const conversaId = {{ $conversa->id }};
let adminUltimaMensagemId = {{ $conversa->mensagens->last()->id ?? 0 }};
let messageInterval = null;

console.log('Conversa ID:', conversaId);
console.log('Última mensagem ID:', adminUltimaMensagemId);

// Send message
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('message-input');
    const mensagem = messageInput.value.trim();

    if (!mensagem) return;

    console.log('Enviando mensagem:', { conversa_id: conversaId, mensagem: mensagem });
    
    fetch('{{ route("admin.chat.enviar") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            conversa_id: conversaId,
            mensagem: mensagem
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            messageInput.value = '';
            adicionarMensagem(data.mensagem.mensagem, 'admin', data.timestamp);
            adminUltimaMensagemId = data.mensagem.id;
        } else {
            console.error('Erro na resposta:', data);
            alert('Erro ao enviar mensagem: ' + (data.message || 'Erro desconhecido'));
        }
    })
    .catch(error => {
        console.error('Erro ao enviar mensagem:', error);
        alert('Erro ao enviar mensagem. Verifique o console para mais detalhes.');
    });
});

function adicionarMensagem(mensagem, tipo, timestamp) {
    const messagesContainer = document.getElementById('messages-container');
    const messageDiv = document.createElement('div');
    
    messageDiv.className = `flex ${tipo === 'admin' ? 'justify-end' : 'justify-start'}`;
    messageDiv.innerHTML = `
        <div class="max-w-xs lg:max-w-md">
            <div class="flex items-end space-x-2 ${tipo === 'admin' ? 'flex-row-reverse space-x-reverse' : ''}">
                <div class="w-8 h-8 rounded-full flex items-center justify-center ${tipo === 'admin' ? 'bg-blue-600' : 'bg-gray-400'}">
                    <i class="fas fa-user text-white text-xs"></i>
                </div>
                <div class="px-4 py-2 rounded-lg ${tipo === 'admin' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'}">
                    <p class="text-sm mb-1">${mensagem}</p>
                    <p class="text-xs opacity-70">${timestamp}</p>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function encerrarConversa(conversaId) {
    console.log('Tentando encerrar conversa:', conversaId);
    
    if (confirm('Tem certeza que deseja encerrar esta conversa?')) {
        console.log('Confirmado, enviando requisição...');
        
        fetch(`/admin/chat/${conversaId}/encerrar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status (encerrar):', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data (encerrar):', data);
            if (data.success) {
                alert('Conversa encerrada com sucesso!');
                location.reload();
            } else {
                alert('Erro ao encerrar conversa: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro ao encerrar conversa:', error);
            alert('Erro ao encerrar conversa. Verifique o console para mais detalhes.');
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

// Sistema de polling para verificar novas mensagens automaticamente
let chatInterval;

function iniciarVerificacaoMensagens() {
    if (chatInterval) clearInterval(chatInterval);
    
    chatInterval = setInterval(() => {
        verificarNovasMensagens();
    }, 2000); // Verificar a cada 2 segundos
}

function pararVerificacaoMensagens() {
    if (chatInterval) {
        clearInterval(chatInterval);
        chatInterval = null;
    }
}

function verificarNovasMensagens() {
    const url = `/admin/chat/{{ $conversa->id }}/novas-mensagens?ultima_mensagem_id=${adminUltimaMensagemId}`;
    
    fetch(url)
    .then(response => response.json())
    .then(data => {
        if (data.success && data.novas_mensagens) {
            // Verificar se há mensagens novas
            const mensagensNovas = data.novas_mensagens.filter(msg => msg.id > adminUltimaMensagemId);
            
            if (mensagensNovas.length > 0) {
                mensagensNovas.forEach(mensagem => {
                    adicionarMensagem(mensagem.mensagem, mensagem.tipo, mensagem.timestamp);
                    adminUltimaMensagemId = Math.max(adminUltimaMensagemId, mensagem.id);
                });
            }
        }
    })
    .catch(error => {
        console.error('Erro ao verificar novas mensagens:', error);
    });
}

// Iniciar verificação quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    iniciarVerificacaoMensagens();
});

// Parar verificação quando a página for fechada
window.addEventListener('beforeunload', function() {
    pararVerificacaoMensagens();
});

// Auto-scroll to bottom on load
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
</script>
@endsection
