<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Mensagem;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function index()
    {
        $config = [
            'nome_empresa' => Configuracao::obter('nome_empresa', 'Imobiliária'),
            'telefone' => Configuracao::obter('telefone', ''),
            'email' => Configuracao::obter('email', ''),
            'endereco' => Configuracao::obter('endereco', ''),
            'latitude' => Configuracao::obter('latitude', '-23.5505'),
            'longitude' => Configuracao::obter('longitude', '-46.6333'),
        ];

        return view('site.contato', compact('config'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'assunto' => 'nullable|string|max:255',
            'mensagem' => 'required|string',
            'imovel_id' => 'nullable|exists:imoveis,id'
        ]);

        Mensagem::create($validated);

        // Aqui você pode adicionar o envio de email de notificação

        return back()->with('success', 'Mensagem enviada com sucesso! Retornaremos em breve.');
    }
}

