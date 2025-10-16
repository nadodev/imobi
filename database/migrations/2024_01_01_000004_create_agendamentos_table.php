<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis')->onDelete('cascade');
            $table->string('nome_cliente', 255);
            $table->string('telefone', 20);
            $table->string('email', 255);
            $table->date('data_visita');
            $table->time('horario_visita')->nullable();
            $table->text('mensagem')->nullable();
            $table->enum('status', ['pendente', 'confirmado', 'cancelado', 'realizado'])->default('pendente');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'data_visita']);
            $table->index('imovel_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};

