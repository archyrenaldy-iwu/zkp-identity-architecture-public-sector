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
            $table->renameColumn('reelas_alamat', 'sidang_alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa_history', function (Blueprint $table) {
            $table->renameColumn('sidang_alamat', 'reelas_alamat');
        });
    }
};
