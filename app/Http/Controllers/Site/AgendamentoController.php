<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\Imovel;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'imovel_id' => 'required|exists:imoveis,id',
            'nome_cliente' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'data_visita' => 'required|date|after:today',
            'horario_visita' => 'nullable',
            'mensagem' => 'nullable|string'
        ]);

        Agendamento::create($validated);

        // Aqui você pode adicionar o envio de email de notificação

        return back()->with('success', 'Agendamento realizado com sucesso! Entraremos em contato em breve.');
    }
}

