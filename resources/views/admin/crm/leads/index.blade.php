@extends('layouts.admin')

@section('title', 'Gestão de Leads')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-users mr-2"></i>Gestão de Leads
        </h1>
        <a href="{{ route('admin.crm.leads.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Novo Lead
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        <form method="GET" action="{{ route('admin.crm.leads') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="novo" {{ request('status') == 'novo' ? 'selected' : '' }}>Novo</option>
                        <option value="contatado" {{ request('status') == 'contatado' ? 'selected' : '' }}>Contatado</option>
                        <option value="qualificado" {{ request('status') == 'qualificado' ? 'selected' : '' }}>Qualificado</option>
                        <option value="proposta" {{ request('status') == 'proposta' ? 'selected' : '' }}>Proposta</option>
                        <option value="negociacao" {{ request('status') == 'negociacao' ? 'selected' : '' }}>Negociação</option>
                        <option value="fechado" {{ request('status') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                        <option value="perdido" {{ request('status') == 'perdido' ? 'selected' : '' }}>Perdido</option>
                    </select>
                </div>
                <div>
                    <label for="origem" class="block text-sm font-medium text-gray-700 mb-1">Origem</label>
                    <select name="origem" id="origem" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas</option>
                        <option value="site" {{ request('origem') == 'site' ? 'selected' : '' }}>Site</option>
                        <option value="whatsapp" {{ request('origem') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="instagram" {{ request('origem') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="facebook" {{ request('origem') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="indicacao" {{ request('origem') == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                        <option value="outro" {{ request('origem') == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div>
                    <label for="corretor_id" class="block text-sm font-medium text-gray-700 mb-1">Corretor</label>
                    <select name="corretor_id" id="corretor_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($corretores as $corretor)
                            <option value="{{ $corretor->id }}" {{ request('corretor_id') == $corretor->id ? 'selected' : '' }}>
                                {{ $corretor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ request('search') }}" placeholder="Nome, email ou telefone">
                </div>
            </div>
            <div class="flex space-x-2 mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                <a href="{{ route('admin.crm.leads') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Leads -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Leads ({{ $leads->total() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interesse</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corretor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Último Contato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Próximo Follow-up</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $lead->nome }}</div>
                            @if($lead->imovel)
                                <div class="text-sm text-gray-500">{{ $lead->imovel->titulo }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $lead->email }}</div>
                            <div class="text-sm text-gray-500">{{ $lead->telefone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <i class="fas fa-{{ $lead->origem_icon }} mr-1"></i>
                            {{ ucfirst($lead->origem) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $lead->status_color }}-100 text-{{ $lead->status_color }}-800">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($lead->tipo_interesse)
                                <div class="text-sm text-gray-900">{{ ucfirst($lead->tipo_interesse) }}</div>
                            @endif
                            @if($lead->valor_interesse)
                                <div class="text-sm text-gray-500">R$ {{ number_format($lead->valor_interesse, 2, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lead->corretor->name ?? 'Não atribuído' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($lead->ultimo_contato)
                                {{ $lead->ultimo_contato->format('d/m/Y H:i') }}
                            @else
                                <span class="text-gray-400">Nunca</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($lead->proximo_followup)
                                <div class="{{ $lead->proximo_followup < now() ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $lead->proximo_followup->format('d/m/Y H:i') }}
                                </div>
                            @else
                                <span class="text-gray-400">Não agendado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.crm.leads.edit', $lead) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.crm.leads.destroy', $lead) }}" 
                                      style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este lead?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-4"></i>
                            <div class="text-lg">Nenhum lead encontrado</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($leads->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection