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
        Schema::create('sengketa_proses', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sengketa');
            $table->unsignedBigInteger('id_jenis_sidang');
            $table->unsignedBigInteger('id_putusan');
            $table->text('agenda');
            $table->dateTime('waktu');
            $table->boolean('is_current')->default(false);
            $table->integer('total_panggilan');
            $table->string('file', 255)->nullable();
            $table->text('link_jdih')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_sengketa')->references('id')->on('sengketa');
            $table->foreign('id_jenis_sidang')->references('id')->on('jenis_sidang_putusan');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            // Additional index for faster query performance on common operations
            $table->index(['is_current', 'waktu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sengketa_proses');
    }
};
