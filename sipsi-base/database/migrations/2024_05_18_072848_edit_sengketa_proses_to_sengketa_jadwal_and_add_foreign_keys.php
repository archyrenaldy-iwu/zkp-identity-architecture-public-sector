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
        Schema::rename('sengketa_proses', 'sengketa_jadwal');

        Schema::table('sengketa_jadwal', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_jenis_sidang');

            // Foreign key constraints
            $table->foreign('id_ruangan')->references('id')->on('ruangan')->onDelete('cascade');
            $table->foreign('id_jenis_sidang')->references('id')->on('jenis_sidang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa_jadwal', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['id_ruangan']);
            $table->dropForeign(['id_jenis_sidang']);

            // Drop columns
            $table->dropColumn(['id_ruangan', 'id_jenis_sidang']);
        });

        // Rename the table back from sengketa_jadwal to sengketa_proses
        Schema::rename('sengketa_jadwal', 'sengketa_proses');
    }
};
