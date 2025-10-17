@extends('layouts.site')

@section('title', 'Minha Conta - ImobiJoaçaba')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100 py-12">
    <div class="container-custom">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full mb-6 shadow-lg">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Minha Conta</h1>
            <p class="text-xl text-gray-600">Gerencie suas conversas e favoritos</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Total Conversations -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Conversas</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $conversas->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Conversations -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Ativas</p>
                        <p class="text-3xl font-bold text-green-600">{{ $conversas->where('status', 'ativa')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Favorites -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Favoritos</p>
                        <p class="text-3xl font-bold text-red-600">{{ auth()->user()->imoveisFavoritos()->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-heart text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Conversations Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-white">Minhas Conversas</h2>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-comments text-blue-200"></i>
                                <span class="text-blue-200 text-sm">{{ $conversas->count() }} conversas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        @if($conversas->count() > 0)
                            <div class="space-y-4">
                                @foreach($conversas as $conversa)
                                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-user text-white text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $conversa->nome_cliente }}</h3>
                                                        <p class="text-sm text-gray-600">{{ $conversa->email_cliente ?? 'Email não informado' }}</p>
                                                    </div>
                                                </div>
                                                
                                                @if($conversa->ultimaMensagem)
                                                    <p class="text-sm text-gray-700 mb-2">{{ Str::limit($conversa->ultimaMensagem->mensagem, 100) }}</p>
                                                @endif
                                                
                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <span>
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $conversa->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                        @if($conversa->status === 'ativa') bg-green-100 text-green-800
                                                        @elseif($conversa->status === 'encerrada') bg-red-100 text-red-800
                                                        @else bg-yellow-100 text-yellow-800
                                                        @endif">
                                                        {{ ucfirst($conversa->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.cliente.conversas.show', $conversa) }}" 
                                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Ver
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-comments text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma conversa encontrada</h3>
                                <p class="text-gray-600 mb-6">Você ainda não iniciou nenhuma conversa conosco.</p>
                                <a href="{{ route('home') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-comments mr-2"></i>
                                    Iniciar Conversa
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Ações Rápidas</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('home') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-comments text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Nova Conversa</p>
                                <p class="text-sm text-gray-600">Iniciar chat</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('imoveis.index') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Ver Imóveis</p>
                                <p class="text-sm text-gray-600">Explorar propriedades</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('contato') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Contato</p>
                                <p class="text-sm text-gray-600">Entre em contato</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Favorites -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Favoritos</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-heart text-red-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ auth()->user()->imoveisFavoritos()->count() }} Imóveis</h4>
                            <p class="text-sm text-gray-600">Salvos nos favoritos</p>
                        </div>
                        
                        <a href="{{ route('favoritos.index') }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-heart mr-2"></i>
                            Ver Favoritos
                        </a>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Perfil</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ auth()->user()->name }}</h4>
                                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Membro desde:</span>
                                <span class="font-medium">{{ auth()->user()->created_at->format('M/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Conversas:</span>
                                <span class="font-medium">{{ $conversas->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
