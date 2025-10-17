@extends('layouts.admin')

@section('title', 'Criar Tarefa')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-plus mr-2"></i>Criar Tarefa
        </h1>
        <a href="{{ route('admin.crm.tarefas') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Dados da Tarefa</h3>
        <form method="POST" action="{{ route('admin.crm.tarefas.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Dados Básicos -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Dados Básicos</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                            <input type="text" name="titulo" id="titulo" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror" 
                                   value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                            <textarea name="descricao" id="descricao" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @enderror" 
                                      rows="3">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                            <select name="tipo" id="tipo" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                <option value="ligacao" {{ old('tipo') == 'ligacao' ? 'selected' : '' }}>Ligação</option>
                                <option value="email" {{ old('tipo') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="whatsapp" {{ old('tipo') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="visita" {{ old('tipo') == 'visita' ? 'selected' : '' }}>Visita</option>
                                <option value="proposta" {{ old('tipo') == 'proposta' ? 'selected' : '' }}>Proposta</option>
                                <option value="followup" {{ old('tipo') == 'followup' ? 'selected' : '' }}>Follow-up</option>
                                <option value="outro" {{ old('tipo') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('tipo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prioridade" class="block text-sm font-medium text-gray-700 mb-1">Prioridade *</label>
                            <select name="prioridade" id="prioridade" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prioridade') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                                <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="urgente" {{ old('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            @error('prioridade')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dados de Execução -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Dados de Execução</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Responsável *</label>
                            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="data_vencimento" class="block text-sm font-medium text-gray-700 mb-1">Data de Vencimento *</label>
                            <input type="datetime-local" name="data_vencimento" id="data_vencimento" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_vencimento') border-red-500 @enderror" 
                                   value="{{ old('data_vencimento') }}" required>
                            @error('data_vencimento')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lead_id" class="block text-sm font-medium text-gray-700 mb-1">Lead Relacionado</label>
                            <select name="lead_id" id="lead_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('lead_id') border-red-500 @enderror">
                                <option value="">Selecione</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->nome }} - {{ $lead->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="imovel_id" class="block text-sm font-medium text-gray-700 mb-1">Imóvel Relacionado</label>
                            <select name="imovel_id" id="imovel_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('imovel_id') border-red-500 @enderror">
                                <option value="">Selecione</option>
                                @foreach($imoveis as $imovel)
                                    <option value="{{ $imovel->id }}" {{ old('imovel_id') == $imovel->id ? 'selected' : '' }}>
                                        {{ $imovel->codigo }} - {{ $imovel->titulo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('imovel_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Observações</h4>
                
                <div>
                    <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-1">Observações Adicionais</label>
                    <textarea name="observacoes" id="observacoes" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('observacoes') border-red-500 @enderror" 
                              rows="4">{{ old('observacoes') }}</textarea>
                    @error('observacoes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-4 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar Tarefa
                </button>
                <a href="{{ route('admin.crm.tarefas') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection