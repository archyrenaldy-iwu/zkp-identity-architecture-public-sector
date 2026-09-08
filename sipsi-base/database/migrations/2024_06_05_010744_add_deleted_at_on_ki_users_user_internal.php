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
        //add soft delete on table users
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        //add soft delete on table user_internal
        Schema::table('user_internal', function (Blueprint $table) {
            $table->softDeletes();
        });

        //add soft delete on table ki_config
        Schema::table('ki_config', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop soft delete on table users
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        //drop soft delete on table user_internal
        Schema::table('user_internal', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        //drop soft delete on table ki_config
        Schema::table('ki_config', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
