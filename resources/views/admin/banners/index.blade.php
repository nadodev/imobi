@extends('layouts.admin')

@section('page-title', 'Gerenciar Banners')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Gerenciar Banners</h1>
                <a href="{{ route('admin.banners.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Novo Banner
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if($banners->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($banners as $banner)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $banner->imagem) }}" 
                                             alt="{{ $banner->titulo }}" 
                                             class="h-16 w-24 object-cover rounded-lg">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $banner->titulo }}</div>
                                        @if($banner->descricao)
                                            <div class="text-sm text-gray-500">{{ Str::limit($banner->descricao, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $banner->posicao == 'hero' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $banner->posicao == 'sidebar' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $banner->posicao == 'footer' ? 'bg-purple-100 text-purple-800' : '' }}">
                                            {{ ucfirst($banner->posicao) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $banner->ordem }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $banner->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $banner->ativo ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($banner->data_inicio || $banner->data_fim)
                                            <div>
                                                @if($banner->data_inicio)
                                                    <div>Início: {{ $banner->data_inicio->format('d/m/Y') }}</div>
                                                @endif
                                                @if($banner->data_fim)
                                                    <div>Fim: {{ $banner->data_fim->format('d/m/Y') }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400">Sem período</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.banners.edit', $banner) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este banner?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $banners->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-image text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum banner encontrado</h3>
                    <p class="text-gray-500 mb-6">Comece criando seu primeiro banner.</p>
                    <a href="{{ route('admin.banners.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Criar Primeiro Banner
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
