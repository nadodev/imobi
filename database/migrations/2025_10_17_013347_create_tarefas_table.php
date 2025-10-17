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
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['ligacao', 'email', 'whatsapp', 'visita', 'proposta', 'followup', 'outro'])->default('followup');
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('status', ['pendente', 'em_andamento', 'concluida', 'cancelada'])->default('pendente');
            $table->timestamp('data_vencimento');
            $table->timestamp('data_conclusao')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('cascade');
            $table->foreignId('imovel_id')->nullable()->constrained('imoveis')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário responsável
            $table->foreignId('criado_por')->constrained('users')->onDelete('cascade'); // Usuário que criou
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
