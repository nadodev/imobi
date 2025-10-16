@extends('layouts.site')

@section('title', 'Contato - Imobiliária')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-12">Entre em Contato</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulário -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-semibold mb-6">Envie sua Mensagem</h2>
                
                <form action="{{ route('contato.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                        <input type="text" name="nome" required
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input type="tel" name="telefone"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assunto</label>
                        <input type="text" name="assunto"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem *</label>
                        <textarea name="mensagem" rows="6" required
                                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-paper-plane"></i> Enviar Mensagem
                    </button>
                </form>
            </div>

            <!-- Informações de Contato -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-semibold mb-6">Informações de Contato</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl mt-1 mr-4"></i>
                            <div>
                                <p class="font-semibold">Endereço</p>
                                <p class="text-gray-600">{{ $config['endereco'] ?: 'Av. Paulista, 1000 - São Paulo, SP' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-phone text-blue-600 text-xl mt-1 mr-4"></i>
                            <div>
                                <p class="font-semibold">Telefone</p>
                                <p class="text-gray-600">{{ $config['telefone'] ?: '(11) 9999-9999' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-envelope text-blue-600 text-xl mt-1 mr-4"></i>
                            <div>
                                <p class="font-semibold">E-mail</p>
                                <p class="text-gray-600">{{ $config['email'] ?: 'contato@imobiliaria.com' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-clock text-blue-600 text-xl mt-1 mr-4"></i>
                            <div>
                                <p class="font-semibold">Horário de Atendimento</p>
                                <p class="text-gray-600">Segunda a Sexta: 9h às 18h<br>Sábado: 9h às 13h</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">
                            <i class="fas fa-map text-4xl"></i><br>
                            Mapa
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

