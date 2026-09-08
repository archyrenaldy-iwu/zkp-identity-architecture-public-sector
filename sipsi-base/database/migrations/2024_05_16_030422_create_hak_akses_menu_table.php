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
        Schema::create('hak_akses_menu', function (Blueprint $table) {
            $table->id();
            $table->string('permission', 255)->unique();
            $table->string('description', 255);
            $table->char('super_admin', 1)->nullable();
            $table->char('pemohon', 1)->nullable();
            $table->char('admin_berkas', 1)->nullable();
            $table->char('sekretaris', 1)->nullable();
            $table->char('panitera', 1)->nullable();
            $table->char('majelis_komisioner', 1)->nullable();
            $table->char('admin_ki', 1)->nullable();
            $table->char('panitera_pengganti', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hak_akses_menu');
    }
};
