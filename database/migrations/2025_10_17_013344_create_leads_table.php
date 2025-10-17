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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->text('observacoes')->nullable();
            $table->enum('origem', ['site', 'whatsapp', 'instagram', 'facebook', 'indicacao', 'outro'])->default('site');
            $table->enum('status', ['novo', 'contatado', 'qualificado', 'proposta', 'negociacao', 'fechado', 'perdido'])->default('novo');
            $table->enum('tipo_interesse', ['compra', 'venda', 'aluguel', 'locacao'])->nullable();
            $table->decimal('valor_interesse', 15, 2)->nullable();
            $table->string('cidade_interesse')->nullable();
            $table->string('bairro_interesse')->nullable();
            $table->integer('quartos_interesse')->nullable();
            $table->integer('banheiros_interesse')->nullable();
            $table->foreignId('imovel_id')->nullable()->constrained('imoveis')->onDelete('set null');
            $table->foreignId('corretor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que criou o lead
            $table->timestamp('ultimo_contato')->nullable();
            $table->timestamp('proximo_followup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
