<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversa;
use App\Models\MensagemChat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function index()
    {
        $conversas = Conversa::with(['ultimaMensagem', 'mensagensNaoLidas'])
            ->orderBy('ultima_mensagem_em', 'desc')
            ->paginate(20);

        $conversasAtivas = Conversa::ativas()->count();
        $conversasEncerradas = Conversa::encerradas()->count();
        $mensagensNaoLidas = MensagemChat::naoLidas()->cliente()->count();

        return view('admin.chat.index', compact('conversas', 'conversasAtivas', 'conversasEncerradas', 'mensagensNaoLidas'));
    }

    public function show(Conversa $conversa)
    {
        $conversa->load(['mensagens' => function($query) {
            $query->orderBy('created_at', 'asc');
        }]);

        // Marcar mensagens como lidas
        $conversa->mensagens()->where('tipo', 'cliente')->update(['lida' => true]);

        return view('admin.chat.show', compact('conversa'));
    }

    public function enviarMensagem(Request $request): JsonResponse
    {
        try {
            // Verificar se o usuário está autenticado
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            $request->validate([
                'conversa_id' => 'required|exists:conversas,id',
                'mensagem' => 'required|string|max:1000',
            ]);

            $conversa = Conversa::findOrFail($request->conversa_id);

            $mensagem = MensagemChat::create([
                'conversa_id' => $conversa->id,
                'mensagem' => $request->mensagem,
                'tipo' => 'admin',
                'user_id' => auth()->id()
            ]);

            // Atualizar última mensagem da conversa
            $conversa->update([
                'ultima_mensagem_em' => now()
            ]);

            return response()->json([
                'success' => true,
                'mensagem' => [
                    'id' => $mensagem->id,
                    'mensagem' => $mensagem->mensagem,
                    'tipo' => $mensagem->tipo,
                    'timestamp' => $mensagem->created_at->format('H:i')
                ],
                'timestamp' => $mensagem->created_at->format('H:i')
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar mensagem do admin: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obterMensagens(Conversa $conversa): JsonResponse
    {
        $conversa->load('mensagens');
        
        return response()->json([
            'success' => true,
            'mensagens' => $conversa->mensagens->map(function ($mensagem) {
                return [
                    'id' => $mensagem->id,
                    'mensagem' => $mensagem->mensagem,
                    'tipo' => $mensagem->tipo,
                    'timestamp' => $mensagem->created_at->format('H:i'),
                    'data' => $mensagem->created_at->format('d/m/Y'),
                    'user_name' => $mensagem->user ? $mensagem->user->name : 'Admin'
                ];
            })
        ]);
    }

    public function verificarNovasMensagens(Conversa $conversa, Request $request): JsonResponse
    {
        $request->validate([
            'ultima_mensagem_id' => 'nullable|integer',
        ]);

        $query = $conversa->mensagens()->where('tipo', 'cliente');
        
        if ($request->ultima_mensagem_id) {
            $query->where('id', '>', $request->ultima_mensagem_id);
        }

        $novasMensagens = $query->get();

        // Marcar novas mensagens como lidas
        if ($novasMensagens->count() > 0) {
            $novasMensagens->each(function ($mensagem) {
                $mensagem->marcarComoLida();
            });
        }

        return response()->json([
            'success' => true,
            'novas_mensagens' => $novasMensagens->map(function ($mensagem) {
                return [
                    'id' => $mensagem->id,
                    'mensagem' => $mensagem->mensagem,
                    'tipo' => $mensagem->tipo,
                    'timestamp' => $mensagem->created_at->format('H:i'),
                    'data' => $mensagem->created_at->format('d/m/Y')
                ];
            }),
            'tem_novas' => $novasMensagens->count() > 0
        ]);
    }

    public function encerrarConversa(Conversa $conversa): JsonResponse
    {
        try {
            $conversa->update([
                'status' => 'encerrada',
                'encerrada_em' => now()
            ]);

            return response()->json([
                'success' => true,
                'mensagem' => 'Conversa encerrada com sucesso'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao encerrar conversa: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reativarConversa(Conversa $conversa): JsonResponse
    {
        $conversa->update([
            'status' => 'ativa',
            'encerrada_em' => null
        ]);

        return response()->json([
            'success' => true,
            'mensagem' => 'Conversa reativada com sucesso'
        ]);
    }

    public function dashboard()
    {
        $conversasAtivas = Conversa::ativas()->count();
        $conversasEncerradas = Conversa::encerradas()->count();
        $mensagensNaoLidas = MensagemChat::naoLidas()->cliente()->count();
        $conversasRecentes = Conversa::with('ultimaMensagem')
            ->orderBy('ultima_mensagem_em', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'conversas_ativas' => $conversasAtivas,
            'conversas_encerradas' => $conversasEncerradas,
            'mensagens_nao_lidas' => $mensagensNaoLidas,
            'conversas_recentes' => $conversasRecentes
        ]);
    }
}
