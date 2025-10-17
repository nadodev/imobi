<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Conversa;
use Illuminate\Http\Request;

class ConversaController extends Controller
{
    public function index()
    {
        // Get user's conversations
        $conversas = Conversa::where('user_id', auth()->id())
            ->with(['ultimaMensagem'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.conversas.index', compact('conversas'));
    }

    public function show(Conversa $conversa)
    {
        // Ensure the conversation belongs to the authenticated user
        if ($conversa->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        // Load messages
        $conversa->load('mensagens');

        return view('cliente.conversas.show', compact('conversa'));
    }
}
