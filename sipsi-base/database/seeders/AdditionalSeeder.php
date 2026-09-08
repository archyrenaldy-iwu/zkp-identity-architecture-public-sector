<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::statement('TRUNCATE TABLE sengketa_history, jenis_sidang_putusan, sengketa, penomoran, ruangan, ki_config, wilayah, model_has_roles, role_has_permissions, model_has_permissions, roles, permissions, user_internal, pemohon, termohon, users');

        // $this->call(JenisSidangPutusanTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(RoleHasPermissionsTableSeeder::class);
        // $this->call(WilayahTableSeeder::class);
        $this->call(AddUsersTableSeeder::class);
        $this->call(AddModelHasRolesTableSeeder::class);
        // $this->call(AddKiConfigTableSeeder::class);
        $this->call(AddUserInternalTableSeeder::class);
        $this->call(AddPemohonTableSeeder::class);
//        $this->call(TermohonTableSeeder::class);
//        $this->call(SengketaTableSeeder::class);
//        $this->call(SengketaHistoryTableSeeder::class);
//        $this->call(PenomoranTableSeeder::class);
        $this->call(SetSequence::class);
    }
}
