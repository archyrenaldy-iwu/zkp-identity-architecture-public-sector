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
        Schema::table('ki_config', function (Blueprint $table) {
            $table->renameColumn('template_kode_surat_skpd', 'template_kode_surat_spkd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ki_config', function (Blueprint $table) {
            $table->renameColumn('template_kode_surat_spkd', 'template_kode_surat_skpd');
        });
    }
};
