<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterEnvio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->paginate(20);
        $totalInscritos = Newsletter::ativo()->count();
        $envios = NewsletterEnvio::with('user')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.newsletter.index', compact('newsletters', 'totalInscritos', 'envios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'nome' => 'nullable|string|max:255'
        ]);

        Newsletter::create([
            'email' => $request->email,
            'nome' => $request->nome,
            'ativo' => true,
            'inscrito_em' => now()
        ]);

        return redirect()->back()->with('success', 'Email adicionado à newsletter com sucesso!');
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->back()->with('success', 'Email removido da newsletter com sucesso!');
    }

    public function toggleStatus(Newsletter $newsletter)
    {
        $newsletter->update(['ativo' => !$newsletter->ativo]);
        
        $status = $newsletter->ativo ? 'ativado' : 'desativado';
        return redirect()->back()->with('success', "Email {$status} com sucesso!");
    }

    public function showEnvioForm()
    {
        $totalInscritos = Newsletter::ativo()->count();
        $emailsCadastrados = Newsletter::ativo()->orderBy('email')->get();
        return view('admin.newsletter.enviar', compact('totalInscritos', 'emailsCadastrados'));
    }

    public function enviarNewsletter(Request $request)
    {
        $request->validate([
            'assunto' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'tipo' => 'required|in:individual,todos',
            'email_destino' => 'required_if:tipo,individual|email|nullable'
        ]);

        // Criar registro do envio
        $envio = NewsletterEnvio::create([
            'assunto' => $request->assunto,
            'conteudo' => $request->conteudo,
            'tipo' => $request->tipo,
            'email_destino' => $request->tipo === 'individual' ? $request->email_destino : null,
            'user_id' => auth()->id(),
            'status' => 'pendente'
        ]);

        if ($request->tipo === 'individual') {
            // Enviar para email específico
            $this->enviarEmailIndividual($request->email_destino, $request->assunto, $request->conteudo, $envio);
        } else {
            // Enviar para todos
            $this->enviarParaTodos($request->assunto, $request->conteudo, $envio);
        }

        return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter enviada com sucesso!');
    }

    private function enviarEmailIndividual($email, $assunto, $conteudo, $envio)
    {
        try {
            Mail::raw($conteudo, function ($message) use ($email, $assunto) {
                $message->to($email)
                        ->subject($assunto);
            });

            $envio->update([
                'status' => 'concluido',
                'total_enviados' => 1,
                'total_entregues' => 1,
                'enviado_em' => now()
            ]);
        } catch (\Exception $e) {
            $envio->update([
                'status' => 'erro',
                'total_enviados' => 1,
                'total_falhas' => 1
            ]);
        }
    }

    private function enviarParaTodos($assunto, $conteudo, $envio)
    {
        $emails = Newsletter::ativo()->get();
        $totalEnviados = 0;
        $totalEntregues = 0;
        $totalFalhas = 0;

        $envio->update(['status' => 'enviando']);

        foreach ($emails as $newsletter) {
            try {
                Mail::raw($conteudo, function ($message) use ($newsletter, $assunto) {
                    $message->to($newsletter->email)
                            ->subject($assunto);
                });
                $totalEntregues++;
            } catch (\Exception $e) {
                $totalFalhas++;
            }
            $totalEnviados++;
        }

        $envio->update([
            'status' => 'concluido',
            'total_enviados' => $totalEnviados,
            'total_entregues' => $totalEntregues,
            'total_falhas' => $totalFalhas,
            'enviado_em' => now()
        ]);
    }

    public function showEnvio(NewsletterEnvio $envio)
    {
        return view('admin.newsletter.show-envio', compact('envio'));
    }
}
