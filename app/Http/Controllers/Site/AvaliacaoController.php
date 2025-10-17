<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imovel_id' => 'required|exists:imoveis,id',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'avaliacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar se já existe uma avaliação deste IP para este imóvel
        $existingAvaliacao = Avaliacao::where('imovel_id', $request->imovel_id)
            ->where('ip_address', $request->ip())
            ->first();

        if ($existingAvaliacao) {
            return response()->json([
                'success' => false,
                'message' => 'Você já avaliou este imóvel'
            ], 422);
        }

        $avaliacao = Avaliacao::create([
            'imovel_id' => $request->imovel_id,
            'nome' => $request->nome,
            'email' => $request->email,
            'avaliacao' => $request->avaliacao,
            'comentario' => $request->comentario,
            'ip_address' => $request->ip(),
            'status' => 'pendente'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Avaliação enviada com sucesso! Ela será publicada após aprovação.',
            'avaliacao' => $avaliacao
        ]);
    }

    public function getAvaliacoes($imovelId)
    {
        $avaliacoes = Avaliacao::aprovado()
            ->porImovel($imovelId)
            ->recentes()
            ->paginate(5);

        return response()->json($avaliacoes);
    }
}
