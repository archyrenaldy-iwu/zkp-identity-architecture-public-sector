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
        Schema::rename('jenis_sidang', 'jenis_sidang_putusan');

        Schema::table('sengketa_jadwal', function (Blueprint $table) {
            $table->dropColumn('total_panggilan');
            $table->renameColumn('file', 'file_putusan');
            $table->renameColumn('waktu', 'waktu_sidang');

            //terkait putusan
            $table->timestamp('waktu_putusan')->nullable();
            $table->unsignedBigInteger('id_jenis_putusan')->nullable();
            $table->boolean('is_selesai');

            $table->foreign('id_jenis_putusan')->references('id')->on('jenis_sidang_putusan')->onDelete('cascade');

            //terkait reelas
            $table->timestamp('waktu_kirim_reelas')->nullable();
            $table->string('file_reelas_pemohon')->nullable();
            $table->string('file_reelas_termohon')->nullable();
            $table->unsignedBigInteger('id_user_internal')->nullable();
            $table->foreign('id_user_internal')->references('id')->on('user_internal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa_jadwal', function (Blueprint $table) {
            // Remove foreign keys first to avoid constraint errors
            $table->dropForeign(['id_jenis_putusan']);
            $table->dropForeign(['id_user_internal']);

            // Remove the columns added in up()
            $table->dropColumn('waktu_putusan');
            $table->dropColumn('id_jenis_putusan');
            $table->dropColumn('is_selesai');
            $table->dropColumn('waktu_kirim_reelas');
            $table->dropColumn('file_reelas_pemohon');
            $table->dropColumn('file_reelas_termohon');
            $table->dropColumn('id_user_internal');

            // Revert renamed columns to their original names
            $table->renameColumn('file_putusan', 'file');
            $table->renameColumn('waktu_sidang', 'waktu');

            // Add back the column that was dropped
            $table->integer('total_panggilan')->nullable();
        });

        // Rename the table back to its original name
        Schema::rename('jenis_sidang_putusan', 'jenis_sidang');
    }
};
