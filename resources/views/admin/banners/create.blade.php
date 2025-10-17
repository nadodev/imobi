@extends('layouts.admin')

@section('page-title', 'Criar Banner')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Criar Banner</h1>
                <a href="{{ route('admin.banners.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Informações Básicas -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Informações Básicas</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('titulo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea id="descricao" name="descricao" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="posicao" class="block text-sm font-medium text-gray-700 mb-2">Posição *</label>
                            <select id="posicao" name="posicao"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione a posição</option>
                                <option value="hero" {{ old('posicao') == 'hero' ? 'selected' : '' }}>Hero (Banner Principal)</option>
                                <option value="sidebar" {{ old('posicao') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                <option value="footer" {{ old('posicao') == 'footer' ? 'selected' : '' }}>Footer</option>
                            </select>
                            @error('posicao')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ordem" class="block text-sm font-medium text-gray-700 mb-2">Ordem</label>
                            <input type="number" id="ordem" name="ordem" value="{{ old('ordem', 0) }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('ordem')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Link (URL)</label>
                            <input type="url" id="link" name="link" value="{{ old('link') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://exemplo.com">
                            @error('link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="ativo" class="ml-2 block text-sm text-gray-700">
                                Banner ativo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Imagem -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Imagem do Banner</h2>
                    
                    <div>
                        <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">Imagem *</label>
                        <input type="file" id="imagem" name="imagem" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-2">Formatos aceitos: JPG, PNG, WebP. Tamanho máximo: 5MB</p>
                        @error('imagem')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Período de Exibição -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Período de Exibição (Opcional)</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-2">Data de Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" value="{{ old('data_inicio') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('data_inicio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-2">Data de Fim</label>
                            <input type="date" id="data_fim" name="data_fim" value="{{ old('data_fim') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('data_fim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Deixe em branco para exibir permanentemente</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Criar Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
