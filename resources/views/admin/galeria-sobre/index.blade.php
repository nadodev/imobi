@extends('layouts.admin')

@section('title', 'Galeria da Página Sobre')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Galeria da Página Sobre</h1>
            <p class="text-gray-600 mt-2">Gerencie as imagens da galeria da página "Sobre"</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pagina-sobre.edit', $paginaSobre) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar para Página Sobre
            </a>
            <a href="{{ route('sobre.index') }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>
                Ver Página
            </a>
        </div>
    </div>

    <!-- Add Images Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Adicionar Imagens à Galeria</h2>
        
        <form action="{{ route('admin.galeria-sobre.store', $paginaSobre) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="imagens" class="block text-sm font-medium text-gray-700 mb-2">
                    Selecionar Imagens *
                </label>
                <input type="file" 
                       id="imagens" 
                       name="imagens[]" 
                       multiple 
                       accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                <p class="text-sm text-gray-500 mt-1">Você pode selecionar múltiplas imagens. Recomendado: 800x600px ou maior</p>
                @error('imagens.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div id="imagens-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                <!-- Preview das imagens será inserido aqui via JavaScript -->
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Adicionar Imagens
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    @if($galeria->count() > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Imagens da Galeria</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galeria as $imagem)
                    <div class="relative group bg-gray-50 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <!-- Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                            <img src="{{ $imagem->imagem_url }}" 
                                 alt="{{ $imagem->titulo ?? 'Imagem da galeria' }}"
                                 class="w-full h-48 object-cover">
                        </div>
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex space-x-2">
                                <button onclick="editImage({{ $imagem->id }})" 
                                        class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.galeria-sobre.destroy', $imagem) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Tem certeza que deseja remover esta imagem?')"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            @if($imagem->ativa)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    Ativa
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                    Inativa
                                </span>
                            @endif
                        </div>
                        
                        <!-- Image Info -->
                        <div class="p-4">
                            @if($imagem->titulo)
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $imagem->titulo }}</h3>
                            @endif
                            @if($imagem->descricao)
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($imagem->descricao, 100) }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Ordem: {{ $imagem->ordem }}</span>
                                <form action="{{ route('admin.galeria-sobre.toggle-status', $imagem) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs {{ $imagem->ativa ? 'text-red-600 hover:text-red-700' : 'text-green-600 hover:text-green-700' }} transition-colors">
                                        {{ $imagem->ativa ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-images text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma imagem na galeria</h3>
            <p class="text-gray-600 mb-6">Adicione imagens para criar uma galeria visual atrativa na página "Sobre".</p>
        </div>
    @endif
</div>

<!-- Edit Image Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Editar Imagem</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label for="edit_titulo" class="block text-sm font-medium text-gray-700 mb-1">
                                Título
                            </label>
                            <input type="text" 
                                   id="edit_titulo" 
                                   name="titulo"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="edit_descricao" class="block text-sm font-medium text-gray-700 mb-1">
                                Descrição
                            </label>
                            <textarea id="edit_descricao" 
                                      name="descricao"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <div>
                            <label for="edit_ordem" class="block text-sm font-medium text-gray-700 mb-1">
                                Ordem
                            </label>
                            <input type="number" 
                                   id="edit_ordem" 
                                   name="ordem"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="edit_imagem" class="block text-sm font-medium text-gray-700 mb-1">
                                Nova Imagem (opcional)
                            </label>
                            <input type="file" 
                                   id="edit_imagem" 
                                   name="imagem"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" 
                                onclick="closeEditModal()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Preview das imagens selecionadas
document.getElementById('imagens').addEventListener('change', function(e) {
    const preview = document.getElementById('imagens-preview');
    preview.innerHTML = '';
    preview.classList.remove('hidden');
    
    Array.from(e.target.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                <div class="mt-2 space-y-2">
                    <input type="text" name="titulos[]" placeholder="Título da imagem ${index + 1}" 
                           class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                    <textarea name="descricoes[]" placeholder="Descrição da imagem ${index + 1}" 
                              rows="2" class="w-full px-2 py-1 text-sm border border-gray-300 rounded"></textarea>
                </div>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Modal de edição
function editImage(imageId) {
    // Aqui você pode fazer uma requisição AJAX para buscar os dados da imagem
    // Por simplicidade, vou usar um formulário simples
    document.getElementById('editForm').action = `/admin/galeria-sobre/${imageId}`;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
