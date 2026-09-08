<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Constant;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getProvinsi(Request $request)
    {
        $search = $request->input('search');

        $query = Wilayah::query();

        if ($search) {
            $query->where('nama', 'like', '%'.$search.'%');
        }

        $query->where('id_wilayah', '!=', 0);
        $query->where('tingkat', 1);

        // Eksekusi query dan ambil hasilnya
        $wilayah = $query->get();

        // Debugging: tampilkan hasil query
        if ($wilayah) {
            $response = [
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => $wilayah,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

            return responseJson($response);
        } else {
            $response = [
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'http_code' => Constant::HTTP_CODE_ERROR_NOT_FOUND,
            ];

            return responseJson($response);
        }
    }

    public function getKabupaten($id)
    {
        $query = Wilayah::query();
        $query->where('id_parent_wilayah', $id);
        $wilayah = $query->get();
        if ($wilayah) {
            $response = [
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => $wilayah,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

            return responseJson($response);
        } else {
            $response = [
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'http_code' => Constant::HTTP_CODE_ERROR_NOT_FOUND,
            ];

            return responseJson($response);
        }
    }
}
