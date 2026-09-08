<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'super-admin',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:48',
                'updated_at' => '2024-06-08 14:29:48',
                'description' => 'Super Admin',
            ],
            1 => [
                'id' => 2,
                'name' => 'pemohon',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:51',
                'updated_at' => '2024-06-08 14:29:51',
                'description' => 'Pemohon',
            ],
            2 => [
                'id' => 3,
                'name' => 'admin-berkas',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:52',
                'updated_at' => '2024-06-08 14:29:52',
                'description' => 'Admin Berkas',
            ],
            3 => [
                'id' => 4,
                'name' => 'sekretaris',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:52',
                'updated_at' => '2024-06-08 14:29:52',
                'description' => 'Sekretaris',
            ],
            4 => [
                'id' => 5,
                'name' => 'panitera',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:53',
                'updated_at' => '2024-06-08 14:29:53',
                'description' => 'Panitera',
            ],
            5 => [
                'id' => 6,
                'name' => 'majelis-komisioner',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:53',
                'updated_at' => '2024-06-08 14:29:53',
                'description' => 'Majelis Komisioner',
            ],
            6 => [
                'id' => 7,
                'name' => 'admin-ki',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:54',
                'updated_at' => '2024-06-08 14:29:54',
                'description' => 'Admin KI',
            ],
            7 => [
                'id' => 8,
                'name' => 'panitera-pengganti',
                'guard_name' => 'web',
                'created_at' => '2024-06-08 14:29:55',
                'updated_at' => '2024-06-08 14:29:55',
                'description' => 'Panitera Pengganti',
            ],
        ]);

    }
}
