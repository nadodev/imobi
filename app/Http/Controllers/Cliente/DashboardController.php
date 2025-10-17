<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Conversa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user's conversations
        $conversas = Conversa::where('user_id', auth()->id())
            ->with(['ultimaMensagem'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.dashboard', compact('conversas'));
    }
}
