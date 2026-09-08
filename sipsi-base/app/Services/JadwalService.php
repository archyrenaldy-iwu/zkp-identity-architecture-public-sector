<?php

namespace App\Services;

use App\Models\Pemohon;
use App\Models\Sengketa;
use App\Models\SengketaHistory;
use App\Models\User;
use Carbon\Carbon;
use Constant;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Roles;

class JadwalService
{
    //service generate doc
    protected $docGeneratorService;

    //service send email
    protected $sendEmailService;

    public function __construct(DocGeneratorService $docGeneratorService, SendEmailService $sendEmailService)
    {
        $this->docGeneratorService = $docGeneratorService;
        $this->sendEmailService = $sendEmailService;
    }

    public function list($request)
    {
        $data = SengketaHistory::select('sengketa.id as id_sengketa', 'sengketa_history.id as id_history', 'no_registrasi', 'sidang_waktu', 'p.nama as nama_pemohon', 'p.email as email_pemohon', 'p.no_hp as wa_pemohon', 't.nama as nama_termohon', 'jsp.nama as sidang_nama', 'sidang_agenda', 'sengketa_history.file1 as file_reelas_pemohon', 'sengketa_history.file2 as file_reelas_termohon', 'sengketa_history.file3 as file_putusan', 'sengketa_history.reelas_sudah_kirim', 'sengketa_history.reelas_waktu_kirim', 'kc.timezone', 'no_sengketa')
            ->join('sengketa', 'sengketa.id', '=', 'sengketa_history.id_sengketa')
            ->join('ki_config AS kc', 'sengketa.id_ki', '=', 'kc.id')
            ->join('pemohon as p', 'p.id', '=', 'sengketa.id_pemohon')
            ->join('termohon as t', 't.id', '=', 'sengketa.id_termohon')
            ->Join('jenis_sidang_putusan as jsp', 'jsp.id', '=', 'sengketa_history.id_jenis_sidang')
            ->whereNotNull('sengketa_history.id_jenis_sidang')
            ->whereNull('sengketa_history.deleted_at')
            ->whereNull('sengketa.deleted_at')
            ->withPerangkat()
            ->orderByDesc('sengketa_history.id');

        if (isset($request['jenis_sidang']) && $request['jenis_sidang']) {
            $data->where('sengketa_history.id_jenis_sidang', $request['jenis_sidang']);
        }

        if (isset($request['no_registrasi']) && $request['no_registrasi']) {
            $data->where('no_registrasi', 'ilike', trim($request['no_registrasi']) . '%');
        }

        if (isset($request['no_sengketa']) && $request['no_sengketa']) {
            $data->where('no_sengketa', 'ilike', trim($request['no_sengketa']) . '%');
        }

        if (isset($request['tanggal1']) && $request['tanggal1'] && isset($request['tanggal2']) && $request['tanggal2']) {
            $tanggal1 = date('Y-m-d 00:00:00', strtotime($request['tanggal1']));
            $tanggal2 = date('Y-m-d 23:59:59', strtotime($request['tanggal2']));
            $data->whereBetween(DB::raw('DATE(sidang_waktu)'), [$tanggal1, $tanggal2]);
        } else {
            if (!isset($request['id_history']) && !isset($request['no_registrasi']) && !isset($request['no_sengketa'])) {
                $today = Carbon::today()->toDateString();
                $data->whereDate(DB::raw('DATE(sidang_waktu)'), $today);
            }
        }

        if (Auth::check()) {
            if (isset($request['id_ki']) && $request['id_ki'] && !isUserInternal()) {
                $data->where('sengketa.id_ki', $request['id_ki']);
            }

            if (isUserInternal()) {
                $data->where('sengketa.id_ki', idKiAuth());
            }

            if (getActiveRole(Roles::ROLE_PEMOHON)) {
                $pemohon = Pemohon::where('id_user', Auth::user()->id)->firstOrFail();
                $data->where('sengketa.id_pemohon', $pemohon->id);
            }
        } else {
            if (isset($request['id_ki']) && $request['id_ki']) {
                $data->where('sengketa.id_ki', $request['id_ki']);
            }
        }

        if (isset($request['id_history']) && $request['id_history']) {
            $data->join('user_internal as ui', 'sengketa.id_panitera_pengganti', '=', 'ui.id')
                ->addSelect('ui.nama as nama_panitera')
                ->where('sengketa_history.id', $request['id_history']);

            return $data->first();
        }

        return datatables()->of($data->get())->make(true);
    }

    public function listSengketa($request)
    {
        $data = Sengketa::select('sengketa.id', 'no_registrasi', 'no_sengketa', 'p.nama AS nama_pemohon', 't.nama AS nama_termohon', 'tanggal_permohonan', 'kc.alamat as alamat_ki', 'kc.timezone', 'no_sengketa')
            ->withCustomStatus()
            ->join('pemohon AS p', 'sengketa.id_pemohon', '=', 'p.id')
            ->join('termohon AS t', 'sengketa.id_termohon', '=', 't.id')
            ->join('ki_config as kc', 'sengketa.id_ki', '=', 'kc.id')
            ->active()
            ->where('is_lengkap_perangkat', true)
            ->where('sengketa.is_selesai', false)
            ->orderByDesc('sengketa.id');

        if (isset($request['status'])) {
            $data->where('sengketa.status', $request['status']);
            $data->where('sengketa.is_selesai', false);
        }

        if (isset($request['no_registrasi']) && $request['no_registrasi']) {
            $data->where('no_registrasi', 'ilike', trim($request['no_registrasi']) . '%');
        }

        if (isset($request['no_sengketa']) && $request['no_sengketa']) {
            $data->where('no_sengketa', 'ilike', trim($request['no_sengketa']) . '%');
        }

        if (isset($request['tanggal1']) && $request['tanggal1'] && isset($request['tanggal2']) && $request['tanggal2']) {
            $data->whereBetween(DB::raw('DATE(sengketa.created_at)'), [$request['tanggal1'], $request['tanggal2']]);
        }

        if (isUserInternal()) {
            $data->where('id_ki', idKiAuth());
        }

        if (isset($request['id_ki']) && $request['id_ki'] && !isUserInternal()) {
            $data->where('sengketa.id_ki', $request['id_ki']);
        }

        if (isset($request['id_sengketa']) && $request['id_sengketa']) {
            $data->where('sengketa.id', $request['id_sengketa']);

            return $data->first();
        }

        return $data->get();
    }

    public function historySidangSengketa($id_sengketa)
    {
        $data = DB::table('sengketa as s')
            ->select(
                's.id as id_sengketa',
                's.no_registrasi as no_registrasi',
                'sh.id as id_history',
                'jsp.nama as jenis_sidang',
                'sh.sidang_waktu',
                'sh.sidang_agenda',
                'sh.file1 as file_reelas_pemohon',
                'sh.file2 as file_reelas_termohon',
                'sh.file3 as file_putusan',
                'sh.reelas_sudah_kirim',
                'sh.reelas_waktu_kirim',
                'kc.timezone',
                's.no_sengketa'
            )
            ->join('ki_config AS kc', 's.id_ki', '=', 'kc.id')
            ->join('sengketa_history as sh', 's.id', '=', 'sh.id_sengketa')
            ->join('jenis_sidang_putusan as jsp', 'sh.id_jenis_sidang', '=', 'jsp.id')
            ->where('s.id', $id_sengketa)
            ->whereNull('s.deleted_at')
            ->whereNull('sh.deleted_at')
            ->whereIn('sh.status', [Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG, Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN])
            ->orderBy('sh.id', 'asc');

        if (isUserInternal()) {
            $data->where('id_ki', idKiAuth());
        }

        return $data->get();
    }

    public function create($request)
    {
        $sengketa = Sengketa::findOrFail($request['id_sengketa']);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if (!$sengketa->is_lengkap_perangkat) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih belum lengkap perangkat persidangannya. Gagal menambah jadwal.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai. Gagal menambah jadwal.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            Log::info("Create Sidang...");            
            DB::beginTransaction();

            if (updateHistoryIsCurrent($sengketa->id)) {
                $sengketa_history = SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
                    'id_jenis_sidang' => $request['id_jenis_sidang'],
                    'sidang_agenda' => $request['sidang_agenda'],
                    'sidang_waktu' => $request['sidang_waktu'],
                    'sidang_alamat' => $request['sidang_alamat'],
                    'is_current' => true,
                ]);
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
                'id_sidang_putusan' => $request['id_jenis_sidang'],
            ]);

            // Get hash from blockchain API
            $hash = $this->tambahSidang(
                $sengketa->id,
                $sengketa_history->id,
                $sengketa_history->id_jenis_sidang,
                $sengketa_history->sidang_agenda,
                $sengketa_history->sidang_waktu,
                $sengketa_history->sidang_alamat,
            );

            if (!$hash) {
                throw new Exception('Gagal mendapatkan hash dari blockchain');
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
            DB::rollback();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }


    public function tambahSidang(string $idSengketa, string $idJadwal, string $idJenisSidang, string $agenda, string $tanggal, string $alamat)
    {
        try {
            // 🧩 1. Pastikan jenis tidak melebihi batas validasi di blockchain
            $jenis = (int) $idJenisSidang;
            if ($jenis > 2) {
                Log::warning("Jenis sidang ($jenis) melebihi batas blockchain, diubah ke 2.");
                $jenis = 2;
            }

            // ⏰ 2. Pastikan tanggal tidak lebih kecil dari waktu sekarang
            $now = new DateTime();
            $tanggalObj = new DateTime($tanggal);

            if ($tanggalObj < $now) {
                Log::warning("Tanggal sidang ($tanggal) di masa lalu, otomatis disesuaikan +1 jam.");
                $tanggalObj->modify('+1 hour');
                $tanggal = $tanggalObj->format('Y-m-d H:i:s');
            }

            // 🧾 3. Tentukan endpoint dan payload
            if ($jenis == 1) {
                $url = Constant::$BLOCKCHAIN_URL . '/contracts/pembuatan-jadwal-sidang-awal';
                $payload = [
                    'idSengketa' => $idSengketa,
                    'idJadwal' => $idJadwal,
                    'agenda' => $agenda,
                    'tanggal' => $tanggal,
                    'alamat' => $alamat,
                ];
            } else {
                $url = Constant::$BLOCKCHAIN_URL . '/contracts/tambah-sidang';
                $payload = [
                    'idSengketa' => $idSengketa,
                    'idJadwal' => $idJadwal,
                    'jenis' => $jenis,
                    'agenda' => $agenda,
                    'tanggal' => $tanggal,
                    'alamat' => $alamat,
                ];
            }

            // 🪵 Logging payload
            Log::info('Calling blockchain API', [
                'url' => $url,
                'payload' => $payload
            ]);

            // 🚀 4. Kirim ke blockchain
            $response = Http::post($url, $payload);

            // 🧩 5. Tangani respons
            if ($response->successful()) {
                $jsonArray = $response->json();

                Log::info('Response Json', ['json' => $jsonArray]);
                Log::info('Blockchain raw response', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                if (isset($jsonArray['data']['hash'])) {
                    return $jsonArray['data']['hash'];
                } else {
                    Log::warning('Unexpected blockchain response structure', [
                        'url' => $url,
                        'response' => $jsonArray
                    ]);
                    return null;
                }
            } else {
                Log::error('Blockchain request failed', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }
        } catch (\Throwable $e) {
            Log::error('Exception in tambahSidang()', [
                'url' => $url ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    public function delete($request, $id)
    {
        $sengketa_history = SengketaHistory::findOrFail($id);
        $sengketa = Sengketa::findOrFail($sengketa_history->id_sengketa);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa sudah selesai. Gagal menghapus sidang.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            if (updateHistoryIsCurrent($sengketa->id)) {
                //nothing
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            $sengketa_history->delete();

            $sengketa_history = SengketaHistory::where('id_sengketa', $sengketa_history->id_sengketa)
                ->orderBy('created_at', 'desc')
                ->first();
            $sengketa_history->update(['is_current' => true]);

            $sengketa->update([
                'status' => $sengketa_history->status,
                'id_sidang_putusan' => $sengketa_history->id_jenis_sidang,
            ]);

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
                'request' => $request,
            ]);
            DB::rollback();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menghapus data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function reelasCreate($id)
    {
        $sengketa_history = SengketaHistory::findOrFail($id);
        $sengketa = Sengketa::findOrFail($sengketa_history->id_sengketa);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa_history->file1) {
            return [
                'success' => false,
                'message' => 'Reelas sudah ada. Gagal bikin reelas.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa_history->status != Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG) {
            return [
                'success' => false,
                'message' => 'Tidak berada dalam proses sidang. Gagal bikin reelas.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa_history->id_jenis_putusan || $sengketa_history->putusan_link_jdih || $sengketa_history->file3) {
            return [
                'success' => false,
                'message' => 'Sidang ini sudah memiliki putusan. Gagal bikin reelas.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $no_reelas = generateNomor($sengketa_history->sengketa->id_ki, Constant::TEMPALTE_KODE_SURAT_REELAS);

            //PROSES BIKIN REELAS
            $relaas = $this->docGeneratorService->genDocRelaas($no_reelas, $sengketa_history);

            $sengketa_history->update([
                'file1' => $relaas[0], //pemohon
                'file2' => $relaas[1], //termohon
                'penomoran' => $no_reelas,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Berhasil membuat reelas',
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

    public function reelasSend($id)
    {
        $sengketa_history = SengketaHistory::findOrFail($id)->load('sengketa.pemohon');
        $sengketa = Sengketa::findOrFail($sengketa_history->id_sengketa);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if (!$sengketa_history->file1) {
            return [
                'success' => false,
                'message' => 'File reelas belum ada. Gagal mengirim reelas.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa_history->reelas_sudah_kirim || $sengketa_history->reelas_waktu_kirim) {
            return [
                'success' => false,
                'message' => 'Reelas sudah pernah dikirim untuk sidang ini. Gagal mengirim reelas.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            //PROSES KIRIM REELAS
            $user = User::find($sengketa_history->sengketa->pemohon->id_user);
            $sendSuccess = $this->sendEmailService->sendReelasEmail($sengketa_history, $user);

            if (!$sendSuccess) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim email. Gagal mengirim reelas.',
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            $sengketa_history->update([
                'reelas_sudah_kirim' => true,
                'reelas_waktu_kirim' => Carbon::now(),
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Berhasil mengirim reelas',
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
