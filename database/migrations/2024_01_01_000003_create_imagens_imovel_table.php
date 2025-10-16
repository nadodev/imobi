<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagens_imovel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis')->onDelete('cascade');
            $table->string('caminho', 500);
            $table->integer('ordem')->default(0);
            $table->timestamps();
            
            $table->index(['imovel_id', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagens_imovel');
    }
};

