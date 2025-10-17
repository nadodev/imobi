@extends('layouts.site')

@section('title', 'Conversa - ImobiJoaçaba')

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
                    <h1 class="text-3xl font-bold text-gray-900">Conversa</h1>
                    <p class="text-gray-600">Com {{ $conversa->nome_cliente }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($conversa->status === 'ativa') bg-green-100 text-green-800
                    @elseif($conversa->status === 'encerrada') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($conversa->status) }}
                </span>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                <!-- Chat Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">{{ $conversa->nome_cliente }}</h2>
                                <p class="text-blue-200 text-sm">
                                    @if($conversa->email_cliente)
                                        {{ $conversa->email_cliente }}
                                    @else
                                        Email não informado
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-blue-200 text-sm">
                            <i class="fas fa-calendar mr-2"></i>
                            Iniciada em {{ $conversa->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="h-96 overflow-y-auto p-6 bg-gray-50">
                    @if($conversa->mensagens->count() > 0)
                        <div class="space-y-4">
                            @foreach($conversa->mensagens as $mensagem)
                                <div class="flex {{ $mensagem->tipo === 'cliente' ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs lg:max-w-md">
                                        <div class="flex items-end space-x-2 {{ $mensagem->tipo === 'cliente' ? 'flex-row-reverse space-x-reverse' : '' }}">
                                            <!-- Avatar -->
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                                {{ $mensagem->tipo === 'cliente' ? 'bg-blue-600' : 'bg-gray-400' }}">
                                                <i class="fas fa-user text-white text-xs"></i>
                                            </div>
                                            
                                            <!-- Message Bubble -->
                                            <div class="px-4 py-3 rounded-2xl
                                                {{ $mensagem->tipo === 'cliente' 
                                                    ? 'bg-blue-600 text-white rounded-br-md' 
                                                    : 'bg-white text-gray-800 rounded-bl-md border border-gray-200' }}">
                                                <p class="text-sm">{{ $mensagem->mensagem }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Timestamp -->
                                        <div class="flex {{ $mensagem->tipo === 'cliente' ? 'justify-end' : 'justify-start' }} mt-1">
                                            <span class="text-xs text-gray-500">
                                                {{ $mensagem->created_at->format('H:i') }}
                                            </span>
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

                <!-- Chat Status -->
                @if($conversa->status === 'ativa')
                    <div class="px-6 py-3 bg-green-50 border-t border-green-200">
                        <div class="flex items-center justify-center space-x-2 text-green-700">
                            <i class="fas fa-circle text-green-500 text-xs"></i>
                            <span class="text-sm font-medium">Conversa ativa - Aguardando resposta</span>
                        </div>
                    </div>
                @elseif($conversa->status === 'encerrada')
                    <div class="px-6 py-3 bg-red-50 border-t border-red-200">
                        <div class="flex items-center justify-center space-x-2 text-red-700">
                            <i class="fas fa-lock text-red-500"></i>
                            <span class="text-sm font-medium">Conversa encerrada</span>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-3 bg-yellow-50 border-t border-yellow-200">
                        <div class="flex items-center justify-center space-x-2 text-yellow-700">
                            <i class="fas fa-clock text-yellow-500"></i>
                            <span class="text-sm font-medium">Aguardando</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Back to Dashboard -->
            <div class="text-center mt-8">
                <a href="{{ route('admin.cliente.dashboard') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar ao Painel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
