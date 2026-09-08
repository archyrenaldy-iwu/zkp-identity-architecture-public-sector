<?php

namespace App\Services;

use App\Models\KiConfig;
use App\Models\Wilayah;
use Constant;

class KiService
{
    public function create($request)
    {
        Wilayah::findOrFail($request['id_wilayah']);

        $ki = KiConfig::create([
            'nama' => 'Komisi Informasi '.$this->getWilayah($request['id_wilayah']),
            'alamat' => $request['alamat'],
            'no_hp' => $request['no_hp'],
            'email' => $request['email'],
            'template_kode_surat_akta_registrasi' => $request['template_kode_surat_akta_registrasi'],
            'template_kode_nomor_sengketa' => $request['template_kode_nomor_sengketa'],
            'template_kode_surat_spkd' => $request['template_kode_surat_spkd'],
            'template_kode_surat_reelas' => $request['template_kode_surat_reelas'],
            'link_instagram' => $request['link_instagram'],
            'link_twitter' => $request['link_twitter'],
            'no_telp' => $request['no_telp'],
            'fax' => $request['fax'],
            'link_website' => $request['link_website'],
            'link_facebook' => $request['link_facebook'],
            'link_youtube' => $request['link_youtube'],
            'id_wilayah' => $request['id_wilayah'],
            'timezone' => $request['timezone'],
        ]);

        return [
            'success' => true,
            'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
            'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            'data' => $ki,
        ];
    }

    //get wilayah by id and set capitalize
    private function getWilayah($id)
    {
        $wilayah = Wilayah::findOrFail($id)->nama_wilayah;

        //convert string to capitalize
        return ucwords(strtolower($wilayah));
    }

    public function list()
    {
        $query = KiConfig::all();

        return datatables()->of($query)
            ->make(true);
    }

    public function show($id)
    {
        $ki = KiConfig::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Data ditemukan',
            'data' => $ki,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];

        return $response;
    }

    public function update($request, $id)
    {
        $ki = KiConfig::findOrFail($id);

        //trim email remove space
        $email = $request['email'];
        //replace space with empty string
        $email = str_replace(' ', '', $email);

        $ki->update([
            'alamat' => $request['alamat'],
            'no_hp' => $request['no_hp'],
            'email' => $email,
            'template_kode_surat_akta_registrasi' => $request['template_kode_surat_akta_registrasi'],
            'template_kode_nomor_sengketa' => $request['template_kode_nomor_sengketa'],
            'template_kode_surat_spkd' => $request['template_kode_surat_spkd'],
            'template_kode_surat_reelas' => $request['template_kode_surat_reelas'],
            'link_instagram' => $request['link_instagram'],
            'link_twitter' => $request['link_twitter'],
            'no_telp' => $request['no_telp'],
            'fax' => $request['fax'],
            'link_website' => $request['link_website'],
            'link_facebook' => $request['link_facebook'],
            'link_youtube' => $request['link_youtube'],
            'timezone' => $request['timezone'],
        ]);

        return [
            'success' => true,
            'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
            'data' => $ki,
            'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
        ];

    }

    public function destroy($id)
    {
        $ki = KiConfig::findOrFail($id);
        $ki->delete();

        return [
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }
}
