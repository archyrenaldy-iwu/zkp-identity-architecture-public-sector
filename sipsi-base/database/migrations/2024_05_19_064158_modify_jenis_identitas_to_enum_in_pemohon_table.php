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
        Schema::table('pemohon', function (Blueprint $table) {
            $table->string('jenis_identitas', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemohon', function (Blueprint $table) {
            $table->string('jenis_identitas', 10)->change();
        });
    }
};
