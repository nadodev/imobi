<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'telefone_cliente',
        'ip_address',
        'status',
        'ultima_mensagem_em',
        'user_id'
    ];

    protected $casts = [
        'ultima_mensagem_em' => 'datetime',
    ];

    public function mensagens(): HasMany
    {
        return $this->hasMany(MensagemChat::class)->orderBy('created_at', 'asc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ultimaMensagem()
    {
        return $this->hasOne(MensagemChat::class)->latest();
    }

    public function mensagensNaoLidas()
    {
        return $this->hasMany(MensagemChat::class)->where('lida', false)->where('tipo', 'cliente');
    }

    public function scopeAtivas($query)
    {
        return $query->where('status', 'ativa');
    }

    public function scopeEncerradas($query)
    {
        return $query->where('status', 'encerrada');
    }
}
