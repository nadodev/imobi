<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'imovel_id',
        'nome_cliente',
        'telefone',
        'email',
        'data_visita',
        'horario_visita',
        'mensagem',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_visita' => 'date',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    // Scopes
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeConfirmado($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopeProximos($query)
    {
        return $query->where('data_visita', '>=', now()->format('Y-m-d'))
                     ->orderBy('data_visita')
                     ->orderBy('horario_visita');
    }

    // Accessors
    public function getDataFormatadaAttribute()
    {
        return Carbon::parse($this->data_visita)->format('d/m/Y');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pendente' => 'warning',
            'confirmado' => 'success',
            'cancelado' => 'danger',
            'realizado' => 'info'
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}

