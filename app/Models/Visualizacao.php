<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visualizacao extends Model
{
    protected $fillable = [
        'imovel_id',
        'ip_address',
        'user_agent',
        'referer',
        'origem',
        'cidade',
        'estado',
        'pais',
        'visualizado_em'
    ];

    protected $casts = [
        'visualizado_em' => 'datetime',
    ];

    // Relacionamentos
    public function imovel(): BelongsTo
    {
        return $this->belongsTo(Imovel::class);
    }

    // Scopes
    public function scopePorOrigem($query, $origem)
    {
        return $query->where('origem', $origem);
    }

    public function scopePorPeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('visualizado_em', [$inicio, $fim]);
    }

    public function scopePorImovel($query, $imovelId)
    {
        return $query->where('imovel_id', $imovelId);
    }

    public function scopeHoje($query)
    {
        return $query->whereDate('visualizado_em', today());
    }

    public function scopeEstaSemana($query)
    {
        return $query->whereBetween('visualizado_em', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeEsteMes($query)
    {
        return $query->whereMonth('visualizado_em', now()->month)
                    ->whereYear('visualizado_em', now()->year);
    }

    // Métodos auxiliares
    public function getOrigemIconAttribute()
    {
        return match($this->origem) {
            'site' => 'fas fa-globe',
            'whatsapp' => 'fab fa-whatsapp',
            'instagram' => 'fab fa-instagram',
            'facebook' => 'fab fa-facebook',
            'google' => 'fab fa-google',
            default => 'fas fa-question'
        };
    }

    public function getOrigemColorAttribute()
    {
        return match($this->origem) {
            'site' => 'blue',
            'whatsapp' => 'green',
            'instagram' => 'pink',
            'facebook' => 'blue',
            'google' => 'red',
            default => 'gray'
        };
    }
}
