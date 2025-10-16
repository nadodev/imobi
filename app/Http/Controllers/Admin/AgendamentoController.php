<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with('imovel');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome_cliente', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        $agendamentos = $query->latest()->paginate(20);

        return view('admin.agendamentos.index', compact('agendamentos'));
    }

    public function show(Agendamento $agendamento)
    {
        $agendamento->load('imovel');
        return view('admin.agendamentos.show', compact('agendamento'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmado,cancelado,realizado',
            'observacoes' => 'nullable|string'
        ]);

        $agendamento->update($validated);

        return back()->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();

        return redirect()->route('admin.agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}

