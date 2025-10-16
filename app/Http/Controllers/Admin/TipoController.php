<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::withCount('imoveis')->orderBy('ordem')->get();
        return view('admin.tipos.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipos',
            'ordem' => 'nullable|integer'
        ]);

        Tipo::create($validated);

        return back()->with('success', 'Tipo cadastrado com sucesso!');
    }

    public function update(Request $request, Tipo $tipo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipos,nome,' . $tipo->id,
            'ordem' => 'nullable|integer'
        ]);

        $tipo->update($validated);

        return back()->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy(Tipo $tipo)
    {
        if ($tipo->imoveis()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um tipo com imóveis vinculados!');
        }

        $tipo->delete();

        return back()->with('success', 'Tipo excluído com sucesso!');
    }
}

