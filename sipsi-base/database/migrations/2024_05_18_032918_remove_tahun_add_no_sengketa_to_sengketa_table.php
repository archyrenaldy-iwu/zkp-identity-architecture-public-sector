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
            $table->dropColumn('tahun');
            $table->string('no_sengketa', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->year('tahun');
            $table->dropColumn('no_sengketa');
        });
    }
};
