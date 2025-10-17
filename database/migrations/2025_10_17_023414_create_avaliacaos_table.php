<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis')->onDelete('cascade');
            $table->string('nome');
            $table->string('email');
            $table->integer('avaliacao')->unsigned(); // 1 a 5 estrelas
            $table->text('comentario')->nullable();
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])->default('pendente');
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            $table->index(['imovel_id', 'status']);
            $table->index('avaliacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacaos');
    }
};
