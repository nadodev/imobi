@extends('layouts.admin')

@section('page-title', 'Detalhes do Agendamento')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-semibold mb-6">Informações do Agendamento</h3>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-600">Cliente</p>
                <p class="font-semibold">{{ $agendamento->nome_cliente }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Data da Visita</p>
                <p class="font-semibold">{{ $agendamento->data_formatada }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Telefone</p>
                <p class="font-semibold">{{ $agendamento->telefone }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">E-mail</p>
                <p class="font-semibold">{{ $agendamento->email }}</p>
            </div>

            @if($agendamento->imovel)
            <div class="col-span-2">
                <p class="text-sm text-gray-600">Imóvel</p>
                <a href="{{ route('imoveis.show', $agendamento->imovel->slug) }}" target="_blank" 
                   class="text-blue-600 hover:underline font-semibold">
                    {{ $agendamento->imovel->codigo }} - {{ $agendamento->imovel->titulo }}
                </a>
            </div>
            @endif

            @if($agendamento->mensagem)
            <div class="col-span-2">
                <p class="text-sm text-gray-600">Mensagem</p>
                <p class="bg-gray-50 p-3 rounded">{{ $agendamento->mensagem }}</p>
            </div>
            @endif
        </div>

        <!-- Atualizar Status -->
        <form action="{{ route('admin.agendamentos.update', $agendamento) }}" method="POST" class="border-t pt-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="pendente" {{ $agendamento->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="confirmado" {{ $agendamento->status == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelado" {{ $agendamento->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="realizado" {{ $agendamento->status == 'realizado' ? 'selected' : '' }}>Realizado</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea name="observacoes" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg">{{ $agendamento->observacoes }}</textarea>
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save"></i> Atualizar
                </button>
                <a href="{{ route('admin.agendamentos.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

