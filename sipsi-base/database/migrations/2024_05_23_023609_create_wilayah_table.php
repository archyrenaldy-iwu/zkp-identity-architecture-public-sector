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
        Schema::create('wilayah', function (Blueprint $table) {
            $table->bigIncrements('id_wilayah');
            $table->integer('tingkat')->nullable();
            $table->string('nama_wilayah');
            $table->unsignedBigInteger('id_parent_wilayah');

            $table->string('kode_wilayah')->nullable();
            $table->unique('kode_wilayah');
            $table->primary('id_wilayah');

            $table->foreign('id_parent_wilayah')->references('id_wilayah')->on('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
