<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Agendamento;
use App\Models\Mensagem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_imoveis' => Imovel::count(),
            'imoveis_ativos' => Imovel::where('status', 'ativo')->count(),
            'imoveis_vendidos' => Imovel::where('status', 'vendido')->count(),
            'imoveis_alugados' => Imovel::where('status', 'alugado')->count(),
            'agendamentos_pendentes' => Agendamento::where('status', 'pendente')->count(),
            'mensagens_nao_lidas' => Mensagem::where('status', 'nao_lida')->count(),
        ];

        $ultimosAgendamentos = Agendamento::with('imovel')
            ->latest()
            ->take(5)
            ->get();

        $ultimasMensagens = Mensagem::latest()
            ->take(5)
            ->get();

        $imoveisRecentes = Imovel::with(['tipo', 'finalidade', 'imagemPrincipal'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'ultimosAgendamentos',
            'ultimasMensagens',
            'imoveisRecentes'
        ));
    }
}

