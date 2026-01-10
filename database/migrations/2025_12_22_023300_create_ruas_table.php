<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');

        Schema::create('ruas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
        });

        DB::statement('ALTER TABLE ruas ADD COLUMN geom geometry(MULTILINESTRING, 4326) NOT NULL');

        Schema::table('ruas', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
        });

        DB::statement('CREATE INDEX idx_ruas_geom ON ruas USING GIST (geom)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruas');
    }
};
