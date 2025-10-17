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
        'status_gestao',
        'numero_chaves',
        'localizacao_chaves',
        'data_revisao_contrato',
        'data_vencimento_aluguel',
        'observacoes_gestao',
        'corretor_responsavel',
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

    public function corretorResponsavel()
    {
        return $this->belongsTo(User::class, 'corretor_responsavel');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }

    public function visualizacoes()
    {
        return $this->hasMany(Visualizacao::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function corretor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function usuariosFavoritos()
    {
        return $this->belongsToMany(User::class, 'favoritos');
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

    // Scopes para gestão
    public function scopePorStatusGestao($query, $status)
    {
        return $query->where('status_gestao', $status);
    }

    public function scopePorCorretor($query, $corretorId)
    {
        return $query->where('corretor_responsavel', $corretorId);
    }

    public function scopeComContratoVencendo($query, $dias = 30)
    {
        return $query->where('data_vencimento_aluguel', '<=', now()->addDays($dias))
                    ->where('data_vencimento_aluguel', '>=', now());
    }

    // Métodos auxiliares para gestão
    public function getStatusGestaoColorAttribute()
    {
        return match($this->status_gestao) {
            'livre' => 'green',
            'reservado' => 'yellow',
            'vendido' => 'blue',
            'alugado' => 'purple',
            'indisponivel' => 'red',
            default => 'gray'
        };
    }

    public function getStatusGestaoLabelAttribute()
    {
        return match($this->status_gestao) {
            'livre' => 'Livre',
            'reservado' => 'Reservado',
            'vendido' => 'Vendido',
            'alugado' => 'Alugado',
            'indisponivel' => 'Indisponível',
            default => 'Não definido'
        };
    }

    public function isContratoVencendo($dias = 30)
    {
        return $this->data_vencimento_aluguel && 
               $this->data_vencimento_aluguel <= now()->addDays($dias) &&
               $this->data_vencimento_aluguel >= now();
    }

    public function getTotalVisualizacoesAttribute()
    {
        return $this->visualizacoes()->count();
    }

    public function getVisualizacoesHojeAttribute()
    {
        return $this->visualizacoes()->hoje()->count();
    }

    public function getVisualizacoesEstaSemanaAttribute()
    {
        return $this->visualizacoes()->estaSemana()->count();
    }

    public function getMediaAvaliacoesAttribute()
    {
        return $this->avaliacoes()->aprovado()->avg('avaliacao') ?? 0;
    }

    public function getTotalAvaliacoesAttribute()
    {
        return $this->avaliacoes()->aprovado()->count();
    }

    // Accessors
    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format((float) $this->preco, 2, ',', '.');
    }

    public function incrementarVisualizacoes()
    {
        $this->increment('visualizacoes');
    }
}

