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
        Schema::create('visualizacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis')->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->enum('origem', ['site', 'whatsapp', 'instagram', 'facebook', 'google', 'outro'])->default('site');
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();
            $table->timestamp('visualizado_em');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visualizacaos');
    }
};
