<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $configuracoes = Configuracao::all()->groupBy('grupo');
        return view('admin.configuracoes.index', compact('configuracoes'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $chave => $valor) {
            Configuracao::updateOrCreate(
                ['chave' => $chave],
                ['valor' => $valor]
            );
        }

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}

