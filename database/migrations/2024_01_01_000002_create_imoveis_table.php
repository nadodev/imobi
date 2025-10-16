<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('titulo', 255);
            $table->string('slug', 255)->unique();
            $table->text('descricao')->nullable();
            
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('restrict');
            $table->foreignId('finalidade_id')->constrained('finalidades')->onDelete('restrict');
            
            $table->decimal('preco', 12, 2);
            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('area_construida', 10, 2)->nullable();
            
            $table->integer('quartos')->default(0);
            $table->integer('banheiros')->default(0);
            $table->integer('vagas')->default(0);
            
            $table->string('endereco', 255)->nullable();
            $table->string('cidade', 100);
            $table->string('bairro', 100);
            $table->string('cep', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->enum('status', ['ativo', 'vendido', 'alugado', 'oculto'])->default('ativo');
            $table->boolean('destaque')->default(false);
            
            $table->integer('visualizacoes')->default(0);
            $table->integer('ordem')->default(0);
            
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'destaque']);
            $table->index(['cidade', 'bairro']);
            $table->index('tipo_id');
            $table->index('finalidade_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};

