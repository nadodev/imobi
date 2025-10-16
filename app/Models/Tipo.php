<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'ordem'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tipo) {
            if (empty($tipo->slug)) {
                $tipo->slug = Str::slug($tipo->nome);
            }
        });

        static::updating(function ($tipo) {
            if ($tipo->isDirty('nome') && !$tipo->isDirty('slug')) {
                $tipo->slug = Str::slug($tipo->nome);
            }
        });
    }

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }
}

