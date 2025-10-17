@props(['tipos', 'finalidades', 'cidades' => []])

<div class="bg-white rounded-3xl shadow-xl p-8">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
            <i class="fas fa-sliders-h text-blue-600"></i>
            Filtrar Imóveis
        </h3>
        <p class="text-gray-600 mt-2">Encontre exatamente o que você procura</p>
    </div>

    <form method="GET" action="{{ route('imoveis.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Busca Geral -->
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-search text-blue-500 mr-1"></i> Buscar
                </label>
                <input type="text" name="busca" value="{{ request('busca') }}" 
                       placeholder="Código, título, cidade..."
                       class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
            </div>

            <!-- Tipo -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-building text-blue-500 mr-1"></i> Tipo
                </label>
                <select name="tipo_id" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
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
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-tag text-blue-500 mr-1"></i> Finalidade
                </label>
                <select name="finalidade_id" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
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
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> Cidade
                </label>
                <select name="cidade" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
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
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-dollar-sign text-green-500 mr-1"></i> Preço Mínimo
                </label>
                <input type="number" name="preco_min" value="{{ request('preco_min') }}" 
                       placeholder="R$ 0,00"
                       class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
            </div>

            <!-- Preço Máximo -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-dollar-sign text-green-500 mr-1"></i> Preço Máximo
                </label>
                <input type="number" name="preco_max" value="{{ request('preco_max') }}" 
                       placeholder="R$ 999.999,00"
                       class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
            </div>

            <!-- Quartos -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-bed text-purple-500 mr-1"></i> Quartos (mín)
                </label>
                <select name="quartos" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    <option value="">Qualquer</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('quartos') == $i ? 'selected' : '' }}>
                            {{ $i }}+ quarto{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Banheiros -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-bath text-purple-500 mr-1"></i> Banheiros (mín)
                </label>
                <select name="banheiros" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    <option value="">Qualquer</option>
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ request('banheiros') == $i ? 'selected' : '' }}>
                            {{ $i }}+ banheiro{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Ordenar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-sort text-orange-500 mr-1"></i> Ordenar por
                </label>
                <select name="ordem" class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-lg">
                    <option value="recentes" {{ request('ordem') == 'recentes' ? 'selected' : '' }}>Mais recentes</option>
                    <option value="preco_menor" {{ request('ordem') == 'preco_menor' ? 'selected' : '' }}>Menor preço</option>
                    <option value="preco_maior" {{ request('ordem') == 'preco_maior' ? 'selected' : '' }}>Maior preço</option>
                    <option value="mais_visualizados" {{ request('ordem') == 'mais_visualizados' ? 'selected' : '' }}>Mais visualizados</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <button type="submit" class="flex-1 btn-primary text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl flex items-center justify-center gap-2">
                <i class="fas fa-search"></i> Buscar Imóveis
            </button>
            <a href="{{ route('imoveis.index') }}" 
               class="px-8 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold text-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-redo"></i> Limpar Filtros
            </a>
        </div>
    </form>
</div>
