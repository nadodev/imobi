@extends('layouts.site')

@section('title', 'Contato - Imobiliária')

@section('content')
<!-- Hero -->
<section class="gradient-bg py-20 text-white relative">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Entre em Contato</h1>
        <p class="text-xl md:text-2xl text-white/90">Estamos prontos para te atender</p>
    </div>
</section>

<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulário -->
            <div class="bg-white rounded-3xl shadow-2xl p-10">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-3">Envie sua Mensagem</h2>
                    <p class="text-gray-600 text-lg">Preencha o formulário abaixo e entraremos em contato o mais breve possível</p>
                </div>
                
                <form action="{{ route('contato.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nome Completo *</label>
                        <input type="text" name="nome" required
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" required
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Telefone</label>
                        <input type="tel" name="telefone"
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Assunto</label>
                        <input type="text" name="assunto"
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mensagem *</label>
                        <textarea name="mensagem" rows="6" required
                                  class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none text-lg"></textarea>
                    </div>

                    <button type="submit" class="w-full btn-primary text-white py-5 rounded-xl font-bold text-lg shadow-2xl">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar Mensagem
                    </button>
                </form>
            </div>

            <!-- Informações e Mapa -->
            <div class="space-y-8">
                <!-- Cards de Informação -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Endereço</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $config['endereco'] ?: 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP, 01310-100' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-phone text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Telefone</h3>
                                <p class="text-gray-600 text-lg">{{ $config['telefone'] ?: '(11) 9999-9999' }}</p>
                                <a href="https://wa.me/5511999999999" target="_blank" 
                                   class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold mt-2">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-envelope text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">E-mail</h3>
                                <p class="text-gray-600 text-lg">{{ $config['email'] ?: 'contato@imobiliaria.com' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-clock text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Horário de Atendimento</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    <strong>Segunda a Sexta:</strong> 9h às 18h<br>
                                    <strong>Sábado:</strong> 9h às 13h
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 h-80 rounded-2xl flex items-center justify-center shadow-inner">
                        <div class="text-center">
                            <i class="fas fa-map text-6xl text-blue-400 mb-4"></i>
                            <p class="text-gray-600 font-medium">Mapa de Localização</p>
                        </div>
                    </div>
                </div>

                <!-- Redes Sociais -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Siga-nos nas Redes Sociais</h3>
                    <p class="text-white/90 mb-6">Fique por dentro das novidades e lançamentos</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-14 h-14 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="w-14 h-14 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="w-14 h-14 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>
                        <a href="#" class="w-14 h-14 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-linkedin text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl shadow-2xl p-12 text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Prefere falar diretamente conosco?</h2>
            <p class="text-xl text-white/90 mb-8">Nossa equipe está sempre disponível para te atender</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:11999999999" 
                   class="inline-flex items-center gap-3 px-10 py-5 bg-white text-blue-600 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all shadow-xl">
                    <i class="fas fa-phone"></i> (11) 9999-9999
                </a>
                <a href="https://wa.me/5511999999999" 
                   target="_blank"
                   class="inline-flex items-center gap-3 px-10 py-5 bg-green-500 text-white rounded-2xl font-bold text-lg hover:bg-green-600 transition-all shadow-xl">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
