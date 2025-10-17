<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriaSobre;
use App\Models\PaginaSobre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriaSobreController extends Controller
{
    public function index(PaginaSobre $paginaSobre)
    {
        $galeria = $paginaSobre->galeria()->get();
        return view('admin.galeria-sobre.index', compact('paginaSobre', 'galeria'));
    }

    public function store(Request $request, PaginaSobre $paginaSobre)
    {
        $request->validate([
            'imagens.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulos.*' => 'nullable|string|max:255',
            'descricoes.*' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $index => $imagem) {
                $caminhoImagem = $imagem->store('galeria-sobre', 'public');
                
                GaleriaSobre::create([
                    'pagina_sobre_id' => $paginaSobre->id,
                    'imagem' => $caminhoImagem,
                    'titulo' => $request->titulos[$index] ?? null,
                    'descricao' => $request->descricoes[$index] ?? null,
                    'ordem' => $index + 1,
                    'ativa' => true
                ]);
            }
        }

        return redirect()->back()->with('success', 'Imagens adicionadas à galeria com sucesso!');
    }

    public function update(Request $request, GaleriaSobre $galeriaSobre)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'ordem' => 'nullable|integer|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['titulo', 'descricao', 'ordem']);

        if ($request->hasFile('imagem')) {
            if ($galeriaSobre->imagem) {
                Storage::disk('public')->delete($galeriaSobre->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('galeria-sobre', 'public');
        }

        $galeriaSobre->update($data);

        return redirect()->back()->with('success', 'Imagem atualizada com sucesso!');
    }

    public function destroy(GaleriaSobre $galeriaSobre)
    {
        if ($galeriaSobre->imagem) {
            Storage::disk('public')->delete($galeriaSobre->imagem);
        }
        
        $galeriaSobre->delete();

        return redirect()->back()->with('success', 'Imagem removida da galeria com sucesso!');
    }

    public function toggleStatus(GaleriaSobre $galeriaSobre)
    {
        $galeriaSobre->update(['ativa' => !$galeriaSobre->ativa]);
        
        $status = $galeriaSobre->ativa ? 'ativada' : 'desativada';
        
        return redirect()->back()->with('success', "Imagem {$status} com sucesso!");
    }
}
