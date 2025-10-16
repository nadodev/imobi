<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->nullable()->constrained('imoveis')->onDelete('set null');
            $table->string('nome', 255);
            $table->string('email', 255);
            $table->string('telefone', 20)->nullable();
            $table->string('assunto', 255)->nullable();
            $table->text('mensagem');
            $table->enum('status', ['nao_lida', 'lida', 'respondida'])->default('nao_lida');
            $table->text('resposta')->nullable();
            $table->timestamp('respondido_em')->nullable();
            $table->foreignId('respondido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};

