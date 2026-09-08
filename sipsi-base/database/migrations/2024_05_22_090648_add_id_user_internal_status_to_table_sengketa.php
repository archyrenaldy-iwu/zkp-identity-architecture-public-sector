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
            $table->string('status')->nullable();
            $table->string('file_akta_pembatalan')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('id_user_internal')->nullable();
            $table->foreign('id_user_internal')->references('id')->on('user_internal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->dropForeign(['id_user_internal']);
            $table->dropColumn('id_user_internal');
            $table->dropColumn('catatan');
            $table->dropColumn('status');
        });
    }
};
