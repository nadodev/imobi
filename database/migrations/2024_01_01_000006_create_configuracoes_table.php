<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('chave', 100)->unique();
            $table->text('valor')->nullable();
            $table->string('grupo', 50)->default('geral');
            $table->timestamps();
            
            $table->index('grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};

