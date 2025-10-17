<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $fillable = [
        'imovel_id', 'nome', 'email', 'avaliacao', 'comentario',
        'status', 'ip_address'
    ];

    public function imovel(): BelongsTo
    {
        return $this->belongsTo(Imovel::class);
    }

    // Scopes
    public function scopeAprovado($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopePorImovel($query, $imovelId)
    {
        return $query->where('imovel_id', $imovelId);
    }

    public function scopeRecentes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getEstrelasAttribute()
    {
        return str_repeat('★', $this->avaliacao) . str_repeat('☆', 5 - $this->avaliacao);
    }

    public function getAvaliacaoTextoAttribute()
    {
        return match($this->avaliacao) {
            1 => 'Muito Ruim',
            2 => 'Ruim',
            3 => 'Regular',
            4 => 'Bom',
            5 => 'Excelente',
            default => 'Não avaliado'
        };
    }
}
