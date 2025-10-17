@extends('layouts.auth')

@section('title', 'Cadastro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Criar nova conta
        </h2>
        <p class="text-gray-600">
            Junte-se a nós e encontre seu imóvel ideal
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
                        Erro no cadastro
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
    
    <!-- Register Form -->
    <form action="{{ route('register') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Name Field -->
        <div class="input-group">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-gray-400"></i>
                Nome completo
            </label>
            <input id="name" 
                   name="name" 
                   type="text" 
                   required 
                   autocomplete="name"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                   placeholder="Seu nome completo"
                   value="{{ old('name') }}">
        </div>
        
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
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 pr-12"
                       placeholder="Mínimo 8 caracteres">
                <button type="button" 
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                A senha deve ter pelo menos 8 caracteres
            </p>
        </div>
        
        <!-- Confirm Password Field -->
        <div class="input-group">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Confirmar senha
            </label>
            <div class="relative">
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       required 
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 pr-12"
                       placeholder="Digite a senha novamente">
                <button type="button" 
                        onclick="togglePassword('password_confirmation')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                </button>
            </div>
        </div>
        
        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" 
                       name="terms" 
                       type="checkbox" 
                       required
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-gray-700">
                    Eu concordo com os 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Termos de Uso</a> 
                    e 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Política de Privacidade</a>
                </label>
            </div>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" 
                class="btn-primary w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-user-plus mr-2"></i>
            Criar Conta
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
        
        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Já tem uma conta? 
                <a href="{{ route('login') }}" 
                   class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Fazer login
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

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = getPasswordStrength(password);
    updatePasswordStrength(strength);
});

function getPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}

function updatePasswordStrength(strength) {
    // Remove existing strength indicator
    const existing = document.getElementById('password-strength');
    if (existing) {
        existing.remove();
    }
    
    if (strength === 0) return;
    
    const strengthText = ['Muito fraca', 'Fraca', 'Regular', 'Boa', 'Muito forte'];
    const strengthColors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
    
    const indicator = document.createElement('div');
    indicator.id = 'password-strength';
    indicator.className = 'mt-2';
    indicator.innerHTML = `
        <div class="flex items-center space-x-2">
            <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div class="h-2 rounded-full ${strengthColors[strength - 1]}" style="width: ${(strength / 5) * 100}%"></div>
            </div>
            <span class="text-xs text-gray-600">${strengthText[strength - 1]}</span>
        </div>
    `;
    
    document.getElementById('password').parentElement.appendChild(indicator);
}
</script>
@endsection