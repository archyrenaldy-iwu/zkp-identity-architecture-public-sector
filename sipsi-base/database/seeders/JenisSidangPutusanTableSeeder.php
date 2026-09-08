<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JenisSidangPutusanTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('jenis_sidang_putusan')->delete();

        \DB::table('jenis_sidang_putusan')->insert([
            0 => [
                'id' => 1,
                'nama' => 'Sidang Pemeriksaan Awal',
                'jenis' => 'sidang',
                'is_selesai' => false,
            ],
            1 => [
                'id' => 2,
                'nama' => 'Mediasi',
                'jenis' => 'sidang',
                'is_selesai' => false,
            ],
            2 => [
                'id' => 3,
                'nama' => 'Ajudikasi',
                'jenis' => 'sidang',
                'is_selesai' => false,
            ],
            3 => [
                'id' => 4,
                'nama' => 'Putusan Sela',
                'jenis' => 'putusan',
                'is_selesai' => true,
            ],
            4 => [
                'id' => 5,
                'nama' => 'Putusan Gugur',
                'jenis' => 'putusan',
                'is_selesai' => true,
            ],
            5 => [
                'id' => 7,
                'nama' => 'Putusan Mediasi Berhasil',
                'jenis' => 'putusan',
                'is_selesai' => true,
            ],
            6 => [
                'id' => 8,
                'nama' => 'Pernyataan Mediasi Gagal',
                'jenis' => 'putusan',
                'is_selesai' => false,
            ],
            7 => [
                'id' => 10,
                'nama' => 'Lainnya',
                'jenis' => 'putusan',
                'is_selesai' => false,
            ],
            8 => [
                'id' => 9,
                'nama' => 'Putusan Akhir',
                'jenis' => 'putusan',
                'is_selesai' => true,
            ],
        ]);

    }
}
