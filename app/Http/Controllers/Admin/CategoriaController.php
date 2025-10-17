<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('ativa', $request->status === 'ativa');
        }

        $categorias = $query->ordenada()->paginate(20);
        
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'descricao' => 'nullable|string|max:500',
            'cor' => 'required|string|max:7',
            'icone' => 'nullable|string|max:50',
            'ativa' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['nome']);
        $validated['ordem'] = $validated['ordem'] ?? 0;

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load('artigos');
        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $categoria->id,
            'descricao' => 'nullable|string|max:500',
            'cor' => 'required|string|max:7',
            'icone' => 'nullable|string|max:50',
            'ativa' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['nome']);
        $validated['ordem'] = $validated['ordem'] ?? 0;

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        // Verificar se há artigos associados
        if ($categoria->artigos()->count() > 0) {
            return redirect()->route('admin.categorias.index')
                ->with('error', 'Não é possível excluir uma categoria que possui artigos associados.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}