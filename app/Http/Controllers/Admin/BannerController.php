<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('ordem')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'posicao' => 'required|in:hero,sidebar,footer',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'nullable|boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after:data_inicio'
        ]);

        // Upload da imagem
        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('banners', 'public');
        }

        $validated['ativo'] = $request->has('ativo');
        $validated['ordem'] = $validated['ordem'] ?? 0;

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'posicao' => 'required|in:hero,sidebar,footer',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'nullable|boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after:data_inicio'
        ]);

        // Upload da nova imagem se fornecida
        if ($request->hasFile('imagem')) {
            // Deletar imagem antiga
            if ($banner->imagem) {
                Storage::disk('public')->delete($banner->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('banners', 'public');
        }

        $validated['ativo'] = $request->has('ativo');
        $validated['ordem'] = $validated['ordem'] ?? 0;

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Deletar imagem
        if ($banner->imagem) {
            Storage::disk('public')->delete($banner->imagem);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner excluído com sucesso!');
    }
}
