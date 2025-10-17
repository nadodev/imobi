<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArtigoController extends Controller
{
    public function index(Request $request)
    {
        $query = Artigo::with('user');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('resumo', 'like', "%{$search}%");
            });
        }

        $artigos = $query->latest()->paginate(20);
        
        return view('admin.artigos.index', compact('artigos'));
    }

    public function create()
    {
        return view('admin.artigos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumo' => 'required|string|max:500',
            'conteudo' => 'required|string',
            'categoria' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'imagem_destaque' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destaque' => 'boolean',
            'status' => 'required|in:rascunho,publicado,arquivado',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['titulo']);
        
        // Processar tags
        if ($validated['tags']) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Definir data de publicação
        if ($validated['status'] === 'publicado') {
            $validated['publicado_em'] = now();
        }

        // Upload da imagem
        if ($request->hasFile('imagem_destaque')) {
            $validated['imagem_destaque'] = $request->file('imagem_destaque')
                ->store('artigos', 'public');
        }

        Artigo::create($validated);

        return redirect()->route('admin.artigos.index')
            ->with('success', 'Artigo criado com sucesso!');
    }

    public function show(Artigo $artigo)
    {
        $artigo->load('user');
        return view('admin.artigos.show', compact('artigo'));
    }

    public function edit(Artigo $artigo)
    {
        return view('admin.artigos.edit', compact('artigo'));
    }

    public function update(Request $request, Artigo $artigo)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumo' => 'required|string|max:500',
            'conteudo' => 'required|string',
            'categoria' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'imagem_destaque' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destaque' => 'boolean',
            'status' => 'required|in:rascunho,publicado,arquivado',
        ]);

        $validated['slug'] = Str::slug($validated['titulo']);
        
        // Processar tags
        if ($validated['tags']) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Definir data de publicação
        if ($validated['status'] === 'publicado' && !$artigo->publicado_em) {
            $validated['publicado_em'] = now();
        }

        // Upload da nova imagem
        if ($request->hasFile('imagem_destaque')) {
            // Deletar imagem antiga
            if ($artigo->imagem_destaque) {
                \Storage::disk('public')->delete($artigo->imagem_destaque);
            }
            $validated['imagem_destaque'] = $request->file('imagem_destaque')
                ->store('artigos', 'public');
        }

        $artigo->update($validated);

        return redirect()->route('admin.artigos.index')
            ->with('success', 'Artigo atualizado com sucesso!');
    }

    public function destroy(Artigo $artigo)
    {
        // Deletar imagem
        if ($artigo->imagem_destaque) {
            \Storage::disk('public')->delete($artigo->imagem_destaque);
        }

        $artigo->delete();

        return redirect()->route('admin.artigos.index')
            ->with('success', 'Artigo excluído com sucesso!');
    }
}
