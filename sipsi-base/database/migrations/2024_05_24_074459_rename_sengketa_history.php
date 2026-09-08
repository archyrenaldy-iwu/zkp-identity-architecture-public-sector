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
        Schema::rename('sengketa_history_table_and_drop_sengketa_jadwal', 'sengketa_history');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('sengketa_history', 'sengketa_history_table_and_drop_sengketa_jadwal');
    }
};
