<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';

    protected $fillable = [
        'chave',
        'valor',
        'grupo'
    ];

    /**
     * Obtém o valor de uma configuração
     */
    public static function obter($chave, $padrao = null)
    {
        $config = static::where('chave', $chave)->first();
        return $config ? $config->valor : $padrao;
    }

    /**
     * Define o valor de uma configuração
     */
    public static function definir($chave, $valor, $grupo = 'geral')
    {
        return static::updateOrCreate(
            ['chave' => $chave],
            ['valor' => $valor, 'grupo' => $grupo]
        );
    }

    /**
     * Obtém todas as configurações de um grupo
     */
    public static function grupo($grupo)
    {
        return static::where('grupo', $grupo)->pluck('valor', 'chave');
    }
}

