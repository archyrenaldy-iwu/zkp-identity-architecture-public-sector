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
        Schema::create('pemohon', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('alamat', 255);
            $table->string('no_telp', 15)->nullable();
            $table->string('no_hp', 15);
            $table->string('email', 255);
            $table->string('jenis_identitas', 10);
            $table->string('nomor_identitas', 20);
            $table->string('jenis_pemohon', 10);
            $table->string('agama', 20)->nullable();
            $table->string('pekerjaan', 255)->nullable();
            $table->string('kewarganegaraan', 10);
            $table->string('tempat_lahir', 255)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedBigInteger('id_user');

            // Foreign key relation
            $table->foreign('id_user')->references('id')->on('users');

            // Fields for tracking changes and users responsible
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key for tracking
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemohon');
    }
};
