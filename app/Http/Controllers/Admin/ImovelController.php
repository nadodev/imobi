<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Tipo;
use App\Models\Finalidade;
use App\Models\ImagemImovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $imoveis = $query->latest()->paginate(15);
        $tipos = Tipo::orderBy('nome')->get();

        return view('admin.imoveis.index', compact('imoveis', 'tipos'));
    }

    public function create()
    {
        $tipos = Tipo::orderBy('nome')->get();
        $finalidades = Finalidade::orderBy('nome')->get();

        return view('admin.imoveis.create', compact('tipos', 'finalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo_id' => 'required|exists:tipos,id',
            'finalidade_id' => 'required|exists:finalidades,id',
            'preco' => 'required|numeric|min:0',
            'area_total' => 'nullable|numeric|min:0',
            'area_construida' => 'nullable|numeric|min:0',
            'quartos' => 'required|integer|min:0',
            'banheiros' => 'required|integer|min:0',
            'vagas' => 'required|integer|min:0',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:100',
            'bairro' => 'required|string|max:100',
            'cep' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:ativo,vendido,alugado,oculto',
            'destaque' => 'nullable|boolean',
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['destaque'] = $request->has('destaque');

        $imovel = Imovel::create($validated);

        // Upload de imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $index => $imagem) {
                $path = $imagem->store('imoveis', 'public');
                
                ImagemImovel::create([
                    'imovel_id' => $imovel->id,
                    'caminho' => $path,
                    'ordem' => $index
                ]);
            }
        }

        return redirect()->route('admin.imoveis.index')
            ->with('success', 'Imóvel cadastrado com sucesso!');
    }

    public function edit(Imovel $imovel)
    {
      
        $tipos = Tipo::orderBy('nome')->get();
        $finalidades = Finalidade::orderBy('nome')->get();

        return view('admin.imoveis.edit', compact('imovel', 'tipos', 'finalidades'));
    }

    public function update(Request $request, Imovel $imovel)
    {
        try {
            $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo_id' => 'required|exists:tipos,id',
            'finalidade_id' => 'required|exists:finalidades,id',
            'preco' => 'required|numeric|min:0',
            'area_total' => 'nullable|numeric|min:0',
            'area_construida' => 'nullable|numeric|min:0',
            'quartos' => 'required|integer|min:0',
            'banheiros' => 'required|integer|min:0',
            'vagas' => 'required|integer|min:0',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:100',
            'bairro' => 'required|string|max:100',
            'cep' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:ativo,vendido,alugado,oculto',
            'destaque' => 'nullable|boolean',
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $validated['destaque'] = $request->has('destaque');

        $imovel->update($validated);

        // Upload de novas imagens
        if ($request->hasFile('imagens')) {
            $ultimaOrdem = $imovel->imagens()->max('ordem') ?? 0;
            
            foreach ($request->file('imagens') as $index => $imagem) {
                $path = $imagem->store('imoveis', 'public');
                
                ImagemImovel::create([
                    'imovel_id' => $imovel->id,
                    'caminho' => $path,
                    'ordem' => $ultimaOrdem + $index + 1
                ]);
            }
        }

            return redirect()->back()
                ->with('success', 'Imóvel atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar imóvel: ' . $e->getMessage());
        }
    }

    public function destroy(Imovel $imovel)
    {
        // Deletar imagens do storage
        foreach ($imovel->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
        }

        $imovel->delete();

        return redirect()->route('admin.imoveis.index')
            ->with('success', 'Imóvel excluído com sucesso!');
    }

    public function deleteImage(Imovel $imovel, $id)
    {
        $imagem = ImagemImovel::findOrFail($id);
        Storage::disk('public')->delete($imagem->caminho);
        $imagem->delete();

        return back()->with('success', 'Imagem removida com sucesso!');
    }
}

