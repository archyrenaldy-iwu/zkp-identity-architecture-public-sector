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
        Schema::create('sengketa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ki');
            $table->unsignedBigInteger('id_pemohon');
            $table->unsignedBigInteger('id_termohon');
            $table->string('kuasa_pemohon_nama', 255)->nullable();
            $table->char('kuasa_pemohon_jk', 1)->nullable();
            $table->string('kuasa_pemohon_alamat', 255)->nullable();
            $table->date('tanggal_permohonan')->default(DB::raw('CURRENT_DATE'));
            $table->date('tanggal_keberatan')->nullable();
            $table->date('tanggal_jawaban')->nullable();
            $table->date('tanggal_tanggapan')->nullable();
            $table->text('tuntutan_pemohon')->nullable();
            $table->string('file_identitas', 255)->nullable();
            $table->string('file_formulir_keberatan', 255)->nullable();
            $table->string('file_formulir_permohonan', 255)->nullable();
            $table->string('file_surat_kuasa', 255)->nullable();
            $table->string('file_pemberitahuan_tertulis', 255)->nullable();
            $table->string('file_jawaban_ppid', 255)->nullable();
            $table->string('file_tanggapan_atasan_ppid', 255)->nullable();
            $table->string('file_pendukung1', 255)->nullable();
            $table->string('file_pendukung2', 255)->nullable();
            $table->boolean('is_selesai')->default(false);

            // Foreign keys
            $table->foreign('id_ki')->references('id')->on('ki_config');
            $table->foreign('id_pemohon')->references('id')->on('pemohon');
            $table->foreign('id_termohon')->references('id')->on('termohon');

            // Tracking fields
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // This adds both created_at and updated_at columns
            $table->softDeletes(); // This adds the deleted_at column for soft deletes

            // Foreign keys for tracking fields
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sengketa');
    }
};
