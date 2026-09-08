<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('hak_akses_menu');
        Schema::dropIfExists('hak_akses_fitur');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
