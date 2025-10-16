<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Imovel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'imoveis';

    protected $fillable = [
        'codigo',
        'titulo',
        'slug',
        'descricao',
        'tipo_id',
        'finalidade_id',
        'preco',
        'area_total',
        'area_construida',
        'quartos',
        'banheiros',
        'vagas',
        'endereco',
        'cidade',
        'bairro',
        'cep',
        'latitude',
        'longitude',
        'status',
        'destaque',
        'visualizacoes',
        'ordem',
        'user_id'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'area_total' => 'decimal:2',
        'area_construida' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'destaque' => 'boolean',
        'visualizacoes' => 'integer',
        'quartos' => 'integer',
        'banheiros' => 'integer',
        'vagas' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($imovel) {
            if (empty($imovel->codigo)) {
                $imovel->codigo = 'IMO' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
            }
            if (empty($imovel->slug)) {
                $imovel->slug = Str::slug($imovel->titulo);
            }
        });

        static::updating(function ($imovel) {
            if ($imovel->isDirty('titulo') && !$imovel->isDirty('slug')) {
                $imovel->slug = Str::slug($imovel->titulo);
            }
        });
    }

    // Relationships
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function finalidade()
    {
        return $this->belongsTo(Finalidade::class);
    }

    public function imagens()
    {
        return $this->hasMany(ImagemImovel::class)->orderBy('ordem');
    }

    public function imagemPrincipal()
    {
        return $this->hasOne(ImagemImovel::class)->orderBy('ordem');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class);
    }

    public function corretor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeVenda($query)
    {
        return $query->whereHas('finalidade', function ($q) {
            $q->where('slug', 'venda');
        });
    }

    public function scopeAluguel($query)
    {
        return $query->whereHas('finalidade', function ($q) {
            $q->where('slug', 'aluguel');
        });
    }

    // Accessors
    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function incrementarVisualizacoes()
    {
        $this->increment('visualizacoes');
    }
}

