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
        Schema::table('sengketa', function (Blueprint $table) {
            $table->string('no_sengketa')->nullable()->change();
            DB::statement('ALTER TABLE sengketa ALTER COLUMN status TYPE INTEGER USING (status::integer)');

            $table->dropColumn([
                'tuntutan_pemohon',
                'tanggal_selesai',
                'file_akta_pembatalan',
                'catatan',
            ]);

            $table->dropForeign(['id_user_internal']);
            $table->dropColumn('id_user_internal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sengketa', function (Blueprint $table) {
            $table->string('no_sengketa')->nullable(false)->change();
            DB::statement('ALTER TABLE sengketa ALTER COLUMN status TYPE VARCHAR USING (status::text)');

            $table->text('tuntutan_pemohon')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('file_akta_pembatalan')->nullable();
            $table->text('catatan')->nullable();

            $table->unsignedBigInteger('id_user_internal');
            $table->foreign('id_user_internal')->references('id')->on('user_internal');
        });
    }
};
