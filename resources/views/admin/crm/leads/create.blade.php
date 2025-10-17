@extends('layouts.admin')

@section('title', 'Criar Lead')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>Criar Lead
        </h1>
        <a href="{{ route('admin.crm.leads') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Dados do Lead</h3>
        <form method="POST" action="{{ route('admin.crm.leads.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Dados Pessoais -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Dados Pessoais</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                            <input type="text" name="nome" id="nome" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-500 @enderror" 
                                   value="{{ old('nome') }}" required>
                            @error('nome')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
                            <input type="text" name="telefone" id="telefone" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('telefone') border-red-500 @enderror" 
                                   value="{{ old('telefone') }}" required>
                            @error('telefone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                            <textarea name="observacoes" id="observacoes" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('observacoes') border-red-500 @enderror" 
                                      rows="3">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dados do Lead -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Dados do Lead</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="origem" class="block text-sm font-medium text-gray-700 mb-1">Origem *</label>
                            <select name="origem" id="origem" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('origem') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                <option value="site" {{ old('origem') == 'site' ? 'selected' : '' }}>Site</option>
                                <option value="whatsapp" {{ old('origem') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="instagram" {{ old('origem') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="facebook" {{ old('origem') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                <option value="indicacao" {{ old('origem') == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                <option value="outro" {{ old('origem') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('origem')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                                <option value="">Selecione</option>
                                <option value="novo" {{ old('status') == 'novo' ? 'selected' : '' }}>Novo</option>
                                <option value="contatado" {{ old('status') == 'contatado' ? 'selected' : '' }}>Contatado</option>
                                <option value="qualificado" {{ old('status') == 'qualificado' ? 'selected' : '' }}>Qualificado</option>
                                <option value="proposta" {{ old('status') == 'proposta' ? 'selected' : '' }}>Proposta</option>
                                <option value="negociacao" {{ old('status') == 'negociacao' ? 'selected' : '' }}>Negociação</option>
                                <option value="fechado" {{ old('status') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                                <option value="perdido" {{ old('status') == 'perdido' ? 'selected' : '' }}>Perdido</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="corretor_id" class="block text-sm font-medium text-gray-700 mb-1">Corretor Responsável</label>
                            <select name="corretor_id" id="corretor_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('corretor_id') border-red-500 @enderror">
                                <option value="">Selecione</option>
                                @foreach($corretores as $corretor)
                                    <option value="{{ $corretor->id }}" {{ old('corretor_id') == $corretor->id ? 'selected' : '' }}>
                                        {{ $corretor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('corretor_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="imovel_id" class="block text-sm font-medium text-gray-700 mb-1">Imóvel de Interesse</label>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Interesse -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Interesse</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="tipo_interesse" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Interesse</label>
                            <select name="tipo_interesse" id="tipo_interesse" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo_interesse') border-red-500 @enderror">
                                <option value="">Selecione</option>
                                <option value="compra" {{ old('tipo_interesse') == 'compra' ? 'selected' : '' }}>Compra</option>
                                <option value="venda" {{ old('tipo_interesse') == 'venda' ? 'selected' : '' }}>Venda</option>
                                <option value="aluguel" {{ old('tipo_interesse') == 'aluguel' ? 'selected' : '' }}>Aluguel</option>
                                <option value="locacao" {{ old('tipo_interesse') == 'locacao' ? 'selected' : '' }}>Locação</option>
                            </select>
                            @error('tipo_interesse')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="valor_interesse" class="block text-sm font-medium text-gray-700 mb-1">Valor de Interesse</label>
                            <input type="number" name="valor_interesse" id="valor_interesse" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('valor_interesse') border-red-500 @enderror" 
                                   value="{{ old('valor_interesse') }}" step="0.01" min="0">
                            @error('valor_interesse')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Localização -->
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Localização de Interesse</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="cidade_interesse" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                            <input type="text" name="cidade_interesse" id="cidade_interesse" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cidade_interesse') border-red-500 @enderror" 
                                   value="{{ old('cidade_interesse') }}">
                            @error('cidade_interesse')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bairro_interesse" class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                            <input type="text" name="bairro_interesse" id="bairro_interesse" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bairro_interesse') border-red-500 @enderror" 
                                   value="{{ old('bairro_interesse') }}">
                            @error('bairro_interesse')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quartos_interesse" class="block text-sm font-medium text-gray-700 mb-1">Quartos</label>
                                <input type="number" name="quartos_interesse" id="quartos_interesse" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quartos_interesse') border-red-500 @enderror" 
                                       value="{{ old('quartos_interesse') }}" min="0">
                                @error('quartos_interesse')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="banheiros_interesse" class="block text-sm font-medium text-gray-700 mb-1">Banheiros</label>
                                <input type="number" name="banheiros_interesse" id="banheiros_interesse" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('banheiros_interesse') border-red-500 @enderror" 
                                       value="{{ old('banheiros_interesse') }}" min="0">
                                @error('banheiros_interesse')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Follow-up</h4>
                
                <div class="max-w-md">
                    <label for="proximo_followup" class="block text-sm font-medium text-gray-700 mb-1">Próximo Follow-up</label>
                    <input type="datetime-local" name="proximo_followup" id="proximo_followup" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('proximo_followup') border-red-500 @enderror" 
                           value="{{ old('proximo_followup') }}">
                    @error('proximo_followup')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-4 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar Lead
                </button>
                <a href="{{ route('admin.crm.leads') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection