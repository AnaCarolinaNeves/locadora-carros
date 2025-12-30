<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {
            if (Schema::hasColumn('locacoes', 'data_devolucao_real')) {
                $table->dropColumn('data_devolucao_real');
            }
        });
    }

    public function down(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {
            $table->date('data_devolucao_real')->nullable();
        });
    }
};