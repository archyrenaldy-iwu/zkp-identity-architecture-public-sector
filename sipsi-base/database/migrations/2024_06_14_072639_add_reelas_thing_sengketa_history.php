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
        Schema::table('sengketa_history', function (Blueprint $table) {
            $table->boolean('reelas_sudah_kirim')->nullable();
            $table->timestamp('reelas_waktu_kirim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa_history', function (Blueprint $table) {
            $table->dropColumn('reelas_sudah_kirim');
            $table->dropColumn('reelas_waktu_kirim');
        });
    }
};
