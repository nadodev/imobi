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
        Schema::create('newsletter_envios', function (Blueprint $table) {
            $table->id();
            $table->string('assunto');
            $table->text('conteudo');
            $table->enum('tipo', ['individual', 'todos'])->default('todos');
            $table->string('email_destino')->nullable(); // Para envios individuais
            $table->integer('total_enviados')->default(0);
            $table->integer('total_entregues')->default(0);
            $table->integer('total_falhas')->default(0);
            $table->enum('status', ['pendente', 'enviando', 'concluido', 'erro'])->default('pendente');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin que enviou
            $table->timestamp('enviado_em')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_envios');
    }
};
