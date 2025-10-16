<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index(Request $request)
    {
        $query = Mensagem::with('imovel');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mensagem', 'like', "%{$search}%");
            });
        }

        $mensagens = $query->latest()->paginate(20);

        return view('admin.mensagens.index', compact('mensagens'));
    }

    public function show(Mensagem $mensagem)
    {
        $mensagem->marcarComoLida();
        $mensagem->load('imovel');
        
        return view('admin.mensagens.show', compact('mensagem'));
    }

    public function responder(Request $request, Mensagem $mensagem)
    {
        $request->validate([
            'resposta' => 'required|string'
        ]);

        $mensagem->update([
            'status' => 'respondida',
            'resposta' => $request->resposta,
            'respondido_em' => now(),
            'respondido_por' => auth()->id()
        ]);

        // Aqui você pode adicionar o envio de email

        return back()->with('success', 'Resposta enviada com sucesso!');
    }

    public function destroy(Mensagem $mensagem)
    {
        $mensagem->delete();

        return redirect()->route('admin.mensagens.index')
            ->with('success', 'Mensagem excluída com sucesso!');
    }
}

