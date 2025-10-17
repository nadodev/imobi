<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\User;
use App\Models\Visualizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestaoImovelController extends Controller
{
    /**
     * Lista de imóveis com gestão
     */
    public function index(Request $request)
    {
        $query = Imovel::with(['tipo', 'finalidade', 'corretorResponsavel', 'visualizacoes']);
        
        // Filtros
        if ($request->filled('status_gestao')) {
            $query->porStatusGestao($request->status_gestao);
        }
        
        if ($request->filled('corretor_responsavel')) {
            $query->porCorretor($request->corretor_responsavel);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%");
            });
        }
        
        $imoveis = $query->latest()->paginate(20);
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        
        return view('admin.gestao-imoveis.index', compact('imoveis', 'corretores'));
    }
    
    /**
     * Detalhes do imóvel com métricas
     */
    public function show(Imovel $imovel)
    {
        $imovel->load(['tipo', 'finalidade', 'corretorResponsavel', 'imagens', 'visualizacoes', 'leads', 'tarefas']);
        
        // Métricas do imóvel
        $totalVisualizacoes = $imovel->visualizacoes()->count();
        $visualizacoesHoje = $imovel->visualizacoes()->hoje()->count();
        $visualizacoesEstaSemana = $imovel->visualizacoes()->estaSemana()->count();
        $visualizacoesEsteMes = $imovel->visualizacoes()->esteMes()->count();
        
        // Visualizações por origem
        $visualizacoesPorOrigem = $imovel->visualizacoes()
            ->select('origem', DB::raw('count(*) as total'))
            ->groupBy('origem')
            ->get()
            ->pluck('total', 'origem');
        
        // Leads gerados
        $totalLeads = $imovel->leads()->count();
        $leadsPorStatus = $imovel->leads()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');
        
        // Tarefas relacionadas
        $tarefasPendentes = $imovel->tarefas()
            ->where('status', '!=', 'concluida')
            ->with(['user', 'lead'])
            ->latest('data_vencimento')
            ->get();
        
        // Histórico de visualizações (últimos 30 dias)
        $historicoVisualizacoes = $imovel->visualizacoes()
            ->select(DB::raw('DATE(visualizado_em) as data'), DB::raw('count(*) as total'))
            ->where('visualizado_em', '>=', now()->subDays(30))
            ->groupBy('data')
            ->orderBy('data')
            ->get();
        
        return view('admin.gestao-imoveis.show', compact(
            'imovel', 'totalVisualizacoes', 'visualizacoesHoje', 
            'visualizacoesEstaSemana', 'visualizacoesEsteMes',
            'visualizacoesPorOrigem', 'totalLeads', 'leadsPorStatus',
            'tarefasPendentes', 'historicoVisualizacoes'
        ));
    }
    
    /**
     * Editar gestão do imóvel
     */
    public function edit(Imovel $imovel)
    {
        $corretores = User::where('tipo_usuario', 'corretor')->get();
        
        return view('admin.gestao-imoveis.edit', compact('imovel', 'corretores'));
    }
    
    /**
     * Atualizar gestão do imóvel
     */
    public function update(Request $request, Imovel $imovel)
    {
        $validated = $request->validate([
            'status_gestao' => 'required|in:livre,reservado,vendido,alugado,indisponivel',
            'numero_chaves' => 'nullable|string|max:255',
            'localizacao_chaves' => 'nullable|string|max:255',
            'data_revisao_contrato' => 'nullable|date',
            'data_vencimento_aluguel' => 'nullable|date',
            'observacoes_gestao' => 'nullable|string',
            'corretor_responsavel' => 'nullable|exists:users,id',
        ]);
        
        $imovel->update($validated);
        
        return redirect()->route('admin.gestao-imoveis.show', $imovel)
            ->with('success', 'Gestão do imóvel atualizada com sucesso!');
    }
    
    /**
     * Relatório de performance do imóvel
     */
    public function relatorio(Imovel $imovel, Request $request)
    {
        $periodo = $request->get('periodo', '30'); // dias
        
        // Visualizações por período
        $visualizacoesPorPeriodo = $imovel->visualizacoes()
            ->select(DB::raw('DATE(visualizado_em) as data'), DB::raw('count(*) as total'))
            ->where('visualizado_em', '>=', now()->subDays($periodo))
            ->groupBy('data')
            ->orderBy('data')
            ->get();
        
        // Visualizações por origem
        $visualizacoesPorOrigem = $imovel->visualizacoes()
            ->select('origem', DB::raw('count(*) as total'))
            ->where('visualizado_em', '>=', now()->subDays($periodo))
            ->groupBy('origem')
            ->orderBy('total', 'desc')
            ->get();
        
        // Leads gerados por período
        $leadsPorPeriodo = $imovel->leads()
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays($periodo))
            ->groupBy('data')
            ->orderBy('data')
            ->get();
        
        // Conversão por origem
        $conversaoPorOrigem = [];
        $origens = ['site', 'whatsapp', 'instagram', 'facebook', 'google'];
        
        foreach ($origens as $origem) {
            $visualizacoes = $imovel->visualizacoes()
                ->porOrigem($origem)
                ->where('visualizado_em', '>=', now()->subDays($periodo))
                ->count();
            
            $leads = $imovel->leads()
                ->porOrigem($origem)
                ->where('created_at', '>=', now()->subDays($periodo))
                ->count();
            
            $conversaoPorOrigem[$origem] = [
                'visualizacoes' => $visualizacoes,
                'leads' => $leads,
                'taxa_conversao' => $visualizacoes > 0 ? ($leads / $visualizacoes) * 100 : 0
            ];
        }
        
        // Comparação com outros imóveis - simplificado
        $totalImoveis = Imovel::count();
        $totalVisualizacoesTodos = Visualizacao::where('visualizado_em', '>=', now()->subDays($periodo))->count();
        $mediaVisualizacoes = $totalImoveis > 0 ? $totalVisualizacoesTodos / $totalImoveis : 0;
        
        // Ranking simplificado
        $visualizacoesImovel = $imovel->visualizacoes()->where('visualizado_em', '>=', now()->subDays($periodo))->count();
        $imoveisComMaisVisualizacoes = Imovel::whereHas('visualizacoes', function($query) use ($periodo) {
            $query->where('visualizado_em', '>=', now()->subDays($periodo));
        })->get()->filter(function($i) use ($periodo, $visualizacoesImovel) {
            return $i->visualizacoes()->where('visualizado_em', '>=', now()->subDays($periodo))->count() > $visualizacoesImovel;
        })->count();
        
        $posicaoRanking = $imoveisComMaisVisualizacoes + 1;
        
        return view('admin.gestao-imoveis.relatorio', compact(
            'imovel', 'visualizacoesPorPeriodo', 'visualizacoesPorOrigem',
            'leadsPorPeriodo', 'conversaoPorOrigem', 'mediaVisualizacoes',
            'posicaoRanking', 'periodo'
        ));
    }
    
    /**
     * Dashboard de gestão geral
     */
    public function dashboard()
    {
        // Resumo geral
        $totalImoveis = Imovel::count();
        $imoveisLivres = Imovel::porStatusGestao('livre')->count();
        $imoveisReservados = Imovel::porStatusGestao('reservado')->count();
        $imoveisVendidos = Imovel::porStatusGestao('vendido')->count();
        $imoveisAlugados = Imovel::porStatusGestao('alugado')->count();
        
        // Contratos vencendo
        $contratosVencendo = Imovel::comContratoVencendo(30)->count();
        $contratosVencendoHoje = Imovel::comContratoVencendo(0)->count();
        
        // Imóveis mais visualizados
        $imoveisMaisVisualizados = Imovel::with('visualizacoes')
            ->get()
            ->sortByDesc(function($imovel) {
                return $imovel->visualizacoes instanceof \Illuminate\Database\Eloquent\Collection ? $imovel->visualizacoes->count() : 0;
            })
            ->take(10);
        
        // Performance por corretor
        $performanceCorretores = User::where('tipo_usuario', 'corretor')
            ->withCount(['imoveis as imoveis_total', 'imoveis as imoveis_vendidos' => function($query) {
                $query->where('status_gestao', 'vendido');
            }])
            ->get();
        
        // Status de gestão
        $statusGestao = [
            'livre' => Imovel::porStatusGestao('livre')->count(),
            'reservado' => Imovel::porStatusGestao('reservado')->count(),
            'vendido' => Imovel::porStatusGestao('vendido')->count(),
            'alugado' => Imovel::porStatusGestao('alugado')->count(),
            'indisponivel' => Imovel::porStatusGestao('indisponivel')->count(),
        ];
        
        return view('admin.gestao-imoveis.dashboard', compact(
            'totalImoveis', 'imoveisLivres', 'imoveisReservados', 
            'imoveisVendidos', 'imoveisAlugados', 'contratosVencendo',
            'contratosVencendoHoje', 'imoveisMaisVisualizados', 
            'performanceCorretores', 'statusGestao'
        ));
    }
}
