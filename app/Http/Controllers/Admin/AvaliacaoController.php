<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Avaliacao::with('imovel');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('avaliacao')) {
            $query->where('avaliacao', $request->avaliacao);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('imovel', function($subQ) use ($search) {
                      $subQ->where('titulo', 'like', "%{$search}%")
                           ->orWhere('codigo', 'like', "%{$search}%");
                  });
            });
        }

        $avaliacoes = $query->latest()->paginate(20);
        
        // Estatísticas
        $stats = [
            'pendentes' => Avaliacao::where('status', 'pendente')->count(),
            'aprovadas' => Avaliacao::where('status', 'aprovado')->count(),
            'rejeitadas' => Avaliacao::where('status', 'rejeitado')->count(),
            'media_geral' => Avaliacao::where('status', 'aprovado')->avg('avaliacao') ?? 0,
        ];
        
        return view('admin.avaliacoes.index', compact('avaliacoes', 'stats'));
    }

    public function show($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $avaliacao->load('imovel');
        
        return view('admin.avaliacoes.show', compact('avaliacao'));
    }

    public function update(Request $request, $id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pendente,aprovado,rejeitado',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $avaliacao->update($validated);

        return back()->with('success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $avaliacao->delete();

        return redirect()->route('admin.avaliacoes.index')
            ->with('success', 'Avaliação excluída com sucesso!');
    }

    public function aprovar($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $avaliacao->update(['status' => 'aprovado']);

        return back()->with('success', 'Avaliação aprovada com sucesso!');
    }

    public function rejeitar($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $avaliacao->update(['status' => 'rejeitado']);

        return back()->with('success', 'Avaliação rejeitada com sucesso!');
    }
}
