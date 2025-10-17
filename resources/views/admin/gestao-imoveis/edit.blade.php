@extends('layouts.admin')

@section('title', 'Editar Gestão de Imóvel')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2"></i>Editar Gestão - {{ $imovel->titulo }}
        </h1>
        <a href="{{ route('admin.gestao-imoveis.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Dados de Gestão do Imóvel</h3>
        <form method="POST" action="{{ route('admin.gestao-imoveis.update', $imovel) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Status e Controle -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Status e Controle</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status_gestao" class="block text-sm font-medium text-gray-700 mb-1">Status de Gestão *</label>
                            <select name="status_gestao" id="status_gestao" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_gestao') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                <option value="livre" {{ old('status_gestao', $imovel->status_gestao) == 'livre' ? 'selected' : '' }}>Livre</option>
                                <option value="reservado" {{ old('status_gestao', $imovel->status_gestao) == 'reservado' ? 'selected' : '' }}>Reservado</option>
                                <option value="vendido" {{ old('status_gestao', $imovel->status_gestao) == 'vendido' ? 'selected' : '' }}>Vendido</option>
                                <option value="alugado" {{ old('status_gestao', $imovel->status_gestao) == 'alugado' ? 'selected' : '' }}>Alugado</option>
                                <option value="indisponivel" {{ old('status_gestao', $imovel->status_gestao) == 'indisponivel' ? 'selected' : '' }}>Indisponível</option>
                            </select>
                            @error('status_gestao')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="corretor_responsavel" class="block text-sm font-medium text-gray-700 mb-1">Corretor Responsável</label>
                            <select name="corretor_responsavel" id="corretor_responsavel" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('corretor_responsavel') border-red-500 @enderror">
                                <option value="">Selecione</option>
                                @foreach($corretores as $corretor)
                                    <option value="{{ $corretor->id }}" {{ old('corretor_responsavel', $imovel->corretor_responsavel) == $corretor->id ? 'selected' : '' }}>
                                        {{ $corretor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('corretor_responsavel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Controle de Chaves -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Controle de Chaves</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="numero_chaves" class="block text-sm font-medium text-gray-700 mb-1">Número de Chaves</label>
                            <input type="text" name="numero_chaves" id="numero_chaves" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('numero_chaves') border-red-500 @enderror" 
                                   value="{{ old('numero_chaves', $imovel->numero_chaves) }}" placeholder="Ex: 2 chaves">
                            @error('numero_chaves')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="localizacao_chaves" class="block text-sm font-medium text-gray-700 mb-1">Localização das Chaves</label>
                            <input type="text" name="localizacao_chaves" id="localizacao_chaves" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('localizacao_chaves') border-red-500 @enderror" 
                                   value="{{ old('localizacao_chaves', $imovel->localizacao_chaves) }}" placeholder="Ex: Escritório, Corretor João">
                            @error('localizacao_chaves')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Datas Importantes -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Datas Importantes</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="data_revisao_contrato" class="block text-sm font-medium text-gray-700 mb-1">Data de Revisão do Contrato</label>
                            <input type="date" name="data_revisao_contrato" id="data_revisao_contrato" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_revisao_contrato') border-red-500 @enderror" 
                                   value="{{ old('data_revisao_contrato', $imovel->data_revisao_contrato ? $imovel->data_revisao_contrato->format('Y-m-d') : '') }}">
                            @error('data_revisao_contrato')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="data_vencimento_aluguel" class="block text-sm font-medium text-gray-700 mb-1">Data de Vencimento do Aluguel</label>
                            <input type="date" name="data_vencimento_aluguel" id="data_vencimento_aluguel" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_vencimento_aluguel') border-red-500 @enderror" 
                                   value="{{ old('data_vencimento_aluguel', $imovel->data_vencimento_aluguel ? $imovel->data_vencimento_aluguel->format('Y-m-d') : '') }}">
                            @error('data_vencimento_aluguel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Observações</h4>
                    
                    <div>
                        <label for="observacoes_gestao" class="block text-sm font-medium text-gray-700 mb-1">Observações de Gestão</label>
                        <textarea name="observacoes_gestao" id="observacoes_gestao" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('observacoes_gestao') border-red-500 @enderror" 
                                  rows="6" placeholder="Informações importantes sobre a gestão do imóvel...">{{ old('observacoes_gestao', $imovel->observacoes_gestao) }}</textarea>
                        @error('observacoes_gestao')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Alertas de Contrato -->
            @if($imovel->data_vencimento_aluguel && $imovel->isContratoVencendo())
                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">Atenção: Contrato de aluguel vencendo em {{ $imovel->data_vencimento_aluguel->diffForHumans() }}</span>
                    </div>
                </div>
            @endif

            <div class="flex space-x-4 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Atualizar Gestão
                </button>
                <a href="{{ route('admin.gestao-imoveis.show', $imovel) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-eye mr-2"></i> Ver Detalhes
                </a>
                <a href="{{ route('admin.gestao-imoveis.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
