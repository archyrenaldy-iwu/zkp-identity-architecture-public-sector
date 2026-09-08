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
        Schema::table('sengketa_proses', function (Blueprint $table) {
            $table->dropForeign(['id_jenis_sidang']);
            $table->dropColumn('id_jenis_sidang');
        });

        Schema::dropIfExists('jenis_sidang_putusan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('jenis_sidang_putusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->foreignId('id_sidang')->nullable()->constrained('jenis_sidang_putusan')->onDelete('cascade');
            $table->string('nama_putusan', 255)->nullable();
            $table->boolean('is_akhir')->default(false);
        });

        Schema::table('sengketa_proses', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jenis_sidang');
            $table->foreign('id_jenis_sidang')->references('id')->on('jenis_sidang_putusan');
        });
    }
};
