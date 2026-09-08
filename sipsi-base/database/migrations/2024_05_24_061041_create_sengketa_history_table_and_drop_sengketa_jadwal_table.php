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
        Schema::create('sengketa_history_table_and_drop_sengketa_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sengketa')->constrained('sengketa');
            $table->foreignId('id_internal_user')->nullable()->constrained('user_internal');
            $table->boolean('is_selesai')->nullable();
            $table->integer('status');
            $table->text('penolakan_info')->nullable();
            $table->json('penolakan_checklist')->nullable();
            $table->foreignId('id_jenis_sidang')->nullable()->constrained('jenis_sidang_putusan');
            $table->string('sidang_agenda')->nullable();
            $table->dateTime('sidang_waktu')->nullable();
            $table->foreignId('id_ruangan')->nullable()->constrained('ruangan');
            $table->string('reelas_alamat')->nullable();
            $table->string('no_reelas')->nullable();
            $table->foreignId('id_jenis_putusan')->nullable()->constrained('jenis_sidang_putusan');
            $table->string('putusan_link_jdih')->nullable();
            $table->string('file1')->nullable();
            $table->string('file2')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });

        Schema::dropIfExists('sengketa_jadwal');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sengketa_history');
    }
};
