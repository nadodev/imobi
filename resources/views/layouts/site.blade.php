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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary-color: #0f172a;
            --accent-color: #f59e0b;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--bg-secondary);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }
        
        .gradient-blue {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .hover-scale {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-xl);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.3);
        }
        
        .feature-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(8deg);
        }
        
        .fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(40px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .section-padding {
            padding: 5rem 0;
        }

        .container-custom {
            max-width: 1650px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-modern {
            background: var(--bg-primary);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-modern:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-8px);
            border-color: rgba(30, 64, 175, 0.2);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .hero-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(30, 64, 175, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
        }

        /* Header specific styles */
        .header-logo-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .header-logo-card:hover {
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(59, 130, 246, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .nav-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        /* Floating animation for logo badge */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }

        .floating-badge {
            animation: float 3s ease-in-out infinite;
        }

        /* Glow effect for logo */
        .logo-glow {
            filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.3));
        }

        /* Top bar gradient animation */
        .top-bar-gradient {
            background: linear-gradient(-45deg, #2563eb, #1d4ed8, #1e40af, #1e3a8a);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Sticky Header Styles */
        #sticky-header {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sticky-header .nav-container {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Smooth transitions for sticky header */
        #sticky-header {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced shadow for sticky header */
        #sticky-header.show {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Chat Widget Styles */
        #chat-widget {
            z-index: 9999;
            max-height: 80vh;
            transform: translateY(100%);
        }

        #chat-widget.translate-y-full {
            transform: translateY(100%);
        }

        #chat-widget:not(.translate-y-full) {
            transform: translateY(0);
        }

        /* Chat Widget Animation */
        #chat-widget {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Chat Messages Scrollbar */
        #chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }

        #chat-messages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Chat Button Hover Effects */
        #chat-toggle:hover {
            transform: scale(1.05);
        }

        #chat-toggle:active {
            transform: scale(0.95);
        }

        /* Mobile Sidebar Styles */
        #mobile-sidebar {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #mobile-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #mobile-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #mobile-sidebar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }

        #mobile-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }

        /* Smooth transitions for mobile menu button */
        #mobile-menu-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mobile-menu-button:hover {
            transform: scale(1.05);
        }

        /* Sidebar link animations */
        #mobile-sidebar a {
            position: relative;
            overflow: hidden;
        }

        #mobile-sidebar a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s;
        }

        #mobile-sidebar a:hover::before {
            left: 100%;
        }

        /* Overlay animation */
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }

        /* Responsive Header Adjustments */
        @media (max-width: 1300px) {
            .container-nav-logo {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .container-nav-logo > * {
                width: 100%;
                max-width: none;
            }
            
            .nav-container {
                justify-content: center;
            }
            
            .nav-container .flex {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        @media (max-width: 1024px) {
            .container-nav-logo {
                gap: 1rem;
            }
            
            .header-logo-card {
                padding: 1rem !important;
            }
            
            .nav-container {
                padding: 0.75rem 1rem !important;
            }
        }

        @media (max-width: 768px) {
            .container-nav-logo {
                gap: 0.75rem;
            }
            
            .header-logo-card {
                padding: 0.75rem !important;
            }
            
            .nav-container {
                padding: 0.5rem 0.75rem !important;
            }
            
            .nav-container .flex {
                gap: 0.25rem;
            }
        }

       @media (max-width: 1100px) {
        .container-nav-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column-reverse;
            gap: 1rem;
        }
       }

    </style>
</head>
<body class="bg-slate-50 hero-pattern">
    <!-- Header -->
    <header class="relative">
        <!-- Background with subtle pattern -->
        <div class="absolute inset-0 bg-gradient-to-r from-white via-blue-50/30 to-white"></div>
        <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,<svg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"%23e0e7ff\" fill-opacity=\"0.3\"><circle cx=\"20\" cy=\"20\" r=\"1\"/></g></svg>');"></div>
        
        <div class="relative z-10">
            <!-- Top Bar -->
            <div class="top-bar-gradient text-white py-2">
                <div class="container-custom">
                    <div class="flex flex-col sm:flex-row justify-between items-center text-sm space-y-2 sm:space-y-0">
                        <!-- Contact Info -->
                        <div class="flex flex-col sm:flex-row items-center space-y-1 sm:space-y-0 sm:space-x-6">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-blue-200"></i>
                                <span class="font-medium text-xs sm:text-sm">(49) 3522-1234</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-blue-200"></i>
                                <span class="font-medium text-xs sm:text-sm hidden sm:inline">contato@imobijoaçaba.com</span>
                                <span class="font-medium text-xs sm:hidden">contato@imobi.com</span>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="flex items-center space-x-3">
                            <span class="text-blue-200 text-xs sm:text-sm hidden sm:inline">Siga-nos:</span>
                            <span class="text-blue-200 text-xs sm:hidden">Redes:</span>
                            <div class="flex space-x-2">
                                <a href="#" class="w-6 h-6 bg-blue-500 hover:bg-white hover:text-blue-600 rounded-full flex items-center justify-center transition-all duration-300 group" title="Facebook">
                                    <i class="fab fa-facebook text-xs group-hover:scale-110 transition-transform"></i>
                                </a>
                                <a href="#" class="w-6 h-6 bg-blue-500 hover:bg-white hover:text-blue-600 rounded-full flex items-center justify-center transition-all duration-300 group" title="Instagram">
                                    <i class="fab fa-instagram text-xs group-hover:scale-110 transition-transform"></i>
                                </a>
                                <a href="#" class="w-6 h-6 bg-blue-500 hover:bg-white hover:text-blue-600 rounded-full flex items-center justify-center transition-all duration-300 group" title="WhatsApp">
                                    <i class="fab fa-whatsapp text-xs group-hover:scale-110 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="container-custom">
                <div class="flex flex-col xl:flex-row justify-between items-center py-8 xl:py-12 space-y-6 xl:space-y-0 container-nav-logo">
                    <!-- Logo Card -->
                    <div class="relative group w-full xl:w-auto">
                        <!-- Floating Card Background -->
                        <div class="absolute -inset-2 xl:-inset-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl xl:rounded-3xl blur-lg opacity-20 group-hover:opacity-30 transition-all duration-500"></div>
                        
                        <!-- Main Logo Card -->
                        <a href="{{ route('home') }}" class="relative block">
                            <div class="header-logo-card rounded-2xl xl:rounded-3xl p-4 xl:p-8 shadow-2xl border border-gray-100 group-hover:shadow-3xl transition-all duration-500 transform group-hover:-translate-y-2">
                                <div class="flex items-center space-x-3 xl:space-x-6">
                                    <!-- Logo Icon -->
                                    <div class="relative">
                                        <div class="w-12 h-12 xl:w-16 xl:h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl xl:rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                                            <i class="fas fa-building text-white text-lg xl:text-2xl"></i>
                                        </div>
                                        <!-- Floating Badge -->
                                        <div class="absolute -top-1 -right-1 xl:-top-2 xl:-right-2 w-6 h-6 xl:w-8 xl:h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg floating-badge">
                                            <i class="fas fa-star text-white text-xs xl:text-sm"></i>
                                        </div>
                                        <!-- Glow Effect -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl blur-md opacity-0 group-hover:opacity-30 transition-all duration-300"></div>
                                    </div>
                                    
                                    <!-- Company Info -->
                                    <div class="group-hover:translate-x-1 transition-transform duration-300">
                                        <h1 class="text-xl xl:text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">
                                            ImobiJoaçaba
                                        </h1>
                                        <p class="text-xs xl:text-sm text-gray-600 font-semibold">Prime Imóveis</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-yellow-400 text-xs">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="text-xs text-gray-500 ml-2 hidden sm:inline">5.0 (127 avaliações)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center w-full xl:w-auto">
                        <!-- Navigation Menu Container -->
                        <div class="nav-container rounded-2xl px-4 xl:px-8 py-3 xl:py-4 shadow-lg border border-gray-200/50 w-full xl:w-auto">
                            <div class="flex items-center justify-center xl:justify-start space-x-1 xl:space-x-2 flex-wrap">
                                <a href="{{ route('home') }}" class="nav-link px-3 xl:px-5 py-2 xl:py-3 text-gray-700 hover:text-blue-600 font-semibold transition-all duration-300 rounded-xl hover:bg-blue-50/80 group relative text-sm xl:text-base">
                                    <i class="fas fa-home mr-1 xl:mr-2 group-hover:scale-110 transition-transform"></i>Início
                                </a>
                                <a href="{{ route('imoveis.index') }}" class="nav-link px-3 xl:px-5 py-2 xl:py-3 text-gray-700 hover:text-blue-600 font-semibold transition-all duration-300 rounded-xl hover:bg-blue-50/80 group relative text-sm xl:text-base">
                                    <i class="fas fa-building mr-1 xl:mr-2 group-hover:scale-110 transition-transform"></i>Imóveis
                                </a>
                                <a href="{{ route('sobre.index') }}" class="nav-link px-3 xl:px-5 py-2 xl:py-3 text-gray-700 hover:text-blue-600 font-semibold transition-all duration-300 rounded-xl hover:bg-blue-50/80 group relative text-sm xl:text-base">
                                    <i class="fas fa-info-circle mr-1 xl:mr-2 group-hover:scale-110 transition-transform"></i>Sobre
                                </a>
                                <a href="{{ route('blog.index') }}" class="nav-link px-3 xl:px-5 py-2 xl:py-3 text-gray-700 hover:text-blue-600 font-semibold transition-all duration-300 rounded-xl hover:bg-blue-50/80 group relative text-sm xl:text-base">
                                    <i class="fas fa-newspaper mr-1 xl:mr-2 group-hover:scale-110 transition-transform"></i>Blog
                                </a>
                                <a href="{{ route('contato') }}" class="nav-link px-3 xl:px-5 py-2 xl:py-3 text-gray-700 hover:text-blue-600 font-semibold transition-all duration-300 rounded-xl hover:bg-blue-50/80 group relative text-sm xl:text-base">
                                    <i class="fas fa-envelope mr-1 xl:mr-2 group-hover:scale-110 transition-transform"></i>Contato
                                </a>
                                
                                @auth
                                    @if(auth()->user()->isAdmin() || auth()->user()->isCorretor())
                                        <div class="ml-4 pl-4 border-l border-gray-200">
                                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                                <i class="fas fa-cog mr-2"></i>Admin
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </nav>

                    <!-- Desktop Auth Section -->
                    <div class="hidden lg:flex items-center w-full xl:w-auto justify-center xl:justify-end">
                        @guest
                            <div class="bg-white/80 backdrop-blur-md rounded-2xl px-6 py-3 shadow-lg border border-gray-200/50">
                                <a href="{{ route('login') }}" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                                </a>
                            </div>
                        @else
                            <div class="bg-white/90 backdrop-blur-md rounded-2xl px-4 xl:px-6 py-3 xl:py-4 shadow-lg border border-gray-200/50 w-full xl:w-auto">
                                <div class="flex items-center space-x-2 xl:space-x-4 justify-center xl:justify-start">
                                    <!-- User Info -->
                                    <div class="flex items-center space-x-2 xl:space-x-4 px-3 xl:px-4 py-2 xl:py-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                                        <div class="w-8 h-8 xl:w-9 xl:h-9 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-user text-white text-xs xl:text-sm"></i>
                                        </div>
                                        <div class="hidden sm:block">
                                            <p class="text-gray-800 font-semibold text-xs xl:text-sm truncate max-w-20 xl:max-w-24">{{ auth()->user()->name }}</p>
                                            <p class="text-gray-500 text-xs">Cliente</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-2 xl:space-x-3">
                                        <a href="{{ route('admin.cliente.dashboard') }}" 
                                           class="p-2 xl:p-2.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 group" 
                                           title="Minha Conta">
                                            <i class="fas fa-user-cog text-xs xl:text-sm group-hover:scale-110 transition-transform"></i>
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-2 xl:p-2.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 group" 
                                                    title="Sair">
                                                <i class="fas fa-sign-out-alt text-xs xl:text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="lg:hidden">
                        <button id="mobile-menu-button" class="bg-white/80 backdrop-blur-md rounded-2xl p-4 xl:p-5 shadow-lg border border-gray-200/50 text-gray-700 hover:text-blue-600 hover:bg-blue-50/80 transition-all duration-300">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky Header (appears on scroll) -->
    <header id="sticky-header" class="fixed top-0 left-0 right-0 z-50 transform -translate-y-full transition-transform duration-300 ease-in-out">
        <div class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-200/50">
            <div class="container-custom">
            <div class="flex justify-between items-center py-4">
                    <!-- Compact Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-md">
                            <i class="fas fa-building text-white text-lg"></i>
                    </div>
                        <div class="group-hover:translate-x-1 transition-transform duration-300">
                            <span class="text-xl font-bold gradient-text">ImobiJoaçaba</span>
                        <p class="text-xs text-gray-500 font-medium">Prime Imóveis</p>
                    </div>
                </a>
                
                    <!-- Compact Navigation -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <div class="bg-white/80 backdrop-blur-md rounded-xl px-4 py-2 shadow-md border border-gray-200/50">
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('home') }}" class="nav-link px-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50/80 group">
                                    <i class="fas fa-home mr-1 group-hover:scale-110 transition-transform"></i>Início
                                </a>
                                <a href="{{ route('imoveis.index') }}" class="nav-link px-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50/80 group">
                                    <i class="fas fa-building mr-1 group-hover:scale-110 transition-transform"></i>Imóveis
                                </a>
                                <a href="{{ route('sobre.index') }}" class="nav-link px-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50/80 group">
                                    <i class="fas fa-info-circle mr-1 group-hover:scale-110 transition-transform"></i>Sobre
                                </a>
                                <a href="{{ route('blog.index') }}" class="nav-link px-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50/80 group">
                                    <i class="fas fa-newspaper mr-1 group-hover:scale-110 transition-transform"></i>Blog
                                </a>
                                <a href="{{ route('contato') }}" class="nav-link px-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50/80 group">
                                    <i class="fas fa-envelope mr-1 group-hover:scale-110 transition-transform"></i>Contato
                                </a>
                                
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isCorretor())
                                        <div class="ml-3 pl-3 border-l border-gray-200">
                                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                                <i class="fas fa-cog mr-1"></i>Admin
                            </a>
                                        </div>
                        @endif
                    @endauth
                            </div>
                        </div>
                </nav>

                    <!-- Compact Auth Section -->
                    <div class="hidden md:flex items-center">
                    @guest
                            <a href="{{ route('login') }}" class="btn-primary px-4 py-2 rounded-lg text-white font-medium shadow-md hover:shadow-lg">
                                <i class="fas fa-sign-in-alt mr-1"></i>Entrar
                        </a>
                    @else
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-2 px-2 py-1.5 bg-gray-50 rounded-lg">
                                <div class="w-7 h-7 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 font-medium text-xs hidden sm:block truncate max-w-20">{{ auth()->user()->name }}</span>
                            </div>
                            <a href="{{ route('admin.cliente.dashboard') }}" 
                               class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-300" 
                               title="Minha Conta">
                                <i class="fas fa-user-cog text-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300" 
                                        title="Sair">
                                    <i class="fas fa-sign-out-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button id="sticky-mobile-menu-button" class="bg-white/80 backdrop-blur-md rounded-lg p-2 shadow-md border border-gray-200/50 text-gray-700 hover:text-blue-600 hover:bg-blue-50/80 transition-all duration-300">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center">
                    <i class="fas fa-home text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        ImobiJoaçaba
                    </span>
                    <p class="text-xs text-gray-500 font-medium">Prime Imóveis</p>
                </div>
            </div>
            <button id="close-sidebar" class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="p-6">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                        <i class="fas fa-home w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Início</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('imoveis.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                        <i class="fas fa-building w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Imóveis</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sobre.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                        <i class="fas fa-info-circle w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Sobre</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                        <i class="fas fa-newspaper w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Blog</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contato') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                        <i class="fas fa-envelope w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Contato</span>
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isCorretor())
                        <li class="pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-blue-600 hover:bg-blue-50 transition-all duration-300 group">
                                <i class="fas fa-cog w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Painel Admin</span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>

        <!-- Sidebar Auth Section -->
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 bg-gray-50">
            @guest
                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Entrar
                </a>
            @else
                <div class="space-y-3">
                    <div class="flex items-center px-4 py-3 bg-white rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">Usuário logado</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-6 py-3 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-100 transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Sair
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

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
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"2\"/></g></svg>');"></div>
        </div>
        
        <div class="container-custom relative z-10">
            <div class="py-20">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <!-- Company Info -->
                    <div class="md:col-span-1">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative">
                                <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center shadow-xl">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-white text-xs"></i>
                                </div>
                            </div>
                <div>
                                <span class="text-2xl font-bold gradient-text">ImobiJoaçaba</span>
                                <p class="text-sm text-gray-400 font-medium">Prime Imóveis</p>
                        </div>
                    </div>
                        <p class="text-gray-300 leading-relaxed text-lg mb-6">Sua imobiliária de confiança. Encontre o imóvel dos seus sonhos com segurança, qualidade e excelência no atendimento.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-slate-700 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg">
                                <i class="fab fa-facebook text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-slate-700 hover:bg-pink-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-slate-700 hover:bg-green-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                </div>
                    </div>

                    <!-- Quick Links -->
                <div>
                        <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                            <i class="fas fa-link mr-3 text-blue-400"></i>Links Rápidos
                        </h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-3 text-blue-400 group-hover:translate-x-1 transition-transform"></i> Início
                            </a></li>
                            <li><a href="{{ route('imoveis.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-3 text-blue-400 group-hover:translate-x-1 transition-transform"></i> Imóveis
                            </a></li>
                            <li><a href="{{ route('sobre.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-3 text-blue-400 group-hover:translate-x-1 transition-transform"></i> Sobre
                            </a></li>
                            <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-3 text-blue-400 group-hover:translate-x-1 transition-transform"></i> Blog
                            </a></li>
                            <li><a href="{{ route('contato') }}" class="text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-3 text-blue-400 group-hover:translate-x-1 transition-transform"></i> Contato
                            </a></li>
                    </ul>
                </div>

                    <!-- Contact Info -->
                <div>
                        <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-400"></i>Contato
                        </h3>
                        <ul class="space-y-4 text-gray-300">
                            <li class="flex items-start group">
                                <i class="fas fa-phone mt-1 mr-4 text-blue-400 group-hover:scale-110 transition-transform"></i>
                <div>
                                    <span class="block font-medium">(49) 3522-1234</span>
                                    <span class="text-sm text-gray-400">WhatsApp: (49) 99999-9999</span>
                                </div>
                        </li>
                            <li class="flex items-start group">
                                <i class="fas fa-envelope mt-1 mr-4 text-blue-400 group-hover:scale-110 transition-transform"></i>
                                <div>
                                    <span class="block font-medium">contato@imobijoaçaba.com</span>
                                    <span class="text-sm text-gray-400">vendas@imobijoaçaba.com</span>
                                </div>
                        </li>
                            <li class="flex items-start group">
                                <i class="fas fa-map-marker-alt mt-1 mr-4 text-blue-400 group-hover:scale-110 transition-transform"></i>
                                <div>
                                    <span class="block font-medium">Rua XV de Novembro, 123</span>
                                    <span class="text-sm text-gray-400">Centro - Joaçaba, SC</span>
                                </div>
                        </li>
                    </ul>
                </div>

                    <!-- Newsletter -->
                <div>
                        <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-400"></i>Newsletter
                        </h3>
                        <p class="text-gray-300 mb-4">Receba as melhores ofertas e novidades em seu e-mail.</p>
                        <form id="newsletter-form" class="space-y-3">
                            @csrf
                            <input type="email" 
                                   id="newsletter-email"
                                   name="email"
                                   placeholder="Seu e-mail" 
                                   class="w-full px-4 py-3 rounded-xl bg-slate-700 text-white placeholder-gray-400 border border-slate-600 focus:border-blue-500 focus:outline-none transition-colors"
                                   required>
                            <button type="submit" class="w-full btn-primary px-4 py-3 rounded-xl text-white font-semibold">
                                <i class="fas fa-paper-plane mr-2"></i>Inscrever-se
                            </button>
                        </form>
                        <div id="newsletter-message" class="mt-3 text-sm hidden"></div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-slate-700 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-gray-400">&copy; {{ date('Y') }} ImobiJoaçaba - Prime Imóveis. Todos os direitos reservados.</p>
                        <div class="flex space-x-6 text-sm">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Política de Privacidade</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Termos de Uso</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookies</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Chat and WhatsApp Icons -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-4">
        <!-- WhatsApp Icon -->
        <a href="https://wa.me/5549999999999?text=Olá! Gostaria de saber mais sobre os imóveis disponíveis." 
           target="_blank" 
           class="group relative">
            <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 animate-pulse">
                <i class="fab fa-whatsapp text-white text-2xl"></i>
            </div>
            <!-- Tooltip -->
            <div class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Fale conosco no WhatsApp
                <div class="absolute right-0 top-1/2 transform translate-x-1 -translate-y-1/2 w-0 h-0 border-l-4 border-l-gray-900 border-t-4 border-t-transparent border-b-4 border-b-transparent"></div>
            </div>
        </a>

        <!-- Chat Icon -->
        <button id="chat-toggle" 
                class="group relative">
            <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
                <i class="fas fa-comments text-white text-2xl"></i>
            </div>
            <!-- Notification Badge -->
            <div id="chat-notification" class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold opacity-0 transition-opacity duration-300">
                <span id="chat-notification-count">0</span>
            </div>
            <!-- Tooltip -->
            <div class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Chat Online
                <div class="absolute right-0 top-1/2 transform translate-x-1 -translate-y-1/2 w-0 h-0 border-l-4 border-l-gray-900 border-t-4 border-t-transparent border-b-4 border-b-transparent"></div>
            </div>
        </button>
    </div>

    <!-- Chat Widget -->
    <div id="chat-widget" class="fixed bottom-24 right-6 z-50 w-80 bg-white rounded-2xl shadow-2xl transform translate-y-full transition-transform duration-300 ease-in-out" style="display: none;">
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-comments text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Chat Online</h3>
                        <p class="text-sm text-blue-100">Estamos online agora</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="chat-clear-history" class="text-white hover:text-blue-200 transition-colors" title="Limpar histórico">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                    <button id="chat-close" class="text-white hover:text-blue-200 transition-colors" title="Fechar chat">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Form (Initial) -->
        <div id="chat-form" class="p-4">
            <div class="text-center mb-4">
                <h4 class="font-semibold text-gray-800 mb-2">Inicie uma conversa</h4>
                <p class="text-sm text-gray-600">Preencha seus dados para começar</p>
            </div>
            
            <!-- Login/Register Form (for non-authenticated users) -->
            <div id="chat-auth-form" class="space-y-3">
                <div class="text-center mb-4">
                    <p class="text-sm text-gray-600 mb-3">Para iniciar uma conversa, você precisa estar logado</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('login') }}" 
                       class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-2 px-4 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-medium text-center block">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Fazer Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-2 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 font-medium text-center block">
                        <i class="fas fa-user-plus mr-2"></i>
                        Criar Conta
                        </a>
                    </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">Ou continue como visitante</p>
                    <button type="button" id="chat-continue-guest" 
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-1">
                        Continuar sem login
                    </button>
                </div>
            </div>

            <!-- Guest Form (for non-authenticated users who choose to continue) -->
            <form id="chat-start-form" class="space-y-3 hidden">
                <div>
                    <input type="text" id="chat-nome" placeholder="Seu nome" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
                <div>
                    <input type="email" id="chat-email" placeholder="Seu email (opcional)" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
                <div>
                    <input type="tel" id="chat-telefone" placeholder="Seu telefone (opcional)" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-2 px-4 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-medium">
                    Iniciar Conversa
                </button>
            </form>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="hidden h-80 overflow-y-auto p-4 space-y-3">
            <!-- Messages will be loaded here -->
        </div>

        <!-- Chat Input -->
        <div id="chat-input" class="hidden p-4 border-t border-gray-200">
            <form id="chat-message-form" class="flex space-x-2">
                <input type="text" id="chat-message-input" placeholder="Digite sua mensagem..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" 
                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <!-- Chat Status -->
        <div id="chat-status" class="hidden p-3 bg-gray-50 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">
                <i class="fas fa-circle text-green-500 mr-2"></i>
                Conectado - Aguardando resposta
            </p>
        </div>
    </div>

    @yield('scripts')

    <!-- Mobile Sidebar JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const closeSidebarButton = document.getElementById('close-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Open sidebar
            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('sidebar-open');
            });

            // Close sidebar
            function closeSidebar() {
                mobileSidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }

            closeSidebarButton.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            // Close sidebar when clicking on navigation links
            const sidebarLinks = mobileSidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', closeSidebar);
            });

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileSidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) { // md breakpoint
                    closeSidebar();
                }
            });

            // Sticky header functionality
            const stickyHeader = document.getElementById('sticky-header');
            const stickyMobileMenuButton = document.getElementById('sticky-mobile-menu-button');
            let lastScrollTop = 0;
            let ticking = false;

            // Add click event to sticky mobile menu button
            if (stickyMobileMenuButton) {
                stickyMobileMenuButton.addEventListener('click', function() {
                    mobileSidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                    document.body.classList.add('sidebar-open');
                });
            }

            function updateStickyHeader() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop < 200) { // Show sticky header after scrolling 200px
                    stickyHeader.classList.add('-translate-y-full');
                  
                } else {
                    // At top of page - hide sticky header
                    stickyHeader.classList.remove('-translate-y-full');
                }
                
                lastScrollTop = scrollTop;
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateStickyHeader);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick, { passive: true });

            // Chat functionality
            const chatToggle = document.getElementById('chat-toggle');
            const chatWidget = document.getElementById('chat-widget');
            const chatClose = document.getElementById('chat-close');
            const chatForm = document.getElementById('chat-form');
            const chatMessages = document.getElementById('chat-messages');

            // Function to handle CSRF token refresh
            function refreshCSRFToken() {
                return fetch('/csrf-token', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.csrf_token) {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    }
                    return data.csrf_token;
                })
                .catch(error => {
                    console.error('Erro ao atualizar token CSRF:', error);
                    return null;
                });
            }

            // Function to clear invalid data from localStorage
            function limparDadosInvalidos() {
                const conversaId = localStorage.getItem('chat_conversa_id');
                if (conversaId) {
                    // Verificar se a conversa ainda existe
                    fetch(`{{ route("chat.mensagens") }}?conversa_id=${conversaId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success || data.message.includes('invalid')) {
                            // Limpar dados inválidos
                            localStorage.removeItem('chat_conversa_id');
                            localStorage.removeItem('chat_nome_cliente');
                            localStorage.removeItem('chat_email_cliente');
                            localStorage.removeItem('chat_telefone_cliente');
                            console.log('Dados inválidos do chat removidos do localStorage');
                        }
                    })
                    .catch(error => {
                        // Em caso de erro, limpar tudo
                        localStorage.removeItem('chat_conversa_id');
                        localStorage.removeItem('chat_nome_cliente');
                        localStorage.removeItem('chat_email_cliente');
                        localStorage.removeItem('chat_telefone_cliente');
                        console.log('Dados do chat removidos do localStorage devido a erro');
                    });
                }
            }
            const chatInput = document.getElementById('chat-input');
            const chatStatus = document.getElementById('chat-status');
            const chatStartForm = document.getElementById('chat-start-form');
            const chatMessageForm = document.getElementById('chat-message-form');
            const chatNotification = document.getElementById('chat-notification');
            const chatNotificationCount = document.getElementById('chat-notification-count');

            let conversaId = null;
            let ultimaMensagemId = null;
            let chatInterval = null;

            // Chat toggle function
            function toggleChat() {
                console.log('Toggle chat called');
                if (chatWidget) {
                    if (chatWidget.style.display === 'none' || chatWidget.classList.contains('translate-y-full')) {
                        // Opening chat
                        chatWidget.style.display = 'block';
                        chatWidget.classList.remove('translate-y-full');
                        console.log('Chat opened');
                        
                        // Verificar se usuário está autenticado
                        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                        
                        if (isAuthenticated) {
                            // Usuário autenticado - verificar conversa existente
                            verificarConversaExistente();
                            
                            if (conversaId) {
                                carregarMensagens();
                                iniciarVerificacaoMensagens();
                            } else {
                                // Mostrar formulário de conversa para usuário autenticado
                                mostrarFormularioConversa();
                            }
                        } else {
                            // Usuário não autenticado - mostrar opções de login/registro
                            mostrarFormularioAutenticacao();
                        }
                    }
                } else {
                    console.error('Chat widget not found');
                }
            }

            // Função para fechar chat (apenas quando clicar no X)
            function fecharChat() {
                if (chatWidget) {
                    chatWidget.classList.add('translate-y-full');
                    setTimeout(() => {
                        chatWidget.style.display = 'none';
                    }, 300);
                    console.log('Chat closed');
                    pararVerificacaoMensagens();
                }
            }

            // Mostrar formulário de autenticação para usuários não logados
            function mostrarFormularioAutenticacao() {
                const chatAuthForm = document.getElementById('chat-auth-form');
                const chatStartForm = document.getElementById('chat-start-form');
                
                if (chatAuthForm) chatAuthForm.classList.remove('hidden');
                if (chatStartForm) chatStartForm.classList.add('hidden');
            }

            // Mostrar formulário de conversa para usuários autenticados
            function mostrarFormularioConversa() {
                const chatAuthForm = document.getElementById('chat-auth-form');
                const chatStartForm = document.getElementById('chat-start-form');
                
                if (chatAuthForm) chatAuthForm.classList.add('hidden');
                if (chatStartForm) chatStartForm.classList.remove('hidden');
            }

            // Check if elements exist before adding event listeners
            if (chatToggle && chatWidget) {
                // Toggle chat widget
                chatToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Chat toggle clicked'); // Debug
                    toggleChat();
                });
            } else {
                console.error('Chat elements not found:', {
                    chatToggle: !!chatToggle,
                    chatWidget: !!chatWidget
                });
            }

            // Close chat widget
            if (chatClose) {
                chatClose.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fecharChat();
                });
            }

            // Clear chat history
            const chatClearHistory = document.getElementById('chat-clear-history');
            if (chatClearHistory) {
                chatClearHistory.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (confirm('Tem certeza que deseja limpar o histórico do chat? Esta ação não pode ser desfeita.')) {
                        // Limpar localStorage
                        localStorage.removeItem('chat_conversa_id');
                        localStorage.removeItem('chat_nome_cliente');
                        localStorage.removeItem('chat_email_cliente');
                        localStorage.removeItem('chat_telefone_cliente');
                        
                        // Resetar variáveis
                        conversaId = null;
                        ultimaMensagemId = null;
                        
                        // Parar verificação de mensagens
                        pararVerificacaoMensagens();
                        
                        // Mostrar formulário inicial
                        chatForm.classList.remove('hidden');
                        chatMessages.classList.add('hidden');
                        chatInput.classList.add('hidden');
                        chatStatus.classList.add('hidden');
                        
                        // Limpar campos do formulário
                        document.getElementById('chat-nome').value = '';
                        document.getElementById('chat-email').value = '';
                        document.getElementById('chat-telefone').value = '';
                        
                        // Limpar mensagens do container
                        const messagesContainer = document.getElementById('chat-messages');
                        if (messagesContainer) {
                            messagesContainer.innerHTML = '';
                        }
                        
                        console.log('Histórico do chat limpo');
                    }
                });
            }

            // Continue as guest button
            const chatContinueGuest = document.getElementById('chat-continue-guest');
            if (chatContinueGuest) {
                chatContinueGuest.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    mostrarFormularioConversa();
                });
            }

            // Start conversation
            if (chatStartForm) {
                chatStartForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const nome = document.getElementById('chat-nome').value;
                const email = document.getElementById('chat-email').value;
                const telefone = document.getElementById('chat-telefone').value;

                if (!nome.trim()) {
                    alert('Por favor, informe seu nome');
                    return;
                }

                fetch('{{ route("chat.iniciar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        nome: nome,
                        email: email,
                        telefone: telefone
                    })
                })
                .then(response => {
                    if (response.status === 419) {
                        // CSRF token expired, refresh and retry
                        return refreshCSRFToken().then(() => {
                            return fetch('{{ route("chat.iniciar") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    nome: nome,
                                    email: email,
                                    telefone: telefone
                                })
                            });
                        });
                    }
                    return response;
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        conversaId = data.conversa_id;
                        salvarConversa(conversaId);
                        mostrarChat();
                        carregarMensagens();
                        iniciarVerificacaoMensagens();
                    }
                })
                .catch(error => {
                    console.error('Erro ao iniciar conversa:', error);
                    alert('Erro ao iniciar conversa. Tente novamente.');
                });
            })}

            // Send message
            if (chatMessageForm) {
                chatMessageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const mensagemInput = document.getElementById('chat-message-input');
                const mensagem = mensagemInput.value.trim();

                if (!mensagem) return;

                fetch('{{ route("chat.enviar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        conversa_id: conversaId,
                        mensagem: mensagem
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mensagemInput.value = '';
                        adicionarMensagem(data.mensagem.mensagem, 'cliente', data.timestamp);
                        ultimaMensagemId = data.mensagem.id;
                    } else {
                        console.error('Erro ao enviar mensagem:', data.message);
                        if (data.message && data.message.includes('invalid')) {
                            // Reset conversation if invalid
                            conversaId = null;
                            localStorage.removeItem('chat_conversa_id');
                            mostrarFormularioAutenticacao();
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar mensagem:', error);
                    // Reset conversation on error
                    conversaId = null;
                    localStorage.removeItem('chat_conversa_id');
                    mostrarFormularioAutenticacao();
                });
                });
            }

            function mostrarChat() {
                chatForm.classList.add('hidden');
                chatMessages.classList.remove('hidden');
                chatInput.classList.remove('hidden');
                chatStatus.classList.remove('hidden');
            }

            // Verificar se já existe conversa para este IP
            function verificarConversaExistente() {
                // Verificar no localStorage se já existe conversa
                const conversaSalva = localStorage.getItem('chat_conversa_id');
                if (conversaSalva) {
                    conversaId = conversaSalva;
                    console.log('Conversa existente encontrada:', conversaId);
                    mostrarChat();
                    carregarMensagens();
                    iniciarVerificacaoMensagens();
                    
                    // Verificar se a conversa foi encerrada
                    verificarConversaEncerrada();
                    
                    // Mostrar mensagem de boas-vindas
                    const nomeCliente = localStorage.getItem('chat_nome_cliente');
                    if (nomeCliente) {
                        adicionarMensagemSistema(`Bem-vindo de volta, ${nomeCliente}! Como posso ajudá-lo hoje?`);
                    }
                }
            }

            // Verificar se a conversa foi encerrada pelo admin
            function verificarConversaEncerrada() {
                if (!conversaId) return;

                fetch(`{{ route("chat.novas-mensagens") }}?conversa_id=${conversaId}&ultima_mensagem_id=0`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.conversa_encerrada) {
                        mostrarBotaoEncerrarConversa();
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar status da conversa:', error);
                });
            }

            // Mostrar botão para encerrar conversa
            function mostrarBotaoEncerrarConversa() {
                const messagesContainer = document.getElementById('chat-messages');
                const buttonDiv = document.createElement('div');
                
                buttonDiv.className = 'flex justify-center mt-4';
                buttonDiv.innerHTML = `
                    <button id="btn-encerrar-conversa" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Encerrar Conversa
                    </button>
                `;
                
                messagesContainer.appendChild(buttonDiv);
                
                // Adicionar event listener ao botão
                document.getElementById('btn-encerrar-conversa').addEventListener('click', function() {
                    encerrarConversaCliente();
                });
            }

            // Encerrar conversa do lado do cliente
            function encerrarConversaCliente() {
                if (!conversaId) return;

                if (confirm('Tem certeza que deseja encerrar esta conversa? Você precisará iniciar uma nova conversa para continuar.')) {
                    fetch('{{ route("chat.encerrar") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            conversa_id: conversaId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Limpar localStorage
                            localStorage.removeItem('chat_conversa_id');
                            localStorage.removeItem('chat_nome_cliente');
                            localStorage.removeItem('chat_email_cliente');
                            localStorage.removeItem('chat_telefone_cliente');
                            
                            // Resetar variáveis
                            conversaId = null;
                            ultimaMensagemId = null;
                            
                            // Parar verificação de mensagens
                            pararVerificacaoMensagens();
                            
                            // Mostrar formulário inicial
                            chatForm.classList.remove('hidden');
                            chatMessages.classList.add('hidden');
                            chatInput.classList.add('hidden');
                            chatStatus.classList.add('hidden');
                            
                            // Limpar campos do formulário
                            document.getElementById('chat-nome').value = '';
                            document.getElementById('chat-email').value = '';
                            document.getElementById('chat-telefone').value = '';
                            
                            // Limpar mensagens do container
                            const messagesContainer = document.getElementById('chat-messages');
                            if (messagesContainer) {
                                messagesContainer.innerHTML = '';
                            }
                            
                            // Mostrar mensagem de confirmação
                            alert('Conversa encerrada com sucesso! Você pode iniciar uma nova conversa quando quiser.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao encerrar conversa:', error);
                        alert('Erro ao encerrar conversa. Tente novamente.');
                    });
                }
            }

            // Adicionar mensagem do sistema
            function adicionarMensagemSistema(mensagem) {
                const messagesContainer = document.getElementById('chat-messages');
                const messageDiv = document.createElement('div');
                
                messageDiv.className = 'flex justify-center';
                messageDiv.innerHTML = `
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2 max-w-xs">
                        <p class="text-sm text-blue-800 text-center">${mensagem}</p>
                    </div>
                `;
                
                messagesContainer.appendChild(messageDiv);
                scrollToBottom();
            }

            // Salvar conversa no localStorage
            function salvarConversa(conversaId) {
                localStorage.setItem('chat_conversa_id', conversaId);
                localStorage.setItem('chat_nome_cliente', document.getElementById('chat-nome').value);
                localStorage.setItem('chat_email_cliente', document.getElementById('chat-email').value);
                localStorage.setItem('chat_telefone_cliente', document.getElementById('chat-telefone').value);
            }

            // Carregar dados do cliente do localStorage
            function carregarDadosCliente() {
                const nome = localStorage.getItem('chat_nome_cliente');
                const email = localStorage.getItem('chat_email_cliente');
                const telefone = localStorage.getItem('chat_telefone_cliente');
                
                if (nome) document.getElementById('chat-nome').value = nome;
                if (email) document.getElementById('chat-email').value = email;
                if (telefone) document.getElementById('chat-telefone').value = telefone;
            }

            function carregarMensagens() {
                if (!conversaId) return;

                fetch(`{{ route("chat.mensagens") }}?conversa_id=${conversaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        chatMessages.innerHTML = '';
                        data.mensagens.forEach(mensagem => {
                            adicionarMensagem(mensagem.mensagem, mensagem.tipo, mensagem.timestamp);
                            ultimaMensagemId = mensagem.id;
                        });
                        scrollToBottom();
                    } else {
                        console.error('Erro ao carregar mensagens:', data.message);
                        if (data.message && data.message.includes('invalid')) {
                            // Reset conversation if invalid
                            conversaId = null;
                            localStorage.removeItem('chat_conversa_id');
                            mostrarFormularioAutenticacao();
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar mensagens:', error);
                    // Reset conversation on error
                    conversaId = null;
                    localStorage.removeItem('chat_conversa_id');
                    mostrarFormularioAutenticacao();
                });
            }

            function adicionarMensagem(mensagem, tipo, timestamp) {
                const mensagemDiv = document.createElement('div');
                mensagemDiv.className = `flex ${tipo === 'cliente' ? 'justify-end' : 'justify-start'}`;
                
                mensagemDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${
                        tipo === 'cliente' 
                            ? 'bg-blue-600 text-white' 
                            : 'bg-gray-200 text-gray-800'
                    }">
                        <p class="text-sm">${mensagem}</p>
                        <p class="text-xs mt-1 opacity-70">${timestamp}</p>
                    </div>
                `;
                
                chatMessages.appendChild(mensagemDiv);
                scrollToBottom();
            }

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function iniciarVerificacaoMensagens() {
                if (chatInterval) clearInterval(chatInterval);
                
                chatInterval = setInterval(() => {
                    verificarNovasMensagens();
                }, 3000); // Verificar a cada 3 segundos
            }

            function pararVerificacaoMensagens() {
                if (chatInterval) {
                    clearInterval(chatInterval);
                    chatInterval = null;
                }
            }

            function verificarNovasMensagens() {
                if (!conversaId) return;

                const url = `{{ route("chat.novas-mensagens") }}?conversa_id=${conversaId}&ultima_mensagem_id=${ultimaMensagemId || ''}`;
                
                fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Verificar se a conversa foi encerrada
                        if (data.conversa_encerrada) {
                            mostrarBotaoEncerrarConversa();
                            return;
                        }
                        
                        // Verificar novas mensagens
                        if (data.tem_novas) {
                            data.novas_mensagens.forEach(mensagem => {
                                adicionarMensagem(mensagem.mensagem, mensagem.tipo, mensagem.timestamp);
                                ultimaMensagemId = mensagem.id;
                            });
                            
                            // Mostrar notificação se chat estiver fechado
                            if (chatWidget.style.display === 'none' || chatWidget.classList.contains('translate-y-full')) {
                                mostrarNotificacao(data.novas_mensagens.length);
                            }
                        }
                    } else {
                        console.error('Erro ao verificar novas mensagens:', data.message);
                        if (data.message && data.message.includes('invalid')) {
                            // Reset conversation if invalid
                            conversaId = null;
                            localStorage.removeItem('chat_conversa_id');
                            mostrarFormularioAutenticacao();
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar novas mensagens:', error);
                    // Reset conversation on error
                    conversaId = null;
                    localStorage.removeItem('chat_conversa_id');
                    mostrarFormularioAutenticacao();
                });
            }

            function mostrarNotificacao(count) {
                chatNotificationCount.textContent = count;
                chatNotification.classList.remove('opacity-0');
                chatNotification.classList.add('opacity-100');
            }

            function esconderNotificacao() {
                chatNotification.classList.remove('opacity-100');
                chatNotification.classList.add('opacity-0');
            }

            // Esconder notificação quando abrir o chat
            if (chatToggle) {
                chatToggle.addEventListener('click', function() {
                    if (chatWidget.style.display === 'block' && !chatWidget.classList.contains('translate-y-full')) {
                        esconderNotificacao();
                    }
                });
            }

            // Debug: Log when DOM is loaded
            console.log('Chat elements loaded:', {
                chatToggle: !!chatToggle,
                chatWidget: !!chatWidget,
                chatClose: !!chatClose,
                chatStartForm: !!chatStartForm,
                chatMessageForm: !!chatMessageForm
            });

            // Global function to test chat
            window.testChat = function() {
                console.log('Testing chat...');
                toggleChat();
            };

            // Inicializar dados do cliente quando a página carrega
            carregarDadosCliente();
            
            // Verificar status dos favoritos ao carregar a página
            verificarStatusFavoritos();
            
            // Limpar dados inválidos do localStorage
            limparDadosInvalidos();
            
            // Newsletter form
            document.getElementById('newsletter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const email = document.getElementById('newsletter-email').value;
                const messageDiv = document.getElementById('newsletter-message');
                const button = form.querySelector('button[type="submit"]');
                
                // Disable button
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';
                
                fetch('{{ route("newsletter.inscrever") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    messageDiv.classList.remove('hidden');
                    
                    if (data.success) {
                        messageDiv.className = 'mt-3 text-sm text-green-400';
                        messageDiv.textContent = data.message;
                        form.reset();
                    } else {
                        messageDiv.className = 'mt-3 text-sm text-red-400';
                        messageDiv.textContent = data.message || 'Erro ao inscrever-se na newsletter';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    messageDiv.classList.remove('hidden');
                    messageDiv.className = 'mt-3 text-sm text-red-400';
                    messageDiv.textContent = 'Erro ao inscrever-se na newsletter';
                })
                .finally(() => {
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Inscrever-se';
                });
            });
        }); // Fim do DOMContentLoaded

        // Favoritos functionality
        function verificarStatusFavoritos() {
            // Verificar se o usuário está logado
            @if(auth()->check())
                // Buscar todos os botões de favorito na página
                const botoesFavorito = document.querySelectorAll('button[onclick*="toggleFavorito"]');
                console.log('Botões de favorito encontrados:', botoesFavorito.length);
                
                botoesFavorito.forEach(button => {
                    const onclick = button.getAttribute('onclick');
                    const match = onclick.match(/toggleFavorito\((\d+)\)/);
                    
                    if (match) {
                        const imovelId = match[1];
                        console.log('Verificando favorito para imóvel:', imovelId);
                        
                        // Verificar status do favorito
                        fetch(`/favoritos/check/${imovelId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Resposta do servidor para imóvel', imovelId, ':', data);
                            if (data.success) {
                                updateHeartIcon(imovelId, data.is_favorito);
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao verificar favorito:', error);
                        });
                    }
                });
            @else
                console.log('Usuário não está logado, pulando verificação de favoritos');
            @endif
        }

        function toggleFavorito(imovelId) {
            fetch('{{ route("favoritos.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    imovel_id: imovelId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_favorito) {
                        showNotification(data.message, 'success');
                        // Atualizar ícone do coração
                        updateHeartIcon(imovelId, true);
                    } else {
                        showNotification(data.message, 'info');
                        // Atualizar ícone do coração
                        updateHeartIcon(imovelId, false);
                    }
                } else {
                    if (data.requires_auth) {
                        showNotification('Você precisa estar logado para favoritar imóveis', 'warning');
                    } else {
                        showNotification(data.message || 'Erro ao favoritar imóvel', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showNotification('Erro ao favoritar imóvel', 'error');
            });
        }

        function updateHeartIcon(imovelId, isFavorito) {
            const buttons = document.querySelectorAll(`button[onclick="toggleFavorito(${imovelId})"]`);
            buttons.forEach(button => {
                const icon = button.querySelector('i');
                if (isFavorito) {
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-red-500');
                } else {
                    icon.classList.remove('text-red-500');
                    icon.classList.add('text-gray-400');
                }
            });
        }

        function showNotification(message, type = 'info') {
            // Criar elemento de notificação
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 
                'bg-blue-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animar entrada
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Remover após 3 segundos
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>

