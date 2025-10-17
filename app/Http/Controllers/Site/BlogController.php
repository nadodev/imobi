<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artigo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Artigo::publicado()->with('user');

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        // Busca por texto
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('resumo', 'like', "%{$search}%")
                  ->orWhere('conteudo', 'like', "%{$search}%");
            });
        }

        $artigos = $query->recentes()->paginate(9);
        
        // Artigos em destaque
        $artigosDestaque = Artigo::publicado()->destaque()->recentes()->take(3)->get();
        
        // Categorias disponíveis
        $categorias = Artigo::publicado()->select('categoria')
            ->distinct()
            ->pluck('categoria');

        return view('site.blog.index', compact('artigos', 'artigosDestaque', 'categorias'));
    }

    public function show($slug)
    {
        $artigo = Artigo::publicado()
            ->where('slug', $slug)
            ->with('user')
            ->firstOrFail();

        // Incrementar visualizações
        $artigo->incrementarVisualizacoes();

        // Artigos relacionados (mesma categoria)
        $artigosRelacionados = Artigo::publicado()
            ->porCategoria($artigo->categoria)
            ->where('id', '!=', $artigo->id)
            ->recentes()
            ->take(3)
            ->get();

        return view('site.blog.show', compact('artigo', 'artigosRelacionados'));
    }

    public function categoria($categoria)
    {
        $artigos = Artigo::publicado()
            ->porCategoria($categoria)
            ->with('user')
            ->recentes()
            ->paginate(9);

        return view('site.blog.categoria', compact('artigos', 'categoria'));
    }
}
