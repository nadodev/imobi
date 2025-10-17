<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensagemChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversa_id',
        'mensagem',
        'tipo',
        'lida',
        'lida_em',
        'user_id'
    ];

    protected $casts = [
        'lida' => 'boolean',
        'lida_em' => 'datetime',
    ];

    public function conversa(): BelongsTo
    {
        return $this->belongsTo(Conversa::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCliente($query)
    {
        return $query->where('tipo', 'cliente');
    }

    public function scopeAdmin($query)
    {
        return $query->where('tipo', 'admin');
    }

    public function scopeNaoLidas($query)
    {
        return $query->where('lida', false);
    }

    public function marcarComoLida()
    {
        $this->update([
            'lida' => true,
            'lida_em' => now()
        ]);
    }
}
