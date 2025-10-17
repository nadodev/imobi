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

    public function calendario(Request $request)
    {
        $ano = $request->get('ano', now()->year);
        $mes = $request->get('mes', now()->month);
        
        // Buscar agendamentos do mês
        $agendamentos = Agendamento::with('imovel')
            ->whereYear('data_visita', $ano)
            ->whereMonth('data_visita', $mes)
            ->orderBy('data_visita')
            ->orderBy('horario_visita')
            ->get();

        // Organizar agendamentos por data
        $agendamentosPorData = $agendamentos->groupBy(function($agendamento) {
            return \Carbon\Carbon::parse($agendamento->data_visita)->format('Y-m-d');
        });

        return view('admin.agendamentos.calendario', compact('agendamentosPorData', 'ano', 'mes'));
    }

    public function getAgendamentosData(Request $request)
    {
        $data = $request->get('data');
        
        $agendamentos = Agendamento::with('imovel')
            ->whereDate('data_visita', $data)
            ->orderBy('horario_visita')
            ->get();

        return response()->json($agendamentos);
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

