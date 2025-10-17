@extends('layouts.admin')

@section('page-title', 'Detalhes da Avaliação')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Detalhes da Avaliação</h1>
        <p class="text-gray-600">Visualizar avaliação de imóvel</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.avaliacoes.index') }}" 
           class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Conteúdo Principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Avaliação -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Avaliação</h2>
                
                <div class="flex items-center mb-4">
                    <div class="flex items-center mr-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-2xl {{ $i <= $avaliacao->avaliacao ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-gray-900">{{ $avaliacao->avaliacao }}/5</span>
                        <span class="ml-2 text-lg text-gray-600">{{ $avaliacao->avaliacao_texto }}</span>
                    </div>
                </div>

                @if($avaliacao->comentario)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Comentário:</h3>
                        <p class="text-gray-900 leading-relaxed">{{ $avaliacao->comentario }}</p>
                    </div>
                @endif
            </div>

            <!-- Informações do Cliente -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informações do Cliente</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <p class="text-sm text-gray-900">{{ $avaliacao->nome }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $avaliacao->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">IP</label>
                        <p class="text-sm text-gray-900">{{ $avaliacao->ip_address }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data da Avaliação</label>
                        <p class="text-sm text-gray-900">{{ $avaliacao->created_at ? $avaliacao->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informações do Imóvel -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Imóvel Avaliado</h2>
                
                @if($avaliacao->imovel)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-start space-x-4">
                            @if($avaliacao->imovel->imagemPrincipal)
                                <img src="{{ asset('storage/' . $avaliacao->imovel->imagemPrincipal->caminho) }}" 
                                     alt="{{ $avaliacao->imovel->titulo }}"
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-home text-gray-400"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $avaliacao->imovel->titulo }}</h3>
                                <p class="text-sm text-gray-600">{{ $avaliacao->imovel->cidade }}, {{ $avaliacao->imovel->bairro }}</p>
                                <p class="text-sm text-gray-600">{{ $avaliacao->imovel->tipo->nome }} - {{ $avaliacao->imovel->finalidade->nome }}</p>
                                <p class="text-lg font-bold text-blue-600">{{ $avaliacao->imovel->preco_formatado }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('admin.imoveis.show', $avaliacao->imovel) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Ver detalhes do imóvel
                            </a>
                        </div>
                    </div>
                @else
                    <div class="border rounded-lg p-4 bg-yellow-50">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <p class="text-yellow-800">Imóvel não encontrado ou foi removido</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status e Ações -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status e Ações</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Atual</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $avaliacao->status === 'aprovado' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $avaliacao->status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $avaliacao->status === 'rejeitado' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($avaliacao->status) }}
                    </span>
                </div>

                @if($avaliacao->status === 'pendente')
                    <div class="space-y-2">
                        <form method="POST" action="{{ route('admin.avaliacoes.aprovar', $avaliacao) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors"
                                    onclick="return confirm('Aprovar esta avaliação?')">
                                <i class="fas fa-check mr-2"></i> Aprovar Avaliação
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.avaliacoes.rejeitar', $avaliacao) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors"
                                    onclick="return confirm('Rejeitar esta avaliação?')">
                                <i class="fas fa-times mr-2"></i> Rejeitar Avaliação
                            </button>
                        </form>
                    </div>
                @endif

                <div class="pt-4 border-t">
                    <form method="POST" action="{{ route('admin.avaliacoes.destroy', $avaliacao) }}" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i> Excluir Avaliação
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Estatísticas do Imóvel -->
        @if($avaliacao->imovel)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas do Imóvel</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total de Avaliações:</span>
                        <span class="text-sm font-medium">{{ $avaliacao->imovel->total_avaliacoes }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Média de Avaliações:</span>
                        <span class="text-sm font-medium">{{ number_format($avaliacao->imovel->media_avaliacoes, 1) }}/5</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Visualizações:</span>
                        <span class="text-sm font-medium">{{ $avaliacao->imovel->total_visualizacoes }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Links Úteis -->
        @if($avaliacao->imovel)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Links Úteis</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('imoveis.show', $avaliacao->imovel->slug) }}" target="_blank"
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                        <i class="fas fa-external-link-alt mr-2"></i> Ver no Site
                    </a>
                    
                    <a href="{{ route('admin.imoveis.show', $avaliacao->imovel) }}"
                       class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                        <i class="fas fa-cog mr-2"></i> Gerenciar Imóvel
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
