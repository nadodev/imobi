<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finalidade;
use Illuminate\Http\Request;

class FinalidadeController extends Controller
{
    public function index()
    {
        $finalidades = Finalidade::withCount('imoveis')->get();
        return view('admin.finalidades.index', compact('finalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:finalidades'
        ]);

        Finalidade::create($validated);

        return back()->with('success', 'Finalidade cadastrada com sucesso!');
    }

    public function update(Request $request, Finalidade $finalidade)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:finalidades,nome,' . $finalidade->id
        ]);

        $finalidade->update($validated);

        return back()->with('success', 'Finalidade atualizada com sucesso!');
    }

    public function destroy(Finalidade $finalidade)
    {
        if ($finalidade->imoveis()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma finalidade com imóveis vinculados!');
        }

        $finalidade->delete();

        return back()->with('success', 'Finalidade excluída com sucesso!');
    }
}

