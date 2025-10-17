@extends('layouts.site')

@section('title', 'Minhas Conversas - ImobiJoaçaba')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100 py-12">
    <div class="container-custom">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.cliente.dashboard') }}" 
                   class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Minhas Conversas</h1>
                    <p class="text-gray-600">{{ $conversas->count() }} conversas encontradas</p>
                </div>
            </div>
        </div>

        <!-- Conversations List -->
        <div class="max-w-4xl mx-auto">
            @if($conversas->count() > 0)
                <div class="space-y-4">
                    @foreach($conversas as $conversa)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-3">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $conversa->nome_cliente }}</h3>
                                                <p class="text-sm text-gray-600">
                                                    @if($conversa->email_cliente)
                                                        {{ $conversa->email_cliente }}
                                                    @else
                                                        Email não informado
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($conversa->ultimaMensagem)
                                            <div class="mb-3">
                                                <p class="text-gray-700">{{ Str::limit($conversa->ultimaMensagem->mensagem, 150) }}</p>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    Iniciada em {{ $conversa->created_at->format('d/m/Y H:i') }}
                                                </span>
                                                @if($conversa->ultimaMensagem)
                                                    <span>
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Última mensagem: {{ $conversa->ultimaMensagem->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center space-x-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                    @if($conversa->status === 'ativa') bg-green-100 text-green-800
                                                    @elseif($conversa->status === 'encerrada') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($conversa->status) }}
                                                </span>
                                                
                                                <a href="{{ route('admin.cliente.conversas.show', $conversa) }}" 
                                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Ver Conversa
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhuma conversa encontrada</h3>
                    <p class="text-gray-600 mb-8">Você ainda não iniciou nenhuma conversa conosco.</p>
                    <div class="space-y-4">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-comments mr-2"></i>
                            Iniciar Nova Conversa
                        </a>
                        <div>
                            <a href="{{ route('admin.cliente.dashboard') }}" 
                               class="text-gray-600 hover:text-blue-600 transition-colors">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Voltar ao Painel
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
