<?php

namespace App\Services;

use App\Models\JenisSidangPutusan;
use App\Models\Sengketa;
use App\Models\SengketaHistory;
use Constant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use StorageHelper;

class PutusanService
{
    public function list($request)
    {
        $data = DB::table('sengketa_history as sh')
            ->select(
                's.id as id_sengketa',
                'sh.id as id_history',
                'no_registrasi',
                'tanggal_permohonan',
                'sidang_waktu',
                'jsp.nama as sidang_nama',
                'p.nama as nama_pemohon',
                't.nama as nama_termohon',
                'kc.timezone',
                'no_sengketa',
                'id_jenis_putusan',
                'sidang_agenda'
            )
            ->join('sengketa as s', 'sh.id_sengketa', '=', 's.id')
            ->join('ki_config AS kc', 's.id_ki', '=', 'kc.id')
            ->join('pemohon as p', 'p.id', '=', 's.id_pemohon')
            ->join('termohon as t', 't.id', '=', 's.id_termohon')
            ->join('jenis_sidang_putusan as jsp', 'sh.id_jenis_sidang', '=', 'jsp.id')
            ->whereIn('sh.status', [Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG, Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN])
            // ->whereNull('sh.id_jenis_putusan')
            // ->whereNull('sh.file3')
            ->whereNull('s.deleted_at')
            ->whereNull('sh.deleted_at')
            ->orderByDesc('sh.id');

        if (isset($request['tanggal1']) && $request['tanggal1'] && isset($request['tanggal2']) && $request['tanggal2']) {
            $tanggal1 = date('Y-m-d', strtotime($request['tanggal1']));
            $tanggal2 = date('Y-m-d', strtotime($request['tanggal2']));
            $data->whereBetween(DB::raw('DATE(sidang_waktu)'), [$tanggal1, $tanggal2]);
        }

        if (isset($request['jenis_sidang']) && $request['jenis_sidang']) {
            $data->where('sh.id_jenis_sidang', $request['jenis_sidang']);
        }

        if (isset($request['no_registrasi']) && $request['no_registrasi']) {
            $data->where('no_registrasi', 'ilike', trim($request['no_registrasi']) . '%');
        }

        if (isset($request['no_sengketa']) && $request['no_sengketa']) {
            $data->where('no_sengketa', 'ilike', trim($request['no_sengketa']) . '%');
        }

        if (isset($request['id_sengketa']) && $request['id_sengketa']) {
            $data->where('sh.id_sengketa', $request['id_sengketa']);
        }

        if (isset($request['id_ki']) && $request['id_ki'] && !isUserInternal()) {
            $data->where('s.id_ki', $request['id_ki']);
        }

        if (isUserInternal()) {
            $data->where('s.id_ki', idKiAuth());
        }

        return $data->get();
    }

    public function create($request)
    {
        $sengketa_history = SengketaHistory::findOrFail($request['id_history']);
        $sengketa = Sengketa::findOrFail($sengketa_history->id_sengketa);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai. Silahkan hapus sidang dan putusan terakhir terlebih dahulu',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa_history->status != Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG) {
            return [
                'success' => false,
                'message' => 'Tidak dalam proses sidang. Gagal menambah putusan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa_history->id_jenis_putusan || $sengketa_history->putusan_link_jdih || $sengketa_history->file3) {
            return [
                'success' => false,
                'message' => 'Sidang ini sudah memiliki putusan. Gagal menambah putusan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            Log::info("Create Putusan...");
            DB::beginTransaction();

            $request = StorageHelper::upload($request);

            $jenis_putusan = JenisSidangPutusan::where('jenis', 'putusan')->where('id', $request['id_jenis_putusan'])->firstOrFail();

            $last_history = SengketaHistory::where('id_sengketa', $sengketa_history->id_sengketa)
                ->orderBy('id', 'desc')
                ->firstOrFail();

            if ($sengketa_history->id != $last_history->id && $jenis_putusan->is_selesai) {
                return [
                    'success' => false,
                    'message' => 'Jenis putusan yang anda pilih akan menyelesaikan sengketa ini tetapi masih ada sidang aktif. Jika ingin tetap melanjutkan, harap hapus sidang setelah sidang yang ingin diputuskan selesai.',
                    'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
                ];
            }

            if ($jenis_putusan->is_selesai == true && (!isset($request['putusan_link_jdih']) || !$request['putusan_link_jdih'])) {
                return [
                    'success' => false,
                    'message' => 'Jenis putusan yang anda pilih akan menyelesaikan sengketa ini tetapi link JDIH tidak terisi. Harap isi link JDIH.',
                    'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
                ];
            }

            $sengketa_history->update([
                'id_jenis_putusan' => $request['id_jenis_putusan'],
                'putusan_link_jdih' => $request['putusan_link_jdih'],
                'file3' => $request['file_putusan'],
                'is_selesai' => $jenis_putusan->is_selesai,
                'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN,
            ]);

            $sengketa->update([
                'is_selesai' => $jenis_putusan->is_selesai,
                'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN,
                'id_sidang_putusan' => $request['id_jenis_putusan'],
            ]);

            // Verifikasi AI
            Log::info("Verifikasi AI...");
            $filePutusan = $request['file_putusan'];

            $extractedNumber =
                $this->getNomorFromVerification($filePutusan);

            if ($extractedNumber === null) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengekstrak nomor sengketa dari file putusan. Pastikan file PDF dapat dibaca dan berisi nomor sengketa yang valid.',
                    'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
                ];
            }

            if ($extractedNumber !== $sengketa->no_sengketa) {
                return [
                    'success' => false,
                    'message' => 'Nomor sengketa tidak cocok dengan nomor yang diekstraksi dari file putusan.',
                    'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
                ];
            }

            // adjust to the statusPutusan input on the blockchain api
            $statusPutusan = $request['id_jenis_putusan'] - 4;
            Log::info("Status Putusan for Blockchain: " . $statusPutusan);
            
            // get hash from blockchain api
            Log::info("Tambah Putusan ke Blockchain...");
            $hash = $this->tambahPutusan(
                $sengketa->id,
                $sengketa_history->id,
                $statusPutusan,
                $filePutusan,
                $request['putusan_link_jdih'],
                $jenis_putusan->is_selesai
            );

            
            if (is_array($hash)) {
                Log::info("Hash Putusan Error: " . json_encode($hash));
                return [
                    'success' => false,
                    'message' => 'Gagal menambahkan putusan ke blockchain: ' . ($hash['error'] ?? 'Unknown error'),
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
                'hash' => $hash
            ];
        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            Log::warning('Rollback triggered due to exception in create()');
            DB::rollback();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function tambahPutusan(
        string $idSengketa,
        string $idJadwal,
        string $statusPutusan,
        $cidPath,
        string $jdih,
        bool $putusanSelesai
    ) {
        $url = $putusanSelesai
            ? Constant::$BLOCKCHAIN_URL . '/contracts/putusan-selesai'
            : Constant::$BLOCKCHAIN_URL . '/contracts/tambah-putusan';
        LOG::info("Full URL for Tambah Putusan: " . $url);
        $fullPath = storage_path('app/sensitive/' . $cidPath);
        LOG::info("Full Path for Tambah Putusan: " . $fullPath);


        if (file_exists($fullPath)) {
            $fileContent = file_get_contents($fullPath);
            $fileName = basename($cidPath);

            $requestPayload = [
                'idSengketa' => $idSengketa,
                'idJadwal' => $idJadwal,
                'statusPutusan' => $statusPutusan,
                'jdih' => $jdih,
            ];
            
            Log::info("Tambah Putusan Payload to Blockchain:", $requestPayload);
            $response = Http::attach('cid', $fileContent, $fileName)
                ->post($url, $requestPayload);
            Log::info("Tambah Putusan Response: " . $response->body());
            if ($response->successful()) {
                $jsonArray = $response->json();
                return $jsonArray['data']['hash'];
            } else {
                return null;
            }
        } else {
            return ['error' => 'File not found'];
        }
    }

    public function getNomorFromVerification($filePath)
    {
        $base = rtrim(config('services.ai_service_url', env('AI_SERVICE_URL', 'http://127.0.0.1:3031')), '/');
        $url  = $base . '/api/extract';

        $fullPath = storage_path('app/sensitive/' . ltrim($filePath, '/'));

        if (! file_exists($fullPath)) {
            Log::warning('File tidak ditemukan untuk verifikasi AI', ['path' => $fullPath]);
            return null;
        }

        try {
            $response = Http::timeout(60) // timeout eksplisit 60 detik
                ->attach(
                    'pdf_file',
                    file_get_contents($fullPath),
                    basename($filePath)
                )
                ->post($url);

            if ($response->successful()) {
                $json = $response->json();
                return $json['Nomor'] ?? null;
            }

            Log::error('AI Verification API request failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'url'    => $url,
            ]);
            return null;

        } catch (\Throwable $e) {
            Log::error('Error tak terduga saat memanggil AI service', [
                'url'   => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }


    public function delete($id)
    {
        $sengketa_history = SengketaHistory::findOrFail($id);
        $sengketa = Sengketa::findOrFail($sengketa_history->id_sengketa);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa_history->status != Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN) {
            return [
                'success' => false,
                'message' => 'Sidang belum memiliki putusan. Gagal menghapus putusan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $sengketa_history->update([
                'id_jenis_putusan' => null,
                'putusan_link_jdih' => null,
                'file3' => null,
                'is_selesai' => null,
                'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
            ]);

            $last_history = SengketaHistory::where('id_sengketa', $sengketa_history->id_sengketa)
                ->orderBy('id', 'desc')
                ->firstOrFail();

            if ($last_history->id == $id) {
                $sengketa->update([
                    'is_selesai' => null,
                    'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
                    'id_sidang_putusan' => $sengketa_history->id_jenis_sidang,
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];
        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $id,
            ]);
            DB::rollback();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menghapus data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }
}
