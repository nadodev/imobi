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
        Schema::table('imoveis', function (Blueprint $table) {
            $table->enum('status_gestao', ['livre', 'reservado', 'vendido', 'alugado', 'indisponivel'])->default('livre')->after('status');
            $table->string('numero_chaves')->nullable()->after('status_gestao');
            $table->string('localizacao_chaves')->nullable()->after('numero_chaves');
            $table->date('data_revisao_contrato')->nullable()->after('localizacao_chaves');
            $table->date('data_vencimento_aluguel')->nullable()->after('data_revisao_contrato');
            $table->text('observacoes_gestao')->nullable()->after('data_vencimento_aluguel');
            $table->foreignId('corretor_responsavel')->nullable()->constrained('users')->onDelete('set null')->after('observacoes_gestao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imoveis', function (Blueprint $table) {
            $table->dropForeign(['corretor_responsavel']);
            $table->dropColumn([
                'status_gestao',
                'numero_chaves',
                'localizacao_chaves',
                'data_revisao_contrato',
                'data_vencimento_aluguel',
                'observacoes_gestao',
                'corretor_responsavel'
            ]);
        });
    }
};
