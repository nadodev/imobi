<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Tipo;
use App\Models\Finalidade;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->ativo();

        // Filtros
        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        if ($request->filled('finalidade_id')) {
            $query->where('finalidade_id', $request->finalidade_id);
        }

        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->filled('bairro')) {
            $query->where('bairro', 'like', '%' . $request->bairro . '%');
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        if ($request->filled('quartos')) {
            $query->where('quartos', '>=', $request->quartos);
        }

        if ($request->filled('banheiros')) {
            $query->where('banheiros', '>=', $request->banheiros);
        }

        if ($request->filled('vagas')) {
            $query->where('vagas', '>=', $request->vagas);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('codigo', 'like', "%{$busca}%")
                  ->orWhere('cidade', 'like', "%{$busca}%")
                  ->orWhere('bairro', 'like', "%{$busca}%");
            });
        }

        // Ordenação
        $orderBy = $request->get('ordem', 'recentes');
        switch ($orderBy) {
            case 'preco_menor':
                $query->orderBy('preco', 'asc');
                break;
            case 'preco_maior':
                $query->orderBy('preco', 'desc');
                break;
            case 'mais_visualizados':
                $query->orderBy('visualizacoes', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $imoveis = $query->paginate(12);

        $tipos = Tipo::orderBy('ordem')->get();
        $finalidades = Finalidade::all();
        $cidades = Imovel::ativo()->distinct()->pluck('cidade')->sort();

        return view('site.imoveis.index', compact('imoveis', 'tipos', 'finalidades', 'cidades'));
    }

    public function show($slug)
    {
        $imovel = Imovel::with(['tipo', 'finalidade', 'imagens', 'corretor'])
            ->where('slug', $slug)
            ->ativo()
            ->firstOrFail();

        $imovel->incrementarVisualizacoes();

        // Imóveis semelhantes
        $semelhantes = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->ativo()
            ->where('id', '!=', $imovel->id)
            ->where('tipo_id', $imovel->tipo_id)
            ->where('cidade', $imovel->cidade)
            ->take(4)
            ->get();

        return view('site.imoveis.show', compact('imovel', 'semelhantes'));
    }
}

