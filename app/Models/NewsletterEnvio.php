<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsletterEnvio extends Model
{
    use HasFactory;

    protected $fillable = [
        'assunto',
        'conteudo',
        'tipo',
        'email_destino',
        'total_enviados',
        'total_entregues',
        'total_falhas',
        'status',
        'user_id',
        'enviado_em'
    ];

    protected $casts = [
        'enviado_em' => 'datetime',
        'total_enviados' => 'integer',
        'total_entregues' => 'integer',
        'total_falhas' => 'integer'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeConcluido($query)
    {
        return $query->where('status', 'concluido');
    }

    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }
}
