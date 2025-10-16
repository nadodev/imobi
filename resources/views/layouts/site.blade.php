<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Imobiliária')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-home"></i> Imobiliária
                </a>
                
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="{{ route('imoveis.index') }}" class="text-gray-700 hover:text-blue-600">Imóveis</a>
                    <a href="{{ route('contato') }}" class="text-gray-700 hover:text-blue-600">Contato</a>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isCorretor())
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-cog"></i> Admin
                            </a>
                        @endif
                    @endauth
                </nav>

                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Entrar</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </button>
                        </form>
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
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Sobre Nós</h3>
                    <p class="text-gray-400">Sua imobiliária de confiança. Encontre o imóvel dos seus sonhos.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contato</h3>
                    <p class="text-gray-400">
                        <i class="fas fa-phone"></i> (11) 9999-9999<br>
                        <i class="fas fa-envelope"></i> contato@imobiliaria.com<br>
                        <i class="fas fa-map-marker-alt"></i> São Paulo, SP
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Redes Sociais</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-whatsapp fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Imobiliária. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

