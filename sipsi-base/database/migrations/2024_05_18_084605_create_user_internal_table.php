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
        Schema::create('user_internal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nama', 255);
            $table->string('alamat', 255)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 255)->nullable();

            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_internal', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['id_user']);
        });

        Schema::dropIfExists('user_internal');
    }
};
