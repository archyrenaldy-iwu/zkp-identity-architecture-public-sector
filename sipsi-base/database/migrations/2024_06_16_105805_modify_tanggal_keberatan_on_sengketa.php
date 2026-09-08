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
        Schema::table('sengketa', function (Blueprint $table) {
            DB::statement('ALTER TABLE sengketa ALTER COLUMN tanggal_keberatan TYPE DATE USING tanggal_keberatan::DATE');
            $table->date('tanggal_keberatan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            DB::statement('ALTER TABLE sengketa ALTER COLUMN tanggal_keberatan TYPE DATE USING tanggal_keberatan::DATE');
            $table->date('tanggal_keberatan')->change();
        });
    }
};
