<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'cor',
        'icone',
        'ativa',
        'ordem',
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function artigos()
    {
        return $this->hasMany(Artigo::class, 'categoria', 'slug');
    }

    // Scopes
    public function scopeAtiva($query)
    {
        return $query->where('ativa', true);
    }

    public function scopeOrdenada($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Accessors
    public function getTotalArtigosAttribute()
    {
        return $this->artigos()->where('status', 'publicado')->count();
    }

    public function getCorFormatadaAttribute()
    {
        return $this->cor ?: '#3B82F6';
    }

    public function getIconeFormatadaAttribute()
    {
        return $this->icone ?: 'fas fa-folder';
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value ?: $this->nome);
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}