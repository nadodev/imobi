<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Artigo extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'resumo', 'conteudo', 'imagem_destaque',
        'categoria', 'tags', 'status', 'destaque', 'visualizacoes',
        'user_id', 'publicado_em'
    ];

    protected $casts = [
        'tags' => 'array',
        'publicado_em' => 'datetime',
        'destaque' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria', 'slug');
    }

    // Scopes
    public function scopePublicado($query)
    {
        return $query->where('status', 'publicado')
                    ->where('publicado_em', '<=', now());
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeRecentes($query)
    {
        return $query->orderBy('publicado_em', 'desc');
    }

    // Accessors
    public function getTituloFormatadoAttribute()
    {
        return Str::limit($this->titulo, 60);
    }

    public function getResumoFormatadoAttribute()
    {
        return Str::limit($this->resumo, 150);
    }

    public function getTempoLeituraAttribute()
    {
        $palavras = str_word_count(strip_tags($this->conteudo));
        return ceil($palavras / 200); // 200 palavras por minuto
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function incrementarVisualizacoes()
    {
        $this->increment('visualizacoes');
    }
}
