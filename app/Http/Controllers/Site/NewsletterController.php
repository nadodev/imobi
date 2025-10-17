<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function inscrever(Request $request)
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

        return response()->json([
            'success' => true,
            'message' => 'Inscrição realizada com sucesso! Você receberá nossas melhores ofertas.'
        ]);
    }
}
