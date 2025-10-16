<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagemImovel extends Model
{
    use HasFactory;

    protected $table = 'imagens_imovel';

    protected $fillable = [
        'imovel_id',
        'caminho',
        'ordem'
    ];

    protected $casts = [
        'ordem' => 'integer',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->caminho);
    }
}

