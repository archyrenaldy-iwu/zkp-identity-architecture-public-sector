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
        Schema::create('ki_config', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('alamat', 255);
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 255);
            $table->string('template_kode_surat_akta_registrasi', 255);
            $table->string('template_kode_nomor_sengketa', 255);
            $table->string('template_kode_surat_skpd', 255);
            $table->string('template_kode_surat_reelas', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ki_config');
    }
};
