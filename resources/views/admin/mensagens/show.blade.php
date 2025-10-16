@extends('layouts.admin')

@section('page-title', 'Mensagem')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="border-b pb-4 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold">{{ $mensagem->nome }}</h3>
                    <p class="text-gray-600">{{ $mensagem->email }}</p>
                    @if($mensagem->telefone)
                        <p class="text-gray-600">{{ $mensagem->telefone }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $mensagem->created_at->format('d/m/Y H:i') }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full 
                        {{ $mensagem->status === 'nao_lida' ? 'bg-red-100 text-red-800' : 
                           ($mensagem->status === 'respondida' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ str_replace('_', ' ', ucfirst($mensagem->status)) }}
                    </span>
                </div>
            </div>
        </div>

        @if($mensagem->assunto)
            <div class="mb-4">
                <p class="text-sm text-gray-600">Assunto</p>
                <p class="font-semibold">{{ $mensagem->assunto }}</p>
            </div>
        @endif

        @if($mensagem->imovel)
            <div class="mb-4">
                <p class="text-sm text-gray-600">Imóvel de Interesse</p>
                <a href="{{ route('imoveis.show', $mensagem->imovel->slug) }}" target="_blank" 
                   class="text-blue-600 hover:underline font-semibold">
                    {{ $mensagem->imovel->codigo }} - {{ $mensagem->imovel->titulo }}
                </a>
            </div>
        @endif

        <div class="mb-6">
            <p class="text-sm text-gray-600 mb-2">Mensagem</p>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="whitespace-pre-line">{{ $mensagem->mensagem }}</p>
            </div>
        </div>

        @if($mensagem->status === 'respondida')
            <div class="border-t pt-4">
                <p class="text-sm text-gray-600 mb-2">Resposta Enviada</p>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="whitespace-pre-line">{{ $mensagem->resposta }}</p>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Respondido em {{ $mensagem->respondido_em->format('d/m/Y H:i') }}
                </p>
            </div>
        @else
            <!-- Formulário de Resposta -->
            <form action="{{ route('admin.mensagens.responder', $mensagem) }}" method="POST" class="border-t pt-6">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Resposta</label>
                    <textarea name="resposta" rows="6" required
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-paper-plane"></i> Enviar Resposta
                    </button>
                    <a href="{{ route('admin.mensagens.index') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                        Voltar
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

