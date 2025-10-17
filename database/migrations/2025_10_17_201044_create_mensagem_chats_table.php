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
        Schema::create('mensagem_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversa_id')->constrained()->onDelete('cascade');
            $table->text('mensagem');
            $table->enum('tipo', ['cliente', 'admin'])->default('cliente');
            $table->boolean('lida')->default(false);
            $table->timestamp('lida_em')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagem_chats');
    }
};
