@extends('layouts.admin')

@section('page-title', 'Configurações do Sistema')

@section('content')
<form action="{{ route('admin.configuracoes.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Dados da Imobiliária</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome da Empresa</label>
                <input type="text" name="nome_empresa" 
                       value="{{ $configuracoes['geral']['nome_empresa'] ?? 'Imobiliária' }}"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                <input type="text" name="telefone" 
                       value="{{ $configuracoes['geral']['telefone'] ?? '' }}"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                <input type="email" name="email" 
                       value="{{ $configuracoes['geral']['email'] ?? '' }}"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                <input type="text" name="endereco" 
                       value="{{ $configuracoes['geral']['endereco'] ?? '' }}"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Redes Sociais</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                <input type="url" name="facebook" 
                       value="{{ $configuracoes['geral']['facebook'] ?? '' }}"
                       placeholder="https://facebook.com/..."
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                <input type="url" name="instagram" 
                       value="{{ $configuracoes['geral']['instagram'] ?? '' }}"
                       placeholder="https://instagram.com/..."
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp (com código do país)</label>
                <input type="text" name="whatsapp" 
                       value="{{ $configuracoes['geral']['whatsapp'] ?? '' }}"
                       placeholder="5511999999999"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Textos Institucionais</h3>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sobre Nós</label>
                <textarea name="sobre" rows="4"
                          class="w-full px-4 py-2 border rounded-lg">{{ $configuracoes['geral']['sobre'] ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Política de Privacidade</label>
                <textarea name="politica_privacidade" rows="4"
                          class="w-full px-4 py-2 border rounded-lg">{{ $configuracoes['geral']['politica_privacidade'] ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Integrações</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Maps API Key</label>
                <input type="text" name="google_maps_api" 
                       value="{{ $configuracoes['geral']['google_maps_api'] ?? '' }}"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-save"></i> Salvar Configurações
        </button>
    </div>
</form>
@endsection

