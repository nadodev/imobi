<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'observacoes',
        'origem',
        'status',
        'tipo_interesse',
        'valor_interesse',
        'cidade_interesse',
        'bairro_interesse',
        'quartos_interesse',
        'banheiros_interesse',
        'imovel_id',
        'corretor_id',
        'user_id',
        'ultimo_contato',
        'proximo_followup'
    ];

    protected $casts = [
        'valor_interesse' => 'decimal:2',
        'ultimo_contato' => 'datetime',
        'proximo_followup' => 'datetime',
    ];

    // Relacionamentos
    public function imovel(): BelongsTo
    {
        return $this->belongsTo(Imovel::class);
    }

    public function corretor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'corretor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tarefas(): HasMany
    {
        return $this->hasMany(Tarefa::class);
    }

    // Scopes
    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePorOrigem($query, $origem)
    {
        return $query->where('origem', $origem);
    }

    public function scopePorCorretor($query, $corretorId)
    {
        return $query->where('corretor_id', $corretorId);
    }

    public function scopeComFollowupPendente($query)
    {
        return $query->where('proximo_followup', '<=', now());
    }

    // Métodos auxiliares
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'novo' => 'blue',
            'contatado' => 'yellow',
            'qualificado' => 'green',
            'proposta' => 'purple',
            'negociacao' => 'orange',
            'fechado' => 'green',
            'perdido' => 'red',
            default => 'gray'
        };
    }

    public function getOrigemIconAttribute()
    {
        return match($this->origem) {
            'site' => 'fas fa-globe',
            'whatsapp' => 'fab fa-whatsapp',
            'instagram' => 'fab fa-instagram',
            'facebook' => 'fab fa-facebook',
            'indicacao' => 'fas fa-users',
            default => 'fas fa-question'
        };
    }
}
