<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Tarefa;
use App\Models\Imovel;
use App\Models\Visualizacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CRMController extends Controller
{
    /**
     * Dashboard principal do CRM
     */
    public function dashboard()
    {
        // Métricas gerais
        $totalLeads = Lead::count();
        $leadsNovos = Lead::porStatus('novo')->count();
        $leadsQualificados = Lead::porStatus('qualificado')->count();
        $leadsFechados = Lead::porStatus('fechado')->count();
        
        // Tarefas pendentes
        $tarefasPendentes = Tarefa::porStatus('pendente')->count();
        $tarefasVencidas = Tarefa::vencidas()->count();
        $tarefasHoje = Tarefa::vencendoHoje()->count();
        
        // Visualizações
        $visualizacoesHoje = Visualizacao::hoje()->count();
        $visualizacoesEstaSemana = Visualizacao::estaSemana()->count();
        $visualizacoesEsteMes = Visualizacao::esteMes()->count();
        
        // Funil de vendas
        $funilVendas = [
            'novo' => Lead::porStatus('novo')->count(),
            'contatado' => Lead::porStatus('contatado')->count(),
            'qualificado' => Lead::porStatus('qualificado')->count(),
            'proposta' => Lead::porStatus('proposta')->count(),
            'negociacao' => Lead::porStatus('negociacao')->count(),
            'fechado' => Lead::porStatus('fechado')->count(),
            'perdido' => Lead::porStatus('perdido')->count(),
        ];
        
        // Leads por origem
        $leadsPorOrigem = Lead::select('origem', DB::raw('count(*) as total'))
            ->groupBy('origem')
            ->get()
            ->pluck('total', 'origem');
        
        // Imóveis mais visualizados
        $imoveisMaisVisualizados = Imovel::withCount('visualizacoes')
            ->orderBy('visualizacoes_count', 'desc')
            ->take(5)
            ->get();
        
        // Leads recentes
        $leadsRecentes = Lead::with(['imovel', 'corretor'])
            ->latest()
            ->take(10)
            ->get();
        
        // Tarefas urgentes
        $tarefasUrgentes = Tarefa::with(['lead', 'imovel', 'user'])
            ->where('data_vencimento', '<=', now()->addDays(3))
            ->where('status', '!=', 'concluida')
            ->orderBy('data_vencimento')
            ->take(10)
            ->get();
        
        // Performance por corretor
        $performanceCorretores = User::where('tipo_usuario', 'corretor')
            ->withCount(['leads as leads_total', 'leads as leads_fechados' => function($query) {
                $query->where('status', 'fechado');
            }])
            ->get();
        
        return view('admin.crm.dashboard', compact(
            'totalLeads', 'leadsNovos', 'leadsQualificados', 'leadsFechados',
            'tarefasPendentes', 'tarefasVencidas', 'tarefasHoje',
            'visualizacoesHoje', 'visualizacoesEstaSemana', 'visualizacoesEsteMes',
            'funilVendas', 'leadsPorOrigem', 'imoveisMaisVisualizados',
            'leadsRecentes', 'tarefasUrgentes', 'performanceCorretores'
        ));
    }
    
    /**
     * Lista de leads
     */
    public function leads(Request $request)
    {
        $query = Lead::with(['imovel', 'corretor', 'user']);
        
        // Filtros
        if ($request->filled('status')) {
            $query->porStatus($request->status);
        }
        
        if ($request->filled('origem')) {
            $query->porOrigem($request->origem);
        }
        
        if ($request->filled('corretor_id')) {
            $query->porCorretor($request->corretor_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }
        
        $leads = $query->latest()->paginate(20);
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        
        return view('admin.crm.leads.index', compact('leads', 'corretores'));
    }
    
    /**
     * Criar novo lead
     */
    public function createLead()
    {
        $imoveis = Imovel::ativo()->get();
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        
        return view('admin.crm.leads.create', compact('imoveis', 'corretores'));
    }
    
    /**
     * Salvar novo lead
     */
    public function storeLead(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'observacoes' => 'nullable|string',
            'origem' => 'required|in:site,whatsapp,instagram,facebook,indicacao,outro',
            'status' => 'required|in:novo,contatado,qualificado,proposta,negociacao,fechado,perdido',
            'tipo_interesse' => 'nullable|in:compra,venda,aluguel,locacao',
            'valor_interesse' => 'nullable|numeric|min:0',
            'cidade_interesse' => 'nullable|string|max:255',
            'bairro_interesse' => 'nullable|string|max:255',
            'quartos_interesse' => 'nullable|integer|min:0',
            'banheiros_interesse' => 'nullable|integer|min:0',
            'imovel_id' => 'nullable|exists:imoveis,id',
            'corretor_id' => 'nullable|exists:users,id',
            'proximo_followup' => 'nullable|date|after:now',
        ]);
        
        $validated['user_id'] = auth()->id();
        
        Lead::create($validated);
        
        return redirect()->route('admin.crm.leads')
            ->with('success', 'Lead criado com sucesso!');
    }
    
    /**
     * Editar lead
     */
    public function editLead(Lead $lead)
    {
        $imoveis = Imovel::ativo()->get();
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        
        return view('admin.crm.leads.edit', compact('lead', 'imoveis', 'corretores'));
    }
    
    /**
     * Atualizar lead
     */
    public function updateLead(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'observacoes' => 'nullable|string',
            'origem' => 'required|in:site,whatsapp,instagram,facebook,indicacao,outro',
            'status' => 'required|in:novo,contatado,qualificado,proposta,negociacao,fechado,perdido',
            'tipo_interesse' => 'nullable|in:compra,venda,aluguel,locacao',
            'valor_interesse' => 'nullable|numeric|min:0',
            'cidade_interesse' => 'nullable|string|max:255',
            'bairro_interesse' => 'nullable|string|max:255',
            'quartos_interesse' => 'nullable|integer|min:0',
            'banheiros_interesse' => 'nullable|integer|min:0',
            'imovel_id' => 'nullable|exists:imoveis,id',
            'corretor_id' => 'nullable|exists:users,id',
            'ultimo_contato' => 'nullable|date',
            'proximo_followup' => 'nullable|date',
        ]);
        
        $lead->update($validated);
        
        return redirect()->route('admin.crm.leads')
            ->with('success', 'Lead atualizado com sucesso!');
    }
    
    /**
     * Excluir lead
     */
    public function destroyLead(Lead $lead)
    {
        $lead->delete();
        
        return redirect()->route('admin.crm.leads')
            ->with('success', 'Lead excluído com sucesso!');
    }
    
    /**
     * Lista de tarefas
     */
    public function tarefas(Request $request)
    {
        $query = Tarefa::with(['lead', 'imovel', 'user', 'criadoPor']);
        
        // Filtros
        if ($request->filled('status')) {
            $query->porStatus($request->status);
        }
        
        if ($request->filled('prioridade')) {
            $query->porPrioridade($request->prioridade);
        }
        
        if ($request->filled('user_id')) {
            $query->porUsuario($request->user_id);
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        $tarefas = $query->latest('data_vencimento')->paginate(20);
        $usuarios = User::whereIn('tipo_usuario', ['admin', 'corretor'])->get();
        
        return view('admin.crm.tarefas.index', compact('tarefas', 'usuarios'));
    }
    
    /**
     * Criar nova tarefa
     */
    public function createTarefa()
    {
        $leads = Lead::all();
        $imoveis = Imovel::ativo()->get();
        $usuarios = User::whereIn('tipo_usuario', ['admin', 'corretor'])->get();
        
        return view('admin.crm.tarefas.create', compact('leads', 'imoveis', 'usuarios'));
    }
    
    /**
     * Salvar nova tarefa
     */
    public function storeTarefa(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:ligacao,email,whatsapp,visita,proposta,followup,outro',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'data_vencimento' => 'required|date|after:now',
            'lead_id' => 'nullable|exists:leads,id',
            'imovel_id' => 'nullable|exists:imoveis,id',
            'user_id' => 'required|exists:users,id',
            'observacoes' => 'nullable|string',
        ]);
        
        $validated['criado_por'] = auth()->id();
        
        Tarefa::create($validated);
        
        return redirect()->route('admin.crm.tarefas')
            ->with('success', 'Tarefa criada com sucesso!');
    }
    
    /**
     * Marcar tarefa como concluída
     */
    public function concluirTarefa(Tarefa $tarefa)
    {
        $tarefa->update([
            'status' => 'concluida',
            'data_conclusao' => now()
        ]);
        
        return redirect()->back()
            ->with('success', 'Tarefa marcada como concluída!');
    }
    
    /**
     * Funil de vendas
     */
    public function funilVendas()
    {
        $funil = [
            'novo' => Lead::porStatus('novo')->with(['imovel', 'corretor'])->get(),
            'contatado' => Lead::porStatus('contatado')->with(['imovel', 'corretor'])->get(),
            'qualificado' => Lead::porStatus('qualificado')->with(['imovel', 'corretor'])->get(),
            'proposta' => Lead::porStatus('proposta')->with(['imovel', 'corretor'])->get(),
            'negociacao' => Lead::porStatus('negociacao')->with(['imovel', 'corretor'])->get(),
            'fechado' => Lead::porStatus('fechado')->with(['imovel', 'corretor'])->get(),
            'perdido' => Lead::porStatus('perdido')->with(['imovel', 'corretor'])->get(),
        ];
        
        return view('admin.crm.funil', compact('funil'));
    }
    
    /**
     * Relatórios de performance
     */
    public function relatorios(Request $request)
    {
        $periodo = $request->get('periodo', '30'); // dias
        
        // Performance por imóvel
        $performanceImoveis = Imovel::withCount(['visualizacoes', 'leads'])
            ->with(['visualizacoes' => function($query) use ($periodo) {
                $query->where('visualizado_em', '>=', now()->subDays($periodo));
            }])
            ->orderBy('visualizacoes_count', 'desc')
            ->get();
        
        // Performance por origem
        $performanceOrigem = Visualizacao::select('origem', DB::raw('count(*) as total'))
            ->where('visualizado_em', '>=', now()->subDays($periodo))
            ->groupBy('origem')
            ->orderBy('total', 'desc')
            ->get();
        
        // Performance por corretor
        $performanceCorretores = User::where('tipo_usuario', 'corretor')
            ->withCount(['leads as leads_total', 'leads as leads_fechados' => function($query) {
                $query->where('status', 'fechado');
            }])
            ->with(['leads' => function($query) use ($periodo) {
                $query->where('created_at', '>=', now()->subDays($periodo));
            }])
            ->get();
        
        // Conversão por canal
        $conversaoCanal = [];
        $origens = ['site', 'whatsapp', 'instagram', 'facebook', 'google'];
        
        foreach ($origens as $origem) {
            $visualizacoes = Visualizacao::porOrigem($origem)
                ->where('visualizado_em', '>=', now()->subDays($periodo))
                ->count();
            
            $leads = Lead::porOrigem($origem)
                ->where('created_at', '>=', now()->subDays($periodo))
                ->count();
            
            $conversaoCanal[$origem] = [
                'visualizacoes' => $visualizacoes,
                'leads' => $leads,
                'taxa_conversao' => $visualizacoes > 0 ? ($leads / $visualizacoes) * 100 : 0
            ];
        }
        
        return view('admin.crm.relatorios', compact(
            'performanceImoveis', 'performanceOrigem', 'performanceCorretores', 
            'conversaoCanal', 'periodo'
        ));
    }
}