@extends('layouts.admin')

@section('title', 'Funil de Vendas')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-funnel-dollar mr-2"></i>Funil de Vendas
        </h1>
        <a href="{{ route('admin.crm.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar ao Dashboard
        </a>
    </div>

    <!-- Estatísticas do Funil -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @foreach($funil as $status => $leads)
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-{{ $status === 'novo' ? 'blue' : ($status === 'contatado' ? 'purple' : ($status === 'qualificado' ? 'green' : ($status === 'proposta' ? 'yellow' : ($status === 'negociacao' ? 'red' : ($status === 'fechado' ? 'green' : 'gray'))))) }}-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-{{ $status === 'novo' ? 'blue' : ($status === 'contatado' ? 'purple' : ($status === 'qualificado' ? 'green' : ($status === 'proposta' ? 'yellow' : ($status === 'negociacao' ? 'red' : ($status === 'fechado' ? 'green' : 'gray'))))) }}-600 uppercase tracking-wide">
                        {{ ucfirst($status) }}
                    </p>
                    <p class="text-3xl font-bold text-gray-900">{{ $leads->count() }}</p>
                </div>
                <div class="text-{{ $status === 'novo' ? 'blue' : ($status === 'contatado' ? 'purple' : ($status === 'qualificado' ? 'green' : ($status === 'proposta' ? 'yellow' : ($status === 'negociacao' ? 'red' : ($status === 'fechado' ? 'green' : 'gray'))))) }}-500">
                    <i class="fas fa-{{ $status === 'novo' ? 'user-plus' : ($status === 'contatado' ? 'phone' : ($status === 'qualificado' ? 'user-check' : ($status === 'proposta' ? 'file-contract' : ($status === 'negociacao' ? 'handshake' : ($status === 'fechado' ? 'check-circle' : 'times-circle'))))) }} text-3xl"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Funil Visual -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 gap-4 mb-6">
        @foreach($funil as $status => $leads)
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-800">{{ ucfirst($status) }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $leads->count() }}</span>
                </div>
            </div>
            <div class="p-4 min-h-96 max-h-96 overflow-y-auto">
                @forelse($leads as $lead)
                <div class="mb-3 p-3 bg-gray-50 rounded-lg border-l-4 border-{{ $lead->status_color }}-500">
                    <div class="text-sm font-medium text-gray-900">{{ $lead->nome }}</div>
                    <div class="text-xs text-gray-500">{{ $lead->email }}</div>
                    @if($lead->telefone)
                        <div class="text-xs text-gray-500">{{ $lead->telefone }}</div>
                    @endif
                    @if($lead->imovel)
                        <div class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-home mr-1"></i>{{ $lead->imovel->codigo }}
                        </div>
                    @endif
                    @if($lead->corretor)
                        <div class="text-xs text-green-600 mt-1">
                            <i class="fas fa-user mr-1"></i>{{ $lead->corretor->name }}
                        </div>
                    @endif
                    @if($lead->proximo_followup)
                        <div class="text-xs {{ $lead->proximo_followup < now() ? 'text-red-600' : 'text-yellow-600' }} mt-1">
                            <i class="fas fa-clock mr-1"></i>{{ $lead->proximo_followup->format('d/m H:i') }}
                        </div>
                    @endif
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-users text-2xl mb-2"></i>
                    <div class="text-sm">Nenhum lead</div>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    <!-- Taxa de Conversão -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Taxa de Conversão</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalLeads = collect($funil)->sum->count();
                $leadsFechados = $funil['fechado']->count();
                $taxaConversao = $totalLeads > 0 ? ($leadsFechados / $totalLeads) * 100 : 0;
            @endphp
            
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ number_format($taxaConversao, 1) }}%</div>
                <div class="text-sm text-gray-500">Taxa de Conversão Geral</div>
            </div>
            
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">{{ $leadsFechados }}</div>
                <div class="text-sm text-gray-500">Leads Fechados</div>
            </div>
            
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">{{ $totalLeads }}</div>
                <div class="text-sm text-gray-500">Total de Leads</div>
            </div>
            
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ $funil['perdido']->count() }}</div>
                <div class="text-sm text-gray-500">Leads Perdidos</div>
            </div>
        </div>
    </div>
</div>
@endsection