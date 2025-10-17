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
        Schema::create('pagina_sobres', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_principal');
            $table->text('subtitulo')->nullable();
            $table->text('descricao_principal');
            $table->text('missao')->nullable();
            $table->text('visao')->nullable();
            $table->text('valores')->nullable();
            $table->string('imagem_principal')->nullable();
            $table->string('imagem_equipe')->nullable();
            $table->json('dados_empresa')->nullable(); // telefone, email, endereço, etc
            $table->json('estatisticas')->nullable(); // anos no mercado, imóveis vendidos, etc
            $table->boolean('ativa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagina_sobres');
    }
};
