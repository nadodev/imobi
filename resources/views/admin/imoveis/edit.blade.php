@extends('layouts.admin')

@section('page-title', 'Editar Imóvel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Editar </h1>
                <a href="{{ route('admin.imoveis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>

            
            <form action="{{ route('admin.imoveis.update', $imovel) }}" method="POST" enctype="multipart/form-data" id="formEditarImovel">
                @method('PUT')
                @csrf

                <!-- Informações Básicas -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Informações Básicas</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $imovel->titulo) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('titulo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                            <select id="tipo_id" name="tipo_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ $imovel->tipo_id == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="finalidade_id" class="block text-sm font-medium text-gray-700 mb-2">Finalidade *</label>
                            <select id="finalidade_id" name="finalidade_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach($finalidades as $finalidade)
                                    <option value="{{ $finalidade->id }}" {{ $imovel->finalidade_id == $finalidade->id ? 'selected' : '' }}>
                                        {{ $finalidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('finalidade_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="preco" class="block text-sm font-medium text-gray-700 mb-2">Preço *</label>
                            <input type="number" id="preco" name="preco" value="{{ old('preco', $imovel->preco) }}" step="0.01"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('preco')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select id="status" name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="ativo" {{ $imovel->status == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="vendido" {{ $imovel->status == 'vendido' ? 'selected' : '' }}>Vendido</option>
                                <option value="alugado" {{ $imovel->status == 'alugado' ? 'selected' : '' }}>Alugado</option>
                                <option value="oculto" {{ $imovel->status == 'oculto' ? 'selected' : '' }}>Oculto</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="destaque" value="1" {{ $imovel->destaque ? 'checked' : '' }} class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-700">Imóvel em destaque</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea id="descricao" name="descricao" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('descricao', $imovel->descricao) }}</textarea>
                            @error('descricao')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Características -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Características</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="quartos" class="block text-sm font-medium text-gray-700 mb-2">Quartos *</label>
                            <input type="number" id="quartos" name="quartos" value="{{ old('quartos', $imovel->quartos) }}" min="0" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('quartos')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="banheiros" class="block text-sm font-medium text-gray-700 mb-2">Banheiros *</label>
                            <input type="number" id="banheiros" name="banheiros" value="{{ old('banheiros', $imovel->banheiros) }}" min="0" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('banheiros')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vagas" class="block text-sm font-medium text-gray-700 mb-2">Vagas *</label>
                            <input type="number" id="vagas" name="vagas" value="{{ old('vagas', $imovel->vagas) }}" min="0" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('vagas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="area_total" class="block text-sm font-medium text-gray-700 mb-2">Área Total (m²)</label>
                            <input type="number" id="area_total" name="area_total" value="{{ old('area_total', $imovel->area_total) }}" step="0.01"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('area_total')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="area_construida" class="block text-sm font-medium text-gray-700 mb-2">Área Construída (m²)</label>
                            <input type="number" id="area_construida" name="area_construida" value="{{ old('area_construida', $imovel->area_construida) }}" step="0.01"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('area_construida')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Localização -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Localização</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                            <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $imovel->endereco) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('endereco')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cidade" class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                            <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $imovel->cidade) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('cidade')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                            <input type="text" id="bairro" name="bairro" value="{{ old('bairro', $imovel->bairro) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('bairro')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                            <input type="text" id="cep" name="cep" value="{{ old('cep', $imovel->cep) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('cep')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Imagens Existentes -->
                @if($imovel->imagens->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Imagens Atuais</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($imovel->imagens as $imagem)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $imagem->caminho) }}" alt="Imagem do imóvel" 
                                     class="w-full h-32 object-cover rounded-lg">
                                <button type="button" 
                                        onclick="deleteImage({{ $imovel->id }}, {{ $imagem->id }})"
                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition duration-200">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Novas Imagens -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Adicionar Novas Imagens</h2>
                    <input type="file" name="imagens[]" multiple accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-2">Você pode selecionar múltiplas imagens (máx. 5MB cada)</p>
                    @error('imagens.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="button" 
                            id="btnSubmit"
                            onclick="document.getElementById('formEditarImovel').submit();"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        ATUALIZAR IMÓVEL
                    </button>
                    <a href="{{ route('admin.imoveis.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        CANCELAR
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
<script>
function deleteImage(imovelId, imagemId) {
    if (confirm('Excluir esta imagem?')) {
        // Criar um formulário temporário para enviar a requisição DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/imoveis/${imovelId}/imagens/${imagemId}`;
        
        // Adicionar token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Adicionar método DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Adicionar ao DOM e submeter
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
@endsection