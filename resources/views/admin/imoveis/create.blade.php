@extends('layouts.admin')

@section('page-title', 'Novo Imóvel')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.imoveis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Informações Básicas</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                    <select name="tipo_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Selecione</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Finalidade *</label>
                    <select name="finalidade_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Selecione</option>
                        @foreach($finalidades as $finalidade)
                            <option value="{{ $finalidade->id }}">{{ $finalidade->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                    <input type="number" name="preco" value="{{ old('preco') }}" step="0.01" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="ativo">Ativo</option>
                        <option value="vendido">Vendido</option>
                        <option value="alugado">Alugado</option>
                        <option value="oculto">Oculto</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="destaque" value="1" class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Imóvel em destaque</span>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea name="descricao" rows="4" 
                              class="w-full px-4 py-2 border rounded-lg">{{ old('descricao') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Características</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quartos *</label>
                    <input type="number" name="quartos" value="{{ old('quartos', 0) }}" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Banheiros *</label>
                    <input type="number" name="banheiros" value="{{ old('banheiros', 0) }}" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vagas *</label>
                    <input type="number" name="vagas" value="{{ old('vagas', 0) }}" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Área Total (m²)</label>
                    <input type="number" name="area_total" value="{{ old('area_total') }}" step="0.01"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Área Construída (m²)</label>
                    <input type="number" name="area_construida" value="{{ old('area_construida') }}" step="0.01"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Localização</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco') }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                    <input type="text" name="cidade" value="{{ old('cidade') }}" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                    <input type="text" name="bairro" value="{{ old('bairro') }}" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                    <input type="text" name="cep" value="{{ old('cep') }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Imagens</h3>
            <input type="file" name="imagens[]" multiple accept="image/*"
                   class="w-full px-4 py-2 border rounded-lg">
            <p class="text-sm text-gray-500 mt-2">Você pode selecionar múltiplas imagens (máx. 5MB cada)</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save"></i> Salvar
            </button>
            <a href="{{ route('admin.imoveis.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

