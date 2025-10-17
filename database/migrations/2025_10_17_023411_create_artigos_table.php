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
        Schema::create('artigos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumo');
            $table->longText('conteudo');
            $table->string('imagem_destaque')->nullable();
            $table->string('categoria')->default('geral');
            $table->json('tags')->nullable();
            $table->enum('status', ['rascunho', 'publicado', 'arquivado'])->default('rascunho');
            $table->boolean('destaque')->default(false);
            $table->integer('visualizacoes')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('publicado_em')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'publicado_em']);
            $table->index('categoria');
            $table->index('destaque');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artigos');
    }
};
