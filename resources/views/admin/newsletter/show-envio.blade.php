@extends('layouts.admin')

@section('title', 'Detalhes do Envio - ' . $envio->assunto)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-paper-plane text-blue-600 mr-3"></i>
                Detalhes do Envio
            </h1>
            <p class="text-gray-600 mt-2">Visualize os detalhes e estatísticas do envio da newsletter</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.newsletter.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Status Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $envio->assunto }}</h2>
                <p class="text-gray-600 mt-1">
                    Enviado por <span class="font-semibold">{{ $envio->user->name }}</span> em 
                    {{ $envio->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if($envio->status === 'concluido')
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        Concluído
                    </span>
                @elseif($envio->status === 'enviando')
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                        Enviando
                    </span>
                @elseif($envio->status === 'pendente')
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                        Pendente
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                        Erro
                    </span>
                @endif
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-blue-50 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-paper-plane text-xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-blue-900">Total Enviados</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $envio->total_enviados }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-green-900">Entregues</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $envio->total_entregues }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-xl text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-red-900">Falhas</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $envio->total_falhas }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-percentage text-xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-purple-900">Taxa de Sucesso</h3>
                        <p class="text-2xl font-bold text-purple-600">
                            @if($envio->total_enviados > 0)
                                {{ number_format(($envio->total_entregues / $envio->total_enviados) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipo de Envio -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tipo de Envio</h3>
            <div class="flex items-center space-x-3">
                @if($envio->tipo === 'todos')
                    <div class="flex items-center px-4 py-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-users text-blue-600 mr-2"></i>
                        <span class="text-blue-800 font-medium">Enviado para todos os inscritos</span>
                    </div>
                @else
                    <div class="flex items-center px-4 py-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-user text-purple-600 mr-2"></i>
                        <span class="text-purple-800 font-medium">Enviado para: {{ $envio->email_destino }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Criado em</h3>
                <p class="text-gray-600">
                    <i class="fas fa-calendar mr-2"></i>
                    {{ $envio->created_at->format('d/m/Y H:i:s') }}
                </p>
            </div>
            @if($envio->enviado_em)
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Enviado em</h3>
                    <p class="text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        {{ $envio->enviado_em->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Conteúdo da Newsletter -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-envelope text-blue-600 mr-2"></i>
            Conteúdo da Newsletter
        </h2>
        
        <div class="border border-gray-200 rounded-xl p-6 bg-gray-50">
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Assunto:</h3>
                    <p class="text-gray-800 font-medium">{{ $envio->assunto }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Conteúdo:</h3>
                    <div class="prose max-w-none">
                        <div class="text-gray-800 whitespace-pre-line leading-relaxed">
                            {{ $envio->conteudo }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.newsletter.index') }}" 
           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Voltar para Lista
        </a>
        <a href="{{ route('admin.newsletter.enviar') }}" 
           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-paper-plane mr-2"></i>
            Nova Newsletter
        </a>
    </div>
</div>

<style>
.prose {
    color: inherit;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #1f2937;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}

.prose p {
    margin-bottom: 1rem;
}

.prose ul, .prose ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.prose li {
    margin-bottom: 0.25rem;
}

.prose strong {
    font-weight: 600;
    color: #1f2937;
}

.prose em {
    font-style: italic;
}
</style>
@endsection
