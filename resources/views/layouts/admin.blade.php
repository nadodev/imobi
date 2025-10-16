<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Imobiliária')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-cogs"></i> Admin
                </h2>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-chart-line mr-2"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.imoveis.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.imoveis.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-building mr-2"></i> Imóveis
                </a>
                
                <a href="{{ route('admin.agendamentos.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.agendamentos.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-calendar mr-2"></i> Agendamentos
                </a>
                
                <a href="{{ route('admin.mensagens.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.mensagens.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-envelope mr-2"></i> Mensagens
                </a>
                
                <a href="{{ route('admin.tipos.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.tipos.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tags mr-2"></i> Tipos
                </a>
                
                <a href="{{ route('admin.finalidades.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.finalidades.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-list mr-2"></i> Finalidades
                </a>
                
                <a href="{{ route('admin.configuracoes.index') }}" 
                   class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.configuracoes.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-cog mr-2"></i> Configurações
                </a>

                <hr class="my-4 border-gray-700">
                
                <a href="{{ route('home') }}" class="block px-4 py-3 hover:bg-gray-700">
                    <i class="fas fa-home mr-2"></i> Ver Site
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            <div class="px-6 py-4">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="px-6 py-4">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>

