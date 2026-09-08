<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TermohonTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('termohon')->delete();

        \DB::table('termohon')->insert([
            0 => [
                'id' => 1,
                'nama' => 'Kementerian Dalam Negeri (Kemendagri)',
                'alamat' => 'Jl. Medan Merdeka Utara No. 7, Jakarta Pusat, DKI Jakarta, 10110',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-11 21:48:45',
                'updated_at' => '2024-09-11 21:48:45',
            ],
            1 => [
                'id' => 2,
                'nama' => 'Kementerian Luar Negeri (Kemlu)',
                'alamat' => 'Jl. Taman Pejambon No. 6, Jakarta Pusat, DKI Jakarta, 10110',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-11 21:52:37',
                'updated_at' => '2024-09-11 21:52:37',
            ],
            2 => [
                'id' => 3,
                'nama' => 'Kementerian Keuangan (Kemenkeu)',
                'alamat' => 'Jl. Dr. Wahidin No. 1, Jakarta Pusat, DKI Jakarta, 10710',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-11 21:55:27',
                'updated_at' => '2024-09-11 21:55:27',
            ],
            3 => [
                'id' => 4,
                'nama' => 'Kementerian Hukum dan Hak Asasi Manusia (Kemenkumham)',
                'alamat' => 'Jl. HR. Rasuna Said Kav. 6-7, Kuningan, Jakarta Selatan, DKI Jakarta, 12940',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-11 21:57:05',
                'updated_at' => '2024-09-11 21:57:05',
            ],
            4 => [
                'id' => 5,
                'nama' => 'Kementerian Pendidikan dan Kebudayaan (Kemendikbud)',
                'alamat' => 'Jl. Jenderal Sudirman, Senayan, Jakarta Pusat, DKI Jakarta, 10270',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-11 21:58:58',
                'updated_at' => '2024-09-11 21:58:58',
            ],
            5 => [
                'id' => 6,
                'nama' => 'BAPENDA JABAR',
                'alamat' => 'BANDUNG',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 15,
                'updated_by' => 15,
                'created_at' => '2024-09-12 09:19:00',
                'updated_at' => '2024-09-12 09:19:00',
            ],
            6 => [
                'id' => 7,
                'nama' => 'DINKES SUMEDANG',
                'alamat' => 'SUMEDANG',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 15,
                'updated_by' => 15,
                'created_at' => '2024-09-12 09:32:52',
                'updated_at' => '2024-09-12 09:32:52',
            ],
            7 => [
                'id' => 8,
                'nama' => 'DINAS DINAS',
                'alamat' => 'GARUT',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 15,
                'updated_by' => 15,
                'created_at' => '2024-09-12 10:02:32',
                'updated_at' => '2024-09-12 10:02:32',
            ],
            8 => [
                'id' => 9,
                'nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang Provinsi Jawa Barat',
                'alamat' => 'Jl. Asia Afrika No. 79, Cikawao, Kec. Lengkong, Kota Bandung, Jawa Barat, 40261',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-23 21:46:12',
                'updated_at' => '2024-09-23 21:46:12',
            ],
            9 => [
                'id' => 10,
                'nama' => 'DISNAKER PUSAT',
                'alamat' => null,
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-09-26 21:59:52',
                'updated_at' => '2024-09-26 21:59:52',
            ],
            10 => [
                'id' => 11,
                'nama' => 'Dinas Kota Bandung',
                'alamat' => 'Bandung',
                'no_telp' => null,
                'no_hp' => null,
                'email' => null,
                'created_by' => 7,
                'updated_by' => 7,
                'created_at' => '2024-09-30 22:41:39',
                'updated_at' => '2024-09-30 22:41:39',
            ],
        ]);

    }
}
