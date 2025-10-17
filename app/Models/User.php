<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_usuario',
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean',
    ];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }

    public function mensagensRespondidas()
    {
        return $this->hasMany(Mensagem::class, 'respondido_por');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'corretor_id');
    }

    public function leadsCriados()
    {
        return $this->hasMany(Lead::class, 'user_id');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }

    public function tarefasCriadas()
    {
        return $this->hasMany(Tarefa::class, 'criado_por');
    }

    public function imoveisResponsavel()
    {
        return $this->hasMany(Imovel::class, 'corretor_responsavel');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function imoveisFavoritos()
    {
        return $this->belongsToMany(Imovel::class, 'favoritos');
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeAdmin($query)
    {
        return $query->where('tipo_usuario', 'admin');
    }

    public function scopeCorretor($query)
    {
        return $query->where('tipo_usuario', 'corretor');
    }

    // Helpers
    public function isAdmin()
    {
        return $this->tipo_usuario === 'admin';
    }

    public function isCorretor()
    {
        return $this->tipo_usuario === 'corretor';
    }

    public function isCliente()
    {
        return $this->tipo_usuario === 'cliente';
    }
}
