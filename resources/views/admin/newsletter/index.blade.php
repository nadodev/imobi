@extends('layouts.admin')

@section('title', 'Newsletter')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Newsletter</h1>
            <p class="text-gray-600 mt-2">Gerencie inscrições e envie newsletters</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.newsletter.enviar') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                <i class="fas fa-paper-plane mr-2"></i>
                Enviar Newsletter
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Inscritos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalInscritos }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Emails Ativos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $newsletters->where('ativo', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-paper-plane text-2xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Newsletters Enviadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $envios->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Email Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Adicionar Email</h2>
        
        <form action="{{ route('admin.newsletter.store') }}" method="POST" class="flex space-x-4">
            @csrf
            <div class="flex-1">
                <input type="email" 
                       name="email" 
                       placeholder="Digite o email"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>
            <div class="flex-1">
                <input type="text" 
                       name="nome" 
                       placeholder="Nome (opcional)"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i>
                Adicionar
            </button>
        </form>
    </div>

    <!-- Emails List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Lista de Emails</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nome
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Inscrito em
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($newsletters as $newsletter)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $newsletter->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $newsletter->nome ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($newsletter->ativo)
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                        Ativo
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $newsletter->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <form action="{{ route('admin.newsletter.toggle-status', $newsletter) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="{{ $newsletter->ativo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} transition-colors">
                                        {{ $newsletter->ativo ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.newsletter.destroy', $newsletter) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Tem certeza que deseja remover este email?')"
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-envelope text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-medium">Nenhum email cadastrado</p>
                                <p class="text-sm">Adicione emails para começar a enviar newsletters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($newsletters->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $newsletters->links() }}
            </div>
        @endif
    </div>

    <!-- Recent Sends -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Newsletters Enviadas</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Assunto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Enviados
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($envios as $envio)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $envio->assunto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold {{ $envio->tipo === 'todos' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }} rounded-full">
                                    {{ $envio->tipo === 'todos' ? 'Todos' : 'Individual' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($envio->status)
                                    @case('concluido')
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                            Concluído
                                        </span>
                                        @break
                                    @case('enviando')
                                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                                            Enviando
                                        </span>
                                        @break
                                    @case('erro')
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                            Erro
                                        </span>
                                        @break
                                    @default
                                        <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                            Pendente
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $envio->total_enviados }} / {{ $envio->total_entregues }}
                                @if($envio->total_falhas > 0)
                                    <span class="text-red-600">({{ $envio->total_falhas }} falhas)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $envio->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.newsletter.show-envio', $envio) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors">
                                    Ver detalhes
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-paper-plane text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-medium">Nenhuma newsletter enviada</p>
                                <p class="text-sm">Envie sua primeira newsletter para começar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($envios->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $envios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
