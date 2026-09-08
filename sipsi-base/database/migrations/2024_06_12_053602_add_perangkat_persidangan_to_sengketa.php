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
            $table->boolean('is_lengkap_perangkat')->nullable();
            $table->foreignId('id_ketua')->nullable()->constrained('user_internal')->onDelete('cascade');
            $table->foreignId('id_anggota1')->nullable()->constrained('user_internal')->onDelete('cascade');
            $table->foreignId('id_anggota2')->nullable()->constrained('user_internal')->onDelete('cascade');
            $table->foreignId('id_mediator')->nullable()->constrained('user_internal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->dropForeign(['id_ketua']);
            $table->dropForeign(['id_anggota1']);
            $table->dropForeign(['id_anggota2']);
            $table->dropForeign(['id_mediator']);

            $table->dropColumn('is_lengkap_perangkat');
            $table->dropColumn('id_ketua');
            $table->dropColumn('id_anggota1');
            $table->dropColumn('id_anggota2');
            $table->dropColumn('id_mediator');
        });
    }
};
