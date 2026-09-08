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
        Schema::table('user_internal', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_identitas', 20);
            $table->string('nomor_identitas', 20);
            $table->char('jenis_kelamin', 1);
            $table->unsignedBigInteger('id_ki');

            $table->string('no_hp', 15)->nullable(false)->change();
            $table->string('email')->nullable(false)->change();

            $table->foreign('id_ki')->references('id')->on('ki_config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_internal', function (Blueprint $table) {
            $table->dropForeign('id_ki');

            $table->dropColumn('tanggal_lahir');
            $table->dropColumn('jenis_identitas', 20);
            $table->dropColumn('nomor_identitas', 20);
            $table->dropColumn('jenis_kelamin', 1);
            $table->dropColumn('id_ki');

            $table->string('no_hp', 15)->nullable(false);
            $table->string('email')->nullable(false);
        });
    }
};
