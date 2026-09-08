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
        Schema::table('ki_config', function (Blueprint $table) {
            $table->string('link_instagram')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('no_telp');
            $table->string('fax')->nullable();
            $table->string('link_website')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_youtube')->nullable();
            $table->unsignedBigInteger('id_wilayah');

            $table->dropColumn('template_kode_nomor_registrasi');

            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ki_config', function (Blueprint $table) {
            $table->dropForeign(['id_wilayah']); // Drop foreign key constraint
            $table->dropColumn(['email', 'link_instagram', 'link_twitter', 'no_telp', 'fax', 'link_website', 'link_facebook', 'link_youtube', 'id_wilayah']);

            $table->string('template_kode_nomor_registrasi')->nullable();
        });
    }
};
