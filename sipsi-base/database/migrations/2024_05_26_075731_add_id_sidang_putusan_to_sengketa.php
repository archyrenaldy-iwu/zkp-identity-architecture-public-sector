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
            $table->unsignedBigInteger('id_sidang_putusan')->nullable();
            $table->foreign('id_sidang_putusan')->references('id')->on('jenis_sidang_putusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->dropColumn('id_sidang_putusan');
        });
    }
};
