<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'imagem',
        'link',
        'posicao',
        'ordem',
        'ativo',
        'data_inicio',
        'data_fim'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];

    // Scope para banners ativos
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true)
                    ->where(function($q) {
                        $q->whereNull('data_inicio')
                          ->orWhere('data_inicio', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('data_fim')
                          ->orWhere('data_fim', '>=', now());
                    });
    }

    // Scope para banners por posição
    public function scopePorPosicao($query, $posicao)
    {
        return $query->where('posicao', $posicao);
    }

    // Scope para ordenar
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('created_at', 'desc');
    }
}
