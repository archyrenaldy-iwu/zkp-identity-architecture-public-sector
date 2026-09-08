<?php

namespace App\Services;

use App\Models\Panduan;
use Constant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Roles;
use StorageHelper;

class PanduanService
{
    public function list($request)
    {
        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            return Panduan::where('jenis', Roles::ROLE_PEMOHON)->get();
        } elseif (getActiveRole(Roles::ROLE_SUPERADMIN)) {
            return Panduan::get();
        } else {
            return Panduan::whereNotIn('jenis', [Roles::ROLE_PEMOHON, Roles::ROLE_SUPERADMIN])->get();
        }
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();

            $request = StorageHelper::upload($request);

            $panduan = Panduan::create([
                'judul' => $request['judul'],
                'file' => $request['file_panduan'],
                'jenis' => $request['jenis'],
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
                'data' => $panduan,
            ];

        } catch (Exception $e) {
            Log::error('Exception caught in '.__CLASS__.'::'.__FUNCTION__.': '.$e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollback();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function destroy($id)
    {
        $panduan = Panduan::findOrFail($id);
        $panduan->delete();

        return [
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }
}
