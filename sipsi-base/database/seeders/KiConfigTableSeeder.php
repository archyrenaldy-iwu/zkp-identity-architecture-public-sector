<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KiConfigTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('ki_config')->delete();

        \DB::table('ki_config')->insert([
            [
                'id' => 1,
                'nama' => 'Komisi Informasi Pusat',
                'alamat' => 'Wisma BSG Gedung Annex, Lt 1, Jl Abdul Muis No. 40 Jakarta Pusat 10110',
                'no_hp' => '085345323343',
                'email' => 'sekretariat@komisiinformasi.go.id',
                'template_kode_surat_akta_registrasi' => '{nomor}/REG-PS/{tahun}',
                'template_kode_nomor_sengketa' => '{nomor}/{bulan}/KIP-PSI/{tahun}',
                'template_kode_surat_spkd' => '{nomor}/{bulan}/KIP-SPKD/{tahun}',
                'template_kode_surat_reelas' => '{nomor}/{bulan}/KIP-RLS/{tahun}',
                'link_instagram' => 'https://www.instagram.com/komisiinformasipusat',
                'link_twitter' => 'https://x.com/KIPusat',
                'no_telp' => '0213483074',
                'fax' => '0213451734',
                'link_website' => 'https://komisiinformasi.go.id',
                'link_facebook' => 'https://www.facebook.com/komisiinformasipusatri',
                'link_youtube' => 'https://www.youtube.com/c/KomisiInformasiPusatRI',
                'id_wilayah' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'timezone' => 'WIB',
            ],
//            [
//                'id' => 2,
//                'nama' => 'Komisi Informasi Jawa Barat',
//                'alamat' => 'Jl. Turangga No.25, Lkr. Sel., Kec. Lengkong, Kota Bandung, Jawa Barat 40263',
//                'no_hp' => '-',
//                'email' => 'admin@komisiinformasi.jabarprov.go.id',
//                'template_kode_surat_akta_registrasi' => '{nomor}/REG-PSI/KI-JBR/{bulan}/{tahun}',
//                'template_kode_nomor_sengketa' => '{nomor}/{bulan}/KI-JBR/PSI/{tahun}',
//                'template_kode_surat_spkd' => '{nomor}/{bulan}/KI-JBR/SPKD/{tahun}',
//                'template_kode_surat_reelas' => '{nomor}/{bulan}/KI-JBR/RLS/{tahun}',
//                'link_instagram' => 'https://www.instagram.com/komisiinformasijawabarat/',
//                'link_twitter' => 'https://x.com/KIPJabar',
//                'no_telp' => '02273511656',
//                'fax' => '-',
//                'link_website' => 'komisiinformasi.jabarprov.go.id',
//                'link_facebook' => '-',
//                'link_youtube' => '-',
//                'id_wilayah' => 191096,
//                'created_by' => 1,
//                'updated_by' => 1,
//                'deleted_at' => null,
//                'timezone' => 'WIB',
//            ],
//            [
//                'id' => 3,
//                'nama' => 'Komisi Informasi Gorontalo',
//                'alamat' => 'Jl. Jamaludin Malik No.41, Limba U I, Kota Sel., Kota Gorontalo, Gorontalo 96135',
//                'no_hp' => '08435828626',
//                'email' => 'admin@komisiinformasi.gorontalo.go.id',
//                'template_kode_surat_akta_registrasi' => '{nomor}/REG-PSI/KI-GRN/{bulan}/{tahun}',
//                'template_kode_nomor_sengketa' => '{nomor}/{bulan}/KI-GRN/PSI/{tahun}',
//                'template_kode_surat_spkd' => '{nomor}/{bulan}/KI-GRN/SPKD/{tahun}',
//                'template_kode_surat_reelas' => '{nomor}/{bulan}/KI-GRN/RLS/{tahun}',
//                'link_instagram' => '-',
//                'link_twitter' => '-',
//                'no_telp' => '02987654321',
//                'fax' => '-',
//                'link_website' => '-',
//                'link_facebook' => '-',
//                'link_youtube' => '-',
//                'id_wilayah' => 191149,
//                'created_by' => 1,
//                'updated_by' => 1,
//                'deleted_at' => null,
//                'timezone' => 'WITA',
//            ],
        ]);

    }
}
