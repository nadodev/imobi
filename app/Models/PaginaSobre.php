<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaginaSobre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo_principal',
        'subtitulo',
        'descricao_principal',
        'missao',
        'visao',
        'valores',
        'imagem_principal',
        'imagem_equipe',
        'dados_empresa',
        'estatisticas',
        'ativa'
    ];

    protected $casts = [
        'dados_empresa' => 'array',
        'estatisticas' => 'array',
        'ativa' => 'boolean'
    ];

    // Scopes
    public function scopeAtiva($query)
    {
        return $query->where('ativa', true);
    }

    // Accessors
    public function getImagemPrincipalUrlAttribute()
    {
        return $this->imagem_principal ? asset('storage/' . $this->imagem_principal) : null;
    }

    public function getImagemEquipeUrlAttribute()
    {
        return $this->imagem_equipe ? asset('storage/' . $this->imagem_equipe) : null;
    }

    // Relationships
    public function galeria()
    {
        return $this->hasMany(GaleriaSobre::class)->ativa()->ordenada();
    }
}
