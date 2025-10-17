@extends('layouts.admin')

@section('title', 'Editar Página Sobre')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Página Sobre</h1>
            <p class="text-gray-600 mt-2">Configure as informações da sua imobiliária</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.galeria-sobre.index', $paginaSobre) }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-images mr-2"></i>
                Galeria
            </a>
            <a href="{{ route('sobre.index') }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>
                Ver Página
            </a>
            <form action="{{ route('admin.pagina-sobre.toggle-status', $paginaSobre) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 {{ $paginaSobre->ativa ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                    <i class="fas {{ $paginaSobre->ativa ? 'fa-eye-slash' : 'fa-eye' }} mr-2"></i>
                    {{ $paginaSobre->ativa ? 'Desativar' : 'Ativar' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Status Alert -->
    @if(!$paginaSobre->ativa)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                <p class="text-yellow-800">
                    <strong>Atenção:</strong> Esta página está desativada e não será exibida no site público.
                </p>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.pagina-sobre.update', $paginaSobre) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informações Básicas</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="titulo_principal" class="block text-sm font-medium text-gray-700 mb-2">
                        Título Principal *
                    </label>
                    <input type="text" 
                           id="titulo_principal" 
                           name="titulo_principal" 
                           value="{{ old('titulo_principal', $paginaSobre->titulo_principal) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: Sua Imobiliária de Confiança"
                           required>
                    @error('titulo_principal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="subtitulo" class="block text-sm font-medium text-gray-700 mb-2">
                        Subtítulo
                    </label>
                    <input type="text" 
                           id="subtitulo" 
                           name="subtitulo" 
                           value="{{ old('subtitulo', $paginaSobre->subtitulo) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: Transformando sonhos em realidade há mais de 20 anos">
                    @error('subtitulo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="descricao_principal" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição Principal *
                    </label>
                    <textarea id="descricao_principal" 
                              name="descricao_principal" 
                              rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Conte a história da sua imobiliária, seus diferenciais e compromissos..."
                              required>{{ old('descricao_principal', $paginaSobre->descricao_principal) }}</textarea>
                    @error('descricao_principal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Mission, Vision, Values -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Missão, Visão e Valores</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label for="missao" class="block text-sm font-medium text-gray-700 mb-2">
                        Missão
                    </label>
                    <textarea id="missao" 
                              name="missao" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Qual é a missão da sua empresa?">{{ old('missao', $paginaSobre->missao) }}</textarea>
                    @error('missao')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="visao" class="block text-sm font-medium text-gray-700 mb-2">
                        Visão
                    </label>
                    <textarea id="visao" 
                              name="visao" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Qual é a visão da sua empresa?">{{ old('visao', $paginaSobre->visao) }}</textarea>
                    @error('visao')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="valores" class="block text-sm font-medium text-gray-700 mb-2">
                        Valores
                    </label>
                    <textarea id="valores" 
                              name="valores" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Quais são os valores da sua empresa?">{{ old('valores', $paginaSobre->valores) }}</textarea>
                    @error('valores')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Imagens</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="imagem_principal" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem Principal
                    </label>
                    @if($paginaSobre->imagem_principal_url)
                        <div class="mb-4">
                            <img src="{{ $paginaSobre->imagem_principal_url }}" 
                                 alt="Imagem atual" 
                                 class="w-full h-48 object-cover rounded-lg">
                            <p class="text-sm text-gray-500 mt-2">Imagem atual</p>
                        </div>
                    @endif
                    <input type="file" 
                           id="imagem_principal" 
                           name="imagem_principal" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Recomendado: 800x600px ou maior</p>
                    @error('imagem_principal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="imagem_equipe" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem da Equipe
                    </label>
                    @if($paginaSobre->imagem_equipe_url)
                        <div class="mb-4">
                            <img src="{{ $paginaSobre->imagem_equipe_url }}" 
                                 alt="Imagem atual" 
                                 class="w-full h-48 object-cover rounded-lg">
                            <p class="text-sm text-gray-500 mt-2">Imagem atual</p>
                        </div>
                    @endif
                    <input type="file" 
                           id="imagem_equipe" 
                           name="imagem_equipe" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Recomendado: 800x600px ou maior</p>
                    @error('imagem_equipe')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Company Data -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Dados da Empresa</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telefone
                    </label>
                    <input type="text" 
                           id="telefone" 
                           name="telefone" 
                           value="{{ old('telefone', $paginaSobre->dados_empresa['telefone'] ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="(11) 99999-9999">
                    @error('telefone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $paginaSobre->dados_empresa['email'] ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="contato@imobiliaria.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-3">
                    <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">
                        Endereço
                    </label>
                    <input type="text" 
                           id="endereco" 
                           name="endereco" 
                           value="{{ old('endereco', $paginaSobre->dados_empresa['endereco'] ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Rua das Flores, 123 - Centro - São Paulo/SP">
                    @error('endereco')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Estatísticas</h2>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div>
                    <label for="anos_mercado" class="block text-sm font-medium text-gray-700 mb-2">
                        Anos no Mercado
                    </label>
                    <input type="number" 
                           id="anos_mercado" 
                           name="anos_mercado" 
                           value="{{ old('anos_mercado', $paginaSobre->estatisticas['anos_mercado'] ?? '') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="20">
                    @error('anos_mercado')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="imoveis_vendidos" class="block text-sm font-medium text-gray-700 mb-2">
                        Imóveis Vendidos
                    </label>
                    <input type="number" 
                           id="imoveis_vendidos" 
                           name="imoveis_vendidos" 
                           value="{{ old('imoveis_vendidos', $paginaSobre->estatisticas['imoveis_vendidos'] ?? '') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="1500">
                    @error('imoveis_vendidos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="clientes_atendidos" class="block text-sm font-medium text-gray-700 mb-2">
                        Clientes Atendidos
                    </label>
                    <input type="number" 
                           id="clientes_atendidos" 
                           name="clientes_atendidos" 
                           value="{{ old('clientes_atendidos', $paginaSobre->estatisticas['clientes_atendidos'] ?? '') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="5000">
                    @error('clientes_atendidos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="equipe_profissionais" class="block text-sm font-medium text-gray-700 mb-2">
                        Profissionais na Equipe
                    </label>
                    <input type="number" 
                           id="equipe_profissionais" 
                           name="equipe_profissionais" 
                           value="{{ old('equipe_profissionais', $paginaSobre->estatisticas['equipe_profissionais'] ?? '') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="25">
                    @error('equipe_profissionais')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection
