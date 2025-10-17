<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'prioridade',
        'status',
        'data_vencimento',
        'data_conclusao',
        'lead_id',
        'imovel_id',
        'user_id',
        'criado_por',
        'observacoes'
    ];

    protected $casts = [
        'data_vencimento' => 'datetime',
        'data_conclusao' => 'datetime',
    ];

    // Relacionamentos
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function imovel(): BelongsTo
    {
        return $this->belongsTo(Imovel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    // Scopes
    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePorPrioridade($query, $prioridade)
    {
        return $query->where('prioridade', $prioridade);
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeVencidas($query)
    {
        return $query->where('data_vencimento', '<', now())
                    ->where('status', '!=', 'concluida');
    }

    public function scopeVencendoHoje($query)
    {
        return $query->whereDate('data_vencimento', today())
                    ->where('status', '!=', 'concluida');
    }

    // Métodos auxiliares
    public function getPrioridadeColorAttribute()
    {
        return match($this->prioridade) {
            'baixa' => 'green',
            'media' => 'yellow',
            'alta' => 'orange',
            'urgente' => 'red',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pendente' => 'yellow',
            'em_andamento' => 'blue',
            'concluida' => 'green',
            'cancelada' => 'red',
            default => 'gray'
        };
    }

    public function getTipoIconAttribute()
    {
        return match($this->tipo) {
            'ligacao' => 'fas fa-phone',
            'email' => 'fas fa-envelope',
            'whatsapp' => 'fab fa-whatsapp',
            'visita' => 'fas fa-home',
            'proposta' => 'fas fa-file-contract',
            'followup' => 'fas fa-clock',
            default => 'fas fa-tasks'
        };
    }

    public function isVencida()
    {
        return $this->data_vencimento < now() && $this->status !== 'concluida';
    }

    public function isVencendoHoje()
    {
        return $this->data_vencimento->isToday() && $this->status !== 'concluida';
    }
}
