<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriaSobre extends Model
{
    use HasFactory;

    protected $table = 'galeria_sobre';

    protected $fillable = [
        'pagina_sobre_id',
        'imagem',
        'titulo',
        'descricao',
        'ordem',
        'ativa'
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'ordem' => 'integer'
    ];

    // Relationships
    public function paginaSobre(): BelongsTo
    {
        return $this->belongsTo(PaginaSobre::class);
    }

    // Scopes
    public function scopeAtiva($query)
    {
        return $query->where('ativa', true);
    }

    public function scopeOrdenada($query)
    {
        return $query->orderBy('ordem')->orderBy('created_at');
    }

    // Accessors
    public function getImagemUrlAttribute()
    {
        return $this->imagem ? asset('storage/' . $this->imagem) : null;
    }
}
