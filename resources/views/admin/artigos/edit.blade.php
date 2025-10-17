@extends('layouts.admin')

@section('page-title', 'Editar Artigo')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Editar Artigo</h1>
    <p class="text-gray-600">Edite o artigo: {{ $artigo->titulo }}</p>
</div>

<form method="POST" action="{{ route('admin.artigos.update', $artigo) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $artigo->titulo) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('titulo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Resumo *</label>
                    <textarea name="resumo" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Breve descrição do artigo...">{{ old('resumo', $artigo->resumo) }}</textarea>
                    @error('resumo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Conteúdo *</label>
                    <textarea name="conteudo" id="conteudo" rows="15" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Conteúdo completo do artigo...">{{ old('conteudo', $artigo->conteudo) }}</textarea>
                    @error('conteudo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags', is_array($artigo->tags) ? implode(', ', $artigo->tags) : $artigo->tags) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: imóveis, investimento, dicas (separadas por vírgula)">
                    <p class="text-sm text-gray-500 mt-1">Separe as tags por vírgula</p>
                    @error('tags')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status e Configurações -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Configurações</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="rascunho" {{ old('status', $artigo->status) == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                                <option value="publicado" {{ old('status', $artigo->status) == 'publicado' ? 'selected' : '' }}>Publicado</option>
                                <option value="arquivado" {{ old('status', $artigo->status) == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                            <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="geral" {{ old('categoria', $artigo->categoria) == 'geral' ? 'selected' : '' }}>Geral</option>
                                <option value="dicas" {{ old('categoria', $artigo->categoria) == 'dicas' ? 'selected' : '' }}>Dicas</option>
                                <option value="mercado" {{ old('categoria', $artigo->categoria) == 'mercado' ? 'selected' : '' }}>Mercado</option>
                                <option value="financiamento" {{ old('categoria', $artigo->categoria) == 'financiamento' ? 'selected' : '' }}>Financiamento</option>
                                <option value="investimento" {{ old('categoria', $artigo->categoria) == 'investimento' ? 'selected' : '' }}>Investimento</option>
                            </select>
                            @error('categoria')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="destaque" value="1" {{ old('destaque', $artigo->destaque) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Artigo em destaque</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data de Publicação</label>
                            <input type="datetime-local" name="publicado_em" 
                                   value="{{ old('publicado_em', $artigo->publicado_em ? $artigo->publicado_em->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Deixe em branco para publicar imediatamente</p>
                            @error('publicado_em')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Imagem de Destaque -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagem de Destaque</h3>
                    
                    <div class="space-y-4">
                        @if($artigo->imagem_destaque)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $artigo->imagem_destaque) }}" 
                                     class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $artigo->imagem_destaque ? 'Alterar imagem' : 'Selecionar imagem' }}
                            </label>
                            <input type="file" name="imagem_destaque" id="imagem_destaque" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   onchange="previewImage(this)">
                            @error('imagem_destaque')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="image-preview" class="hidden">
                            <p class="text-sm text-gray-600 mb-2">Nova imagem:</p>
                            <img id="preview-img" class="w-full h-32 object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Visualizações:</span>
                            <span class="text-sm font-medium">{{ $artigo->visualizacoes }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Criado em:</span>
                            <span class="text-sm font-medium">{{ $artigo->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Atualizado em:</span>
                            <span class="text-sm font-medium">{{ $artigo->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.artigos.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
            Cancelar
        </a>
        <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fas fa-save mr-2"></i> Atualizar Artigo
        </button>
    </div>
</form>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endsection

