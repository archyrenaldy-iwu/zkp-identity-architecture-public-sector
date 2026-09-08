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
            $table->string('file_identitas')->change();
            $table->string('file_formulir_permohonan')->change();
            $table->string('file_formulir_keberatan')->change();
            $table->string('tanggal_keberatan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {});
    }
};
