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
            $table->foreignId('id_panitera_utama')->nullable()->constrained('user_internal')->onDelete('cascade');
            $table->renameColumn('id_pp', 'id_panitera_pengganti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->dropColumn('id_panitera_utama');
            $table->renameColumn('id_panitera_pengganti', 'id_pp');
        });
    }
};
