<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Tipo;
use App\Models\Finalidade;
use App\Models\Banner;
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
        
        // Buscar banners ativos
        $bannersHero = Banner::ativos()->porPosicao('hero')->ordenados()->get();
        $bannersSidebar = Banner::ativos()->porPosicao('sidebar')->ordenados()->get();

        return view('site.home', compact('imoveisDestaque', 'imoveisRecentes', 'tipos', 'finalidades', 'bannersHero', 'bannersSidebar'));
    }
}

