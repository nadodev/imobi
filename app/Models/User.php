<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
