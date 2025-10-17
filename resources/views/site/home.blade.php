@extends('layouts.site')

@section('title', 'Home - Imobiliária Prime')

@section('content')
<!-- Hero Section -->
@if($bannersHero->count() > 0)
    <section class="relative overflow-hidden py-16 md:py-20 hero-carousel">
        <!-- Background Images -->
        @foreach($bannersHero as $index => $banner)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" 
                 style="background-image: url('{{ asset('storage/' . $banner->imagem) }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0  bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900/70
"></div>
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
        @endforeach
        <!-- Navigation Arrows -->
        @if($bannersHero->count() > 1)
            <button class="hero-nav hero-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all">
                <i class="fas fa-chevron-left text-xl"></i>
            </button>
            <button class="hero-nav hero-next absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all">
                <i class="fas fa-chevron-right text-xl"></i>
            </button>
        @endif
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10 pt-8">
            @foreach($bannersHero as $index => $banner)
                <div class="hero-content {{ $index === 0 ? 'active' : '' }} text-center text-white fade-in">
                    @if($banner->link)
                        <a href="{{ $banner->link }}" class="block">
                    @endif
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight drop-shadow-2xl">
                        {{ $banner->titulo }}
                    </h1>
                    @if($banner->descricao)
                        <p class="text-lg md:text-xl mb-8 text-white/95 max-w-2xl mx-auto drop-shadow-lg">
                            {{ $banner->descricao }}
                        </p>
                    @endif
                    @if($banner->link)
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        
        <!-- Indicators -->
        @if($bannersHero->count() > 1)
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2">
                @foreach($bannersHero as $index => $banner)
                    <button class="hero-indicator w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-600 border-2 border-blue-900' : 'bg-blue-600/50' }} transition-all"></button>
                @endforeach
            </div>
        @endif
@else
    <section class="relative overflow-hidden gradient-bg py-16 md:py-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/40"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="container mx-auto px-4 relative z-10 pt-8">
            <div class="text-center text-white fade-in">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight drop-shadow-2xl">
                    Encontre o Imóvel<br>
                    <span class="bg-white bg-clip-text text-transparent drop-shadow-2xl">dos Seus Sonhos</span>
                </h1>
                <p class="text-lg md:text-xl mb-8 text-white/95 max-w-2xl mx-auto drop-shadow-lg">
                    Milhares de opções para venda e aluguel com a melhor assessoria do mercado
                </p>
@endif
            
            <!-- Quick Search -->
            <form action="{{ route('imoveis.index') }}" method="GET" class="max-w-5xl mx-auto mt-8 z-10 relative">
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-6 md:p-8 border border-white/20">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-800 mb-2 text-left">Finalidade</label>
                            <select name="finalidade_id" class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-300 bg-white text-gray-800 font-semibold focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition-all shadow-sm">
                                <option value="">Todas</option>
                                @foreach($finalidades as $finalidade)
                                    <option value="{{ $finalidade->id }}">{{ $finalidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-800 mb-2 text-left">Tipo</label>
                            <select name="tipo_id" class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-300 bg-white text-gray-800 font-semibold focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition-all shadow-sm">
                                <option value="">Todos os tipos</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-800 mb-2 text-left">Cidade</label>
                            <input type="text" name="cidade" placeholder="Digite a cidade" 
                                   class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-300 bg-white text-gray-800 font-semibold focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition-all shadow-sm placeholder-gray-500">
                        </div>
                        
                        <button type="submit" class="md:mt-7 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-bold text-lg shadow-xl transition-all transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-[-2px] left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-building text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">1000+</div>
                <div class="text-gray-600 font-medium">Imóveis</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">500+</div>
                <div class="text-gray-600 font-medium">Clientes Felizes</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-handshake text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">20+</div>
                <div class="text-gray-600 font-medium">Anos de Experiência</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-award text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">100%</div>
                <div class="text-gray-600 font-medium">Satisfação</div>
            </div>
        </div>
    </div>
</section>

<!-- Imóveis em Destaque -->
@if($imoveisDestaque->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <div class="inline-block px-4 py-2 bg-yellow-100 rounded-full mb-4">
                <span class="text-yellow-800 font-semibold text-sm"><i class="fas fa-star mr-1"></i> DESTAQUES</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Imóveis em Destaque
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Selecionamos os melhores imóveis especialmente para você
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($imoveisDestaque as $imovel)
                <x-card-imovel :imovel="$imovel" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Por que escolher a gente?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Oferecemos o melhor serviço com as melhores condições do mercado
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all feature-card">
                <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center mb-6 feature-icon shadow-lg">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Segurança Total</h3>
                <p class="text-gray-600 leading-relaxed">
                    Todos os nossos imóveis são verificados e documentados para garantir sua tranquilidade e segurança.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all feature-card">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 feature-icon shadow-lg">
                    <i class="fas fa-headset text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Atendimento Personalizado</h3>
                <p class="text-gray-600 leading-relaxed">
                    Nossa equipe está pronta para te atender e encontrar o imóvel perfeito para suas necessidades.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all feature-card">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 feature-icon shadow-lg">
                    <i class="fas fa-tags text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Melhores Preços</h3>
                <p class="text-gray-600 leading-relaxed">
                    Trabalhamos com valores justos e condições especiais de financiamento para você realizar seu sonho.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Imóveis Recentes -->
@if($imoveisRecentes->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <div class="inline-block px-4 py-2 bg-blue-100 rounded-full mb-4">
                <span class="text-blue-800 font-semibold text-sm"><i class="fas fa-clock mr-1"></i> NOVIDADES</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Imóveis Recentes
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Confira as últimas novidades do nosso portfólio
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($imoveisRecentes as $imovel)
                <x-card-imovel :imovel="$imovel" />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('imoveis.index') }}" 
               class="inline-flex items-center gap-3 px-10 py-4 btn-primary text-white text-lg font-bold rounded-2xl shadow-2xl">
                Ver Todos os Imóveis <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categorias -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Buscar por Categoria
            </h2>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                Encontre exatamente o que você procura
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($tipos as $tipo)
                <a href="{{ route('imoveis.index', ['tipo_id' => $tipo->id]) }}" 
                   class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl text-center hover:bg-white/20 transition-all group hover:-translate-y-2 border border-white/20">
                    <i class="fas fa-home text-5xl mb-4 group-hover:scale-110 transition-transform"></i>
                    <p class="font-bold text-lg">{{ $tipo->nome }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Banners Sidebar -->
<!-- Debug: {{ $bannersSidebar->count() }} banners encontrados -->
@if($bannersSidebar->count() > 0)
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <div class="inline-block px-4 py-2 bg-blue-100 rounded-full mb-4">
                <span class="text-blue-800 font-semibold text-sm"><i class="fas fa-star mr-1"></i> DESTAQUES</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Ofertas Especiais
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Confira nossas promoções e oportunidades únicas
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($bannersSidebar as $banner)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-2">
                    @if($banner->link)
                        <a href="{{ $banner->link }}" class="block">
                    @endif
                    <div class="relative">
                        <img src="{{ asset('storage/' . $banner->imagem) }}" 
                             alt="{{ $banner->titulo }}" 
                             class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                OFERTA
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $banner->titulo }}</h3>
                        @if($banner->descricao)
                            <p class="text-gray-600 mb-4">{{ $banner->descricao }}</p>
                        @endif
                        @if($banner->link)
                            <span class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                                Saiba mais <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        @endif
                    </div>
                    @if($banner->link)
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Final -->
<section class="py-24 bg-gradient-to-br from-gray-900 to-gray-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-4xl md:text-6xl font-bold mb-6">
            Não encontrou o que procura?
        </h2>
        <p class="text-2xl mb-10 text-white/90 max-w-3xl mx-auto">
            Nossa equipe especializada está pronta para te ajudar a encontrar o imóvel ideal!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contato') }}" 
               class="inline-flex items-center gap-3 px-10 py-5 bg-white text-gray-900 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all shadow-2xl">
                <i class="fas fa-envelope"></i> Fale Conosco
            </a>
            <a href="https://wa.me/5511999999999" 
               target="_blank"
               class="inline-flex items-center gap-3 px-10 py-5 bg-green-500 text-white rounded-2xl font-bold text-lg hover:bg-green-600 transition-all shadow-2xl">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- JavaScript para Carrossel de Banners -->
@if($bannersHero->count() > 1)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const contents = document.querySelectorAll('.hero-content');
    const indicators = document.querySelectorAll('.hero-indicator');
    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    function showSlide(index) {
        // Remover classe active de todos os slides
        slides.forEach(slide => slide.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('bg-white'));
        indicators.forEach(indicator => indicator.classList.remove('border-2'));
        indicators.forEach(indicator => indicator.classList.remove('border-blue-900'));
        
        // Adicionar classe active ao slide atual
        slides[index].classList.add('active');
        contents[index].classList.add('active');
        indicators[index].classList.add('bg-blue-600');
        indicators[index].classList.add('border-2');
        indicators[index].classList.add('border-blue-900');
        indicators[index].classList.remove('bg-blue-600/50');
        
        // Atualizar indicadores
        indicators.forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('bg-blue-600');
                indicator.classList.remove('bg-blue-600/50');
            } else {
                indicator.classList.remove('bg-blue-600');
                indicator.classList.add('bg-blue-600/50');
            }
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }
    
    // Event listeners para botões
    if (nextBtn) {
        nextBtn.addEventListener('click', nextSlide);
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', prevSlide);
    }
    
    // Event listeners para indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Auto-play (opcional - descomente se quiser)
    // setInterval(nextSlide, 5000);
    
    // Suporte a teclado
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            prevSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        }
    });
    
    // Suporte a touch/swipe
    let startX = 0;
    let endX = 0;
    
    const heroSection = document.querySelector('.hero-carousel');
    
    if (heroSection) {
        heroSection.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });
        
        heroSection.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });
    }
    
    function handleSwipe() {
        const threshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                nextSlide(); // Swipe left - next slide
            } else {
                prevSlide(); // Swipe right - previous slide
            }
        }
    }
});
</script>

<style>
.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
}

.hero-slide.active {
    opacity: 1;
}

.hero-content {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s ease-in-out;
}

.hero-content.active {
    opacity: 1;
    transform: translateY(0);
}

.hero-nav {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-nav:hover {
    transform: translateY(-50%) scale(1.1);
}

.hero-indicator {
    cursor: pointer;
    transition: all 0.3s ease;
}

.hero-indicator:hover {
    transform: scale(1.2);
}
</style>
@endif
@endsection
