<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Imovel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'imovel_id' => 'required|exists:imoveis,id',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado para favoritar imóveis',
                'requires_auth' => true
            ], 401);
        }

        $userId = auth()->id();
        $imovelId = $request->imovel_id;

        $favorito = Favorito::where('user_id', $userId)
            ->where('imovel_id', $imovelId)
            ->first();

        if ($favorito) {
            // Remover dos favoritos
            $favorito->delete();
            $isFavorito = false;
            $message = 'Imóvel removido dos favoritos';
        } else {
            // Adicionar aos favoritos
            Favorito::create([
                'user_id' => $userId,
                'imovel_id' => $imovelId,
            ]);
            $isFavorito = true;
            $message = 'Imóvel adicionado aos favoritos';
        }

        return response()->json([
            'success' => true,
            'is_favorito' => $isFavorito,
            'message' => $message
        ]);
    }

    public function index()
    {
        $favoritos = auth()->user()->imoveisFavoritos()
            ->with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->paginate(12);

        return view('site.favoritos.index', compact('favoritos'));
    }

    public function check(Imovel $imovel): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'is_favorito' => false
            ], 401);
        }

        $isFavorito = Favorito::where('user_id', auth()->id())
            ->where('imovel_id', $imovel->id)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorito' => $isFavorito
        ]);
    }

    public function destroy(Imovel $imovel): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado'
            ], 401);
        }

        $favorito = Favorito::where('user_id', auth()->id())
            ->where('imovel_id', $imovel->id)
            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json([
                'success' => true,
                'message' => 'Imóvel removido dos favoritos'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Imóvel não encontrado nos favoritos'
        ], 404);
    }
}
