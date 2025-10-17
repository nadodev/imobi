@extends('layouts.admin')

@section('title', 'Enviar Newsletter')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Enviar Newsletter</h1>
            <p class="text-gray-600 mt-2">Crie e envie newsletters para seus inscritos</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.newsletter.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-blue-900">Total de Inscritos Ativos</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalInscritos }}</p>
                <p class="text-sm text-blue-700">emails receberão esta newsletter</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('admin.newsletter.enviar.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Tipo de Envio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de Envio</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tipo" value="todos" class="sr-only" checked>
                        <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-colors newsletter-tipo-option" data-tipo="todos">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <i class="fas fa-users text-xl text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Enviar para Todos</h3>
                                    <p class="text-sm text-gray-600">Enviar para todos os {{ $totalInscritos }} inscritos ativos</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tipo" value="individual" class="sr-only">
                        <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-colors newsletter-tipo-option" data-tipo="individual">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <i class="fas fa-user text-xl text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Enviar Individual</h3>
                                    <p class="text-sm text-gray-600">Enviar para um email específico</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Email Individual -->
            <div id="email-individual" class="hidden">
                <label for="email_destino" class="block text-sm font-medium text-gray-700 mb-2">
                    Email de Destino
                </label>
                <select id="email_destino" 
                        name="email_destino"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Selecione um email...</option>
                    @foreach($emailsCadastrados as $email)
                        <option value="{{ $email->email }}">
                            {{ $email->email }} 
                            @if($email->nome)
                                ({{ $email->nome }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Selecione um dos emails cadastrados na newsletter
                </p>
            </div>

            <!-- Assunto -->
            <div>
                <label for="assunto" class="block text-sm font-medium text-gray-700 mb-2">
                    Assunto do Email *
                </label>
                <input type="text" 
                       id="assunto" 
                       name="assunto"
                       placeholder="Ex: Novas ofertas imperdíveis!"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <!-- Conteúdo -->
            <div>
                <label for="conteudo" class="block text-sm font-medium text-gray-700 mb-2">
                    Conteúdo da Newsletter *
                </label>
                <textarea id="conteudo" 
                          name="conteudo"
                          rows="12"
                          placeholder="Digite o conteúdo da newsletter aqui..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          required></textarea>
                <p class="text-sm text-gray-500 mt-2">
                    Dica: Use quebras de linha para melhor formatação do email
                </p>
            </div>

            <!-- Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preview do Email
                </label>
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="border-b border-gray-200 pb-2 mb-4">
                            <p class="text-sm text-gray-500">Assunto:</p>
                            <p id="preview-assunto" class="font-semibold text-gray-900">Digite o assunto acima</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Conteúdo:</p>
                            <div id="preview-conteudo" class="text-gray-900 whitespace-pre-line">
                                Digite o conteúdo acima
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.newsletter.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Newsletter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle tipo de envio
document.querySelectorAll('input[name="tipo"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const emailIndividual = document.getElementById('email-individual');
        const emailDestino = document.getElementById('email_destino');
        
        if (this.value === 'individual') {
            emailIndividual.classList.remove('hidden');
            emailDestino.required = true;
        } else {
            emailIndividual.classList.add('hidden');
            emailDestino.required = false;
            emailDestino.value = ''; // Limpar seleção quando mudar para "todos"
        }
    });
});

// Update visual selection
document.querySelectorAll('.newsletter-tipo-option').forEach(option => {
    option.addEventListener('click', function() {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        
        // Update visual state
        document.querySelectorAll('.newsletter-tipo-option').forEach(opt => {
            opt.classList.remove('border-blue-500', 'bg-blue-50');
            opt.classList.add('border-gray-200');
        });
        
        this.classList.remove('border-gray-200');
        this.classList.add('border-blue-500', 'bg-blue-50');
        
        // Trigger change event
        radio.dispatchEvent(new Event('change'));
    });
});

// Preview updates
document.getElementById('assunto').addEventListener('input', function() {
    document.getElementById('preview-assunto').textContent = this.value || 'Digite o assunto acima';
});

document.getElementById('conteudo').addEventListener('input', function() {
    document.getElementById('preview-conteudo').textContent = this.value || 'Digite o conteúdo acima';
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const tipo = document.querySelector('input[name="tipo"]:checked').value;
    const emailDestino = document.getElementById('email_destino');
    
    if (tipo === 'individual' && !emailDestino.value) {
        e.preventDefault();
        alert('Por favor, selecione um email de destino para envio individual.');
        emailDestino.focus();
        return;
    }
    
    if (!confirm('Tem certeza que deseja enviar esta newsletter?')) {
        e.preventDefault();
    }
});
</script>
@endsection
