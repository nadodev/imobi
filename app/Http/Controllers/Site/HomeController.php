<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Tipo;
use App\Models\Finalidade;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $imoveisDestaque = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->ativo()
            ->destaque()
            ->latest()
            ->take(6)
            ->get();

        $imoveisRecentes = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->ativo()
            ->latest()
            ->take(6)
            ->get();

        $tipos = Tipo::orderBy('ordem')->get();
        $finalidades = Finalidade::all();

        return view('site.home', compact('imoveisDestaque', 'imoveisRecentes', 'tipos', 'finalidades'));
    }
}

