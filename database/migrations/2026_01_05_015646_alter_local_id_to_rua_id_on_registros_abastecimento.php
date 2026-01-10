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
        Schema::table('registros_abastecimento', function (Blueprint $table) {
            $table->dropForeign(['local_id']);

            $table->renameColumn('local_id', 'rua_id');
        });

        Schema::table('registros_abastecimento', function (Blueprint $table) {
            $table->foreign('rua_id')
                ->references('id')
                ->on('ruas')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros_abastecimento', function (Blueprint $table) {
            $table->dropForeign(['rua_id']);

            $table->ranameColumn('rua_id', 'local_id');
        });

        Schema::table('registros_abastecimento', function (Blueprint $table) {
            $table->foreign('local_id')
                ->references('id')
                ->on('locais')
                ->cascadeOnDelete();
        });
    }
};
