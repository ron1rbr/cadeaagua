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
        Schema::create('previsoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained('locais')->cascadeOnDelete();
            $table->timestamp('proxima_agua_chega')->nullable();
            $table->timestamp('proxima_agua_acaba')->nullable();
            $table->enum('confianca', ['baixa', 'media', 'alta'])->default('baixa');
            $table->json('dados_base')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previsoes');
    }
};
