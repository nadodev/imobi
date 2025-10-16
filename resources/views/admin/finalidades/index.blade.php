@extends('layouts.admin')

@section('page-title', 'Finalidades')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Nova Finalidade</h3>
        <form action="{{ route('admin.finalidades.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" name="nome" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus"></i> Adicionar
            </button>
        </form>
    </div>

    <!-- Lista -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Finalidades Cadastradas</h3>
            <div class="space-y-3">
                @forelse($finalidades as $finalidade)
                    <div class="flex items-center justify-between border-b pb-3">
                        <div>
                            <p class="font-semibold">{{ $finalidade->nome }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $finalidade->imoveis_count }} imóve{{ $finalidade->imoveis_count == 1 ? 'l' : 'is' }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editFinalidade({{ $finalidade->id }}, '{{ $finalidade->nome }}')"
                                    class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.finalidades.destroy', $finalidade) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tem certeza?')"
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Nenhuma finalidade cadastrada</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Editar Finalidade</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" id="editNome" name="nome" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
                <button type="button" onclick="closeModal()" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function editFinalidade(id, nome) {
    document.getElementById('editForm').action = '/admin/finalidades/' + id;
    document.getElementById('editNome').value = nome;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection

