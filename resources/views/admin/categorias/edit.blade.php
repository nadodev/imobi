@extends('layouts.admin')

@section('page-title', 'Editar Categoria')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Editar Categoria</h1>
    <p class="text-gray-600">Edite a categoria: {{ $categoria->nome }}</p>
</div>

<form method="POST" action="{{ route('admin.categorias.update', $categoria) }}" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informações Básicas -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                    <input type="text" name="nome" value="{{ old('nome', $categoria->nome) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: Dicas de Investimento">
                    @error('nome')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea name="descricao" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Descrição da categoria...">{{ old('descricao', $categoria->descricao) }}</textarea>
                    @error('descricao')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                    <input type="number" name="ordem" value="{{ old('ordem', $categoria->ordem) }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0">
                    <p class="text-sm text-gray-500 mt-1">Ordem de exibição (menor número aparece primeiro)</p>
                    @error('ordem')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Aparência -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor *</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="cor" value="{{ old('cor', $categoria->cor) }}" required
                               class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                        <input type="text" name="cor_text" value="{{ old('cor', $categoria->cor) }}"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="#3B82F6">
                    </div>
                    @error('cor')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ícone</label>
                    <div class="relative">
                        <input type="text" name="icone" value="{{ old('icone', $categoria->icone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="fas fa-folder">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-info-circle text-gray-400"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Classe do FontAwesome (ex: fas fa-folder, fas fa-chart-line)</p>
                    @error('icone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="ativa" value="1" {{ old('ativa', $categoria->ativa) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Categoria ativa</span>
                    </label>
                </div>

                <!-- Preview -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Preview</h3>
                    <div class="flex items-center space-x-3">
                        <div id="preview-icon" class="h-10 w-10 rounded-full flex items-center justify-center" 
                             style="background-color: {{ old('cor', $categoria->cor) }}">
                            <i id="preview-icon-class" class="{{ old('icone', $categoria->icone) ?: 'fas fa-folder' }} text-white"></i>
                        </div>
                        <div>
                            <div id="preview-name" class="text-sm font-medium text-gray-900">
                                {{ old('nome', $categoria->nome) }}
                            </div>
                            <div id="preview-desc" class="text-sm text-gray-500">
                                {{ old('descricao', $categoria->descricao) ?: 'Descrição da categoria' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Estatísticas</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total de Artigos:</span>
                            <span class="text-sm font-medium">{{ $categoria->total_artigos }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Criada em:</span>
                            <span class="text-sm font-medium">{{ $categoria->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Atualizada em:</span>
                            <span class="text-sm font-medium">{{ $categoria->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.categorias.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
            Cancelar
        </a>
        <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fas fa-save mr-2"></i> Atualizar Categoria
        </button>
    </div>
</form>

<script>
// Atualizar preview em tempo real
document.addEventListener('DOMContentLoaded', function() {
    const nomeInput = document.querySelector('input[name="nome"]');
    const descricaoInput = document.querySelector('textarea[name="descricao"]');
    const corInput = document.querySelector('input[name="cor"]');
    const corTextInput = document.querySelector('input[name="cor_text"]');
    const iconeInput = document.querySelector('input[name="icone"]');

    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-desc');
    const previewIcon = document.getElementById('preview-icon');
    const previewIconClass = document.getElementById('preview-icon-class');

    function updatePreview() {
        previewName.textContent = nomeInput.value || 'Nome da Categoria';
        previewDesc.textContent = descricaoInput.value || 'Descrição da categoria';
        previewIcon.style.backgroundColor = corInput.value;
        previewIconClass.className = (iconeInput.value || 'fas fa-folder') + ' text-white';
    }

    nomeInput.addEventListener('input', updatePreview);
    descricaoInput.addEventListener('input', updatePreview);
    corInput.addEventListener('input', function() {
        corTextInput.value = this.value;
        updatePreview();
    });
    corTextInput.addEventListener('input', function() {
        corInput.value = this.value;
        updatePreview();
    });
    iconeInput.addEventListener('input', updatePreview);
});
</script>
@endsection

