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
        Schema::create('galeria_sobre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagina_sobre_id')->constrained()->onDelete('cascade');
            $table->string('imagem');
            $table->string('titulo')->nullable();
            $table->text('descricao')->nullable();
            $table->integer('ordem')->default(0);
            $table->boolean('ativa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeria_sobre');
    }
};
