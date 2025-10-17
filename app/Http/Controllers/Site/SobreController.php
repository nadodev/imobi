<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\PaginaSobre;
use Illuminate\Http\Request;

class SobreController extends Controller
{
    public function index()
    {
        $paginaSobre = PaginaSobre::ativa()->first();
        
        if (!$paginaSobre) {
            abort(404, 'Página Sobre não encontrada');
        }
        
        return view('site.sobre.index', compact('paginaSobre'));
    }
}
