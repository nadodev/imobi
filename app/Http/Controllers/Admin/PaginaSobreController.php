<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaginaSobre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaginaSobreController extends Controller
{
    public function index()
    {
        $paginaSobre = PaginaSobre::first();
        
        if (!$paginaSobre) {
            return redirect()->route('admin.pagina-sobre.create');
        }
        
        return redirect()->route('admin.pagina-sobre.edit', $paginaSobre);
    }

    public function create()
    {
        return view('admin.pagina-sobre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo_principal' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:500',
            'descricao_principal' => 'required|string',
            'missao' => 'nullable|string',
            'visao' => 'nullable|string',
            'valores' => 'nullable|string',
            'imagem_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagem_equipe' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:500',
            'anos_mercado' => 'nullable|integer|min:0',
            'imoveis_vendidos' => 'nullable|integer|min:0',
            'clientes_atendidos' => 'nullable|integer|min:0',
            'equipe_profissionais' => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'titulo_principal', 'subtitulo', 'descricao_principal',
            'missao', 'visao', 'valores'
        ]);

        // Upload de imagens
        if ($request->hasFile('imagem_principal')) {
            $data['imagem_principal'] = $request->file('imagem_principal')->store('pagina-sobre', 'public');
        }

        if ($request->hasFile('imagem_equipe')) {
            $data['imagem_equipe'] = $request->file('imagem_equipe')->store('pagina-sobre', 'public');
        }

        // Dados da empresa
        $data['dados_empresa'] = [
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
        ];

        // Estatísticas
        $data['estatisticas'] = [
            'anos_mercado' => $request->anos_mercado,
            'imoveis_vendidos' => $request->imoveis_vendidos,
            'clientes_atendidos' => $request->clientes_atendidos,
            'equipe_profissionais' => $request->equipe_profissionais,
        ];

        $data['ativa'] = true;

        PaginaSobre::create($data);

        return redirect()->route('admin.pagina-sobre.index')
            ->with('success', 'Página Sobre criada com sucesso!');
    }

    public function edit(PaginaSobre $paginaSobre)
    {
        return view('admin.pagina-sobre.edit', compact('paginaSobre'));
    }

    public function update(Request $request, PaginaSobre $paginaSobre)
    {
        $request->validate([
            'titulo_principal' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:500',
            'descricao_principal' => 'required|string',
            'missao' => 'nullable|string',
            'visao' => 'nullable|string',
            'valores' => 'nullable|string',
            'imagem_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagem_equipe' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:500',
            'anos_mercado' => 'nullable|integer|min:0',
            'imoveis_vendidos' => 'nullable|integer|min:0',
            'clientes_atendidos' => 'nullable|integer|min:0',
            'equipe_profissionais' => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'titulo_principal', 'subtitulo', 'descricao_principal',
            'missao', 'visao', 'valores'
        ]);

        // Upload de imagens
        if ($request->hasFile('imagem_principal')) {
            if ($paginaSobre->imagem_principal) {
                Storage::disk('public')->delete($paginaSobre->imagem_principal);
            }
            $data['imagem_principal'] = $request->file('imagem_principal')->store('pagina-sobre', 'public');
        }

        if ($request->hasFile('imagem_equipe')) {
            if ($paginaSobre->imagem_equipe) {
                Storage::disk('public')->delete($paginaSobre->imagem_equipe);
            }
            $data['imagem_equipe'] = $request->file('imagem_equipe')->store('pagina-sobre', 'public');
        }

        // Dados da empresa
        $data['dados_empresa'] = [
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
        ];

        // Estatísticas
        $data['estatisticas'] = [
            'anos_mercado' => $request->anos_mercado,
            'imoveis_vendidos' => $request->imoveis_vendidos,
            'clientes_atendidos' => $request->clientes_atendidos,
            'equipe_profissionais' => $request->equipe_profissionais,
        ];

        $paginaSobre->update($data);

        return redirect()->route('admin.pagina-sobre.edit', $paginaSobre)
            ->with('success', 'Página Sobre atualizada com sucesso!');
    }

    public function toggleStatus(PaginaSobre $paginaSobre)
    {
        $paginaSobre->update(['ativa' => !$paginaSobre->ativa]);
        
        $status = $paginaSobre->ativa ? 'ativada' : 'desativada';
        
        return redirect()->back()
            ->with('success', "Página Sobre {$status} com sucesso!");
    }
}
