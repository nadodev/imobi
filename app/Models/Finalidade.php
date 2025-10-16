<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Finalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($finalidade) {
            if (empty($finalidade->slug)) {
                $finalidade->slug = Str::slug($finalidade->nome);
            }
        });

        static::updating(function ($finalidade) {
            if ($finalidade->isDirty('nome') && !$finalidade->isDirty('slug')) {
                $finalidade->slug = Str::slug($finalidade->nome);
            }
        });
    }

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }
}

