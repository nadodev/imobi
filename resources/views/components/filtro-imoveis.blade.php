@props(['tipos', 'finalidades', 'cidades' => []])

<form method="GET" action="{{ route('imoveis.index') }}" class="bg-white p-6 rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Busca Geral -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
            <input type="text" name="busca" value="{{ request('busca') }}" 
                   placeholder="Código, título, cidade..."
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tipo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
            <select name="tipo_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todos os tipos</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Finalidade -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Finalidade</label>
            <select name="finalidade_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todas</option>
                @foreach($finalidades as $finalidade)
                    <option value="{{ $finalidade->id }}" {{ request('finalidade_id') == $finalidade->id ? 'selected' : '' }}>
                        {{ $finalidade->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cidade -->
        @if(count($cidades) > 0)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
            <select name="cidade" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todas as cidades</option>
                @foreach($cidades as $cidade)
                    <option value="{{ $cidade }}" {{ request('cidade') == $cidade ? 'selected' : '' }}>
                        {{ $cidade }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Preço Mínimo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preço Mínimo</label>
            <input type="number" name="preco_min" value="{{ request('preco_min') }}" 
                   placeholder="R$ 0,00"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Preço Máximo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preço Máximo</label>
            <input type="number" name="preco_max" value="{{ request('preco_max') }}" 
                   placeholder="R$ 999.999,00"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Quartos -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Quartos (mín)</label>
            <select name="quartos" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Qualquer</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('quartos') == $i ? 'selected' : '' }}>
                        {{ $i }}+ quarto{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Ordenar -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
            <select name="ordem" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="recentes" {{ request('ordem') == 'recentes' ? 'selected' : '' }}>Mais recentes</option>
                <option value="preco_menor" {{ request('ordem') == 'preco_menor' ? 'selected' : '' }}>Menor preço</option>
                <option value="preco_maior" {{ request('ordem') == 'preco_maior' ? 'selected' : '' }}>Maior preço</option>
                <option value="mais_visualizados" {{ request('ordem') == 'mais_visualizados' ? 'selected' : '' }}>Mais visualizados</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex gap-2">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-search"></i> Buscar
        </button>
        <a href="{{ route('imoveis.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-times"></i> Limpar
        </a>
    </div>
</form>

