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
            $table->dropColumn('id_user_internal');
            $table->boolean('is_current')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa_history', function (Blueprint $table) {
            $table->foreignId('id_user_internal')->nullable()->constrained('user_internal')->onDelete('cascade');
            $table->dropColumn('is_current');
        });
    }
};
