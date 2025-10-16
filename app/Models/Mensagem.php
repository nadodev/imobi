<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $table = 'mensagens';

    protected $fillable = [
        'imovel_id',
        'nome',
        'email',
        'telefone',
        'assunto',
        'mensagem',
        'status',
        'resposta',
        'respondido_em',
        'respondido_por'
    ];

    protected $casts = [
        'respondido_em' => 'datetime',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    public function respondedor()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }

    // Scopes
    public function scopeNaoLida($query)
    {
        return $query->where('status', 'nao_lida');
    }

    public function scopeLida($query)
    {
        return $query->where('status', 'lida');
    }

    public function scopeRespondida($query)
    {
        return $query->where('status', 'respondida');
    }

    // Mutators
    public function marcarComoLida()
    {
        if ($this->status === 'nao_lida') {
            $this->update(['status' => 'lida']);
        }
    }
}

