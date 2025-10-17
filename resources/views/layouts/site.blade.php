<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Sistema Imobiliária')</title>
    <meta name="description" content="@yield('description', 'Encontre o imóvel dos seus sonhos. Apartamentos, casas, terrenos e muito mais.')">
    <meta name="keywords" content="@yield('keywords', 'imóveis, apartamentos, casas, terrenos, aluguel, venda, imobiliária')">
    <meta name="author" content="Sistema Imobiliária">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Sistema Imobiliária')">
    <meta property="og:description" content="@yield('description', 'Encontre o imóvel dos seus sonhos. Apartamentos, casas, terrenos e muito mais.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="Sistema Imobiliária">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Sistema Imobiliária')">
    <meta property="twitter:description" content="@yield('description', 'Encontre o imóvel dos seus sonhos. Apartamentos, casas, terrenos e muito mais.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }
        
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-sm shadow-lg sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                    <div class="">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            ImobiJoaçaba
                        </span>
                        <p class="text-xs text-gray-500 font-medium">Prime Imóveis</p>
                    </div>
                </a>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors relative group">
                        Início
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('imoveis.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors relative group">
                        Imóveis
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors relative group">
                        Blog
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('contato') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors relative group">
                        Contato
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isCorretor())
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                <i class="fas fa-cog mr-1"></i> Admin
                            </a>
                        @endif
                    @endauth
                </nav>

                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                            Entrar
                        </a>
                    @else
                        <div class="flex items-center space-x-3">
                            <span class="text-gray-700 font-medium">Olá, {{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition-colors">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 container mx-auto">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 container mx-auto">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 mt-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Imobiliária Prime</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Sua imobiliária de confiança. Encontre o imóvel dos seus sonhos com segurança e qualidade.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Links Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-chevron-right text-xs mr-2"></i> Home</a></li>
                        <li><a href="{{ route('imoveis.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-chevron-right text-xs mr-2"></i> Imóveis</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-chevron-right text-xs mr-2"></i> Blog</a></li>
                        <li><a href="{{ route('contato') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-chevron-right text-xs mr-2"></i> Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Contato</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-3 text-blue-400"></i>
                            <span>(11) 9999-9999</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-blue-400"></i>
                            <span>contato@imobiliaria.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-400"></i>
                            <span>Av. Paulista, 1000<br>São Paulo, SP</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Redes Sociais</h3>
                    <p class="text-gray-400 mb-4">Siga-nos nas redes sociais</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-pink-600 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-green-600 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Imobiliária Prime. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

