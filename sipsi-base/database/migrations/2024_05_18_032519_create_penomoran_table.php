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
        Schema::create('penomoran', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 100);
            $table->unsignedBigInteger('id_ki');
            $table->year('tahun');
            $table->unsignedInteger('nomor');
            $table->string('hasil', 100);

            // Setting foreign key constraint
            $table->foreign('id_ki')->references('id')->on('ki_config')->onDelete('cascade');

            // Adding an index on 'hasil' if it needs to be constrained or often queried
            $table->index('hasil');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penomoran');
    }
};
