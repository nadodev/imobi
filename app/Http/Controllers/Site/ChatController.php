<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Conversa;
use App\Models\MensagemChat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function iniciarConversa(Request $request): JsonResponse
    {
        try {
            \Log::info('Chat iniciarConversa chamado', ['request' => $request->all()]);
            
            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'telefone' => 'nullable|string|max:20',
            ]);

        // Authentication is optional - handled by frontend

        // Verificar se já existe uma conversa ativa para este usuário ou IP
        $conversaExistente = Conversa::when(auth()->check(), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->when(!auth()->check(), function ($query) use ($request) {
                return $query->where('ip_address', $request->ip());
            })
            ->where('status', 'ativa')
            ->first();

        if ($conversaExistente) {
            return response()->json([
                'success' => true,
                'conversa_id' => $conversaExistente->id,
                'mensagem' => 'Conversa existente encontrada'
            ]);
        }

        // Criar nova conversa
        $conversa = Conversa::create([
            'nome_cliente' => $request->nome,
            'email_cliente' => $request->email,
            'telefone_cliente' => $request->telefone,
            'ip_address' => $request->ip(),
            'status' => 'ativa',
            'user_id' => auth()->id(), // Can be null for guests
        ]);

            return response()->json([
                'success' => true,
                'conversa_id' => $conversa->id,
                'mensagem' => 'Conversa iniciada com sucesso'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao iniciar conversa: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enviarMensagem(Request $request): JsonResponse
    {
        try {
            \Log::info('Chat enviarMensagem chamado', ['request' => $request->all()]);
            
            $request->validate([
                'conversa_id' => 'required|exists:conversas,id',
                'mensagem' => 'required|string|max:1000',
            ]);

        $conversa = Conversa::findOrFail($request->conversa_id);

        $mensagem = MensagemChat::create([
            'conversa_id' => $conversa->id,
            'mensagem' => $request->mensagem,
            'tipo' => 'cliente'
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
            \Log::error('Erro ao enviar mensagem: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obterMensagens(Request $request): JsonResponse
    {
        $request->validate([
            'conversa_id' => 'required|exists:conversas,id',
        ]);

        $conversa = Conversa::with('mensagens')->findOrFail($request->conversa_id);
        
        // Marcar mensagens como lidas
        $conversa->mensagens()->where('tipo', 'admin')->update(['lida' => true]);

        return response()->json([
            'success' => true,
            'mensagens' => $conversa->mensagens->map(function ($mensagem) {
                return [
                    'id' => $mensagem->id,
                    'mensagem' => $mensagem->mensagem,
                    'tipo' => $mensagem->tipo,
                    'timestamp' => $mensagem->created_at->format('H:i'),
                    'data' => $mensagem->created_at->format('d/m/Y')
                ];
            })
        ]);
    }

    public function verificarNovasMensagens(Request $request): JsonResponse
    {
        $request->validate([
            'conversa_id' => 'required|exists:conversas,id',
            'ultima_mensagem_id' => 'nullable|integer',
        ]);

        $conversa = Conversa::findOrFail($request->conversa_id);
        
        $query = $conversa->mensagens()->where('tipo', 'admin');
        
        if ($request->ultima_mensagem_id) {
            $query->where('id', '>', $request->ultima_mensagem_id);
        }

        $novasMensagens = $query->get();

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
            'tem_novas' => $novasMensagens->count() > 0,
            'conversa_encerrada' => $conversa->status === 'encerrada'
        ]);
    }

    public function encerrarConversaCliente(Request $request): JsonResponse
    {
        $request->validate([
            'conversa_id' => 'required|exists:conversas,id',
        ]);

        $conversa = Conversa::findOrFail($request->conversa_id);
        
        // Marcar conversa como encerrada
        $conversa->update(['status' => 'encerrada']);

        return response()->json([
            'success' => true,
            'mensagem' => 'Conversa encerrada com sucesso'
        ]);
    }
}
