@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Bem-vindo de volta!
        </h2>
        <p class="text-gray-600">
            Entre na sua conta para continuar
        </p>
    </div>
    
    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Erro na autenticação
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Email Field -->
        <div class="input-group">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                Email
            </label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   required 
                   autocomplete="email"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                   placeholder="seu@email.com"
                   value="{{ old('email') }}">
        </div>
        
        <!-- Password Field -->
        <div class="input-group">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Senha
            </label>
            <div class="relative">
                <input id="password" 
                       name="password" 
                       type="password" 
                       required 
                       autocomplete="current-password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 pr-12"
                       placeholder="Sua senha">
                <button type="button" 
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
        </div>
        
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" 
                       name="remember" 
                       type="checkbox" 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Lembrar-me
                </label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                    Esqueceu a senha?
                </a>
            @endif
        </div>
        
        <!-- Submit Button -->
        <button type="submit" 
                class="btn-primary w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Entrar na Conta
        </button>
        
        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">ou</span>
            </div>
        </div>
        
        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Não tem uma conta? 
                <a href="{{ route('register') }}" 
                   class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Criar conta gratuita
                </a>
            </p>
        </div>
    </form>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(inputId + '-eye');
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection