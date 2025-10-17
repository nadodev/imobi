<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'nome',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'inscrito_em' => 'datetime'
    ];

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeInscrito($query)
    {
        return $query->whereNotNull('inscrito_em');
    }
}
