<?php

namespace App\Services;

use App\Models\JenisSidangPutusan;
use App\Models\Pemohon;
use App\Models\Sengketa;
use App\Models\SengketaHistory;
use App\Models\Termohon;
use App\Models\User;
use App\Models\UserInternal;
use Carbon\Carbon;
use Constant;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Roles;
use StorageHelper;
use GuzzleHttp\Client;

class SengketaService
{
    //service generate doc
    protected $docGeneratorService;
    protected $zkpService;

    public function __construct(DocGeneratorService $docGeneratorService, ZkpService $zkpService)
    {
        $this->docGeneratorService = $docGeneratorService;
        $this->zkpService = $zkpService;
    }

    public function list($request)
    {
        $data = Sengketa::select('sengketa.id', 'sengketa.id_ki', 'no_registrasi', 'p.nama AS nama_pemohon', 't.nama AS nama_termohon', 'no_sengketa')
            ->withCustomStatus()
            ->withAction()
            ->join('pemohon AS p', 'sengketa.id_pemohon', '=', 'p.id')
            ->join('termohon AS t', 'sengketa.id_termohon', '=', 't.id')
            ->orderByDesc('sengketa.id');

        if (isset($request['status'])) {
            if ($request['status'] == Constant::STATUS_SENGKETA_SELESAI) {
                $data->where('sengketa.is_selesai', true);
            } elseif ($request['status'] == Constant::STATUS_SENGKETA_DIHAPUS && getActiveRole(Roles::ROLE_SUPERADMIN)) {
                $data->withTrashed()->whereNotNull('sengketa.deleted_at');
            } else {
                $data->where('sengketa.status', $request['status']);
                $data->where('sengketa.is_selesai', false);
            }
        }

        if (isset($request['no_sengketa']) && $request['no_sengketa']) {
            $data->where('no_sengketa', $request['no_sengketa']);
        } else {
            if (isset($request['tanggal1']) && $request['tanggal1'] && isset($request['tanggal2']) && $request['tanggal2']) {
                $data->whereBetween(DB::raw('DATE(sengketa.created_at)'), [$request['tanggal1'], $request['tanggal2']]);
            }
        }

        if (isset($request['id_ki']) && $request['id_ki'] && !isUserInternal()) {
            $data->where('id_ki', $request['id_ki']);
        }

        if (isUserInternal()) {
            $data->where('id_ki', idKiAuth());
        }

        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            $data->where('id_pemohon', Auth::user()->pemohon->id);
        }

        return $data->get();
    }

    public function show($id)
    {
        $sengketa = Sengketa::with([
            'pemohon',
            'termohon',
            'history' => function ($query) {
                $query->where('is_current', true);
            }
        ])
            ->select('sengketa.*')
            ->withPerangkat()
            ->withCustomStatus()
            ->withAction()
            ->where('sengketa.id', $id);

        if (isUserInternal()) {
            $sengketa->where('sengketa.id_ki', idKiAuth());
        }

        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            $sengketa->where('sengketa.id_pemohon', Auth::user()->pemohon->id);
        }

        $sengketa = $sengketa->first();

        if (!$sengketa) {
            abort(Constant::HTTP_CODE_ERROR_NOT_FOUND);
        }

        // Check if user identity is approved
        $isApproved = false;
        try {
            $isApproved = $this->zkpService->isApproved($sengketa->pemohon->nomor_identitas);
        } catch (\Exception $e) {
            Log::error('Failed to check approval status: ' . $e->getMessage());
        }

        $data = $sengketa->toArray();
        $data['is_approved'] = $isApproved;

        return [
            'success' => true,
            'data' => $data,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }

    public function lacak($id)
    {
        $sengketa = Sengketa::with([
            'history' => function ($query) {
                $query->orderBy('id', 'asc');
            }
        ])
            ->select('sengketa.id', 'sengketa.no_registrasi', 'sengketa.tanggal_permohonan', 'sengketa.no_sengketa', 'p.nama AS nama_pemohon', 't.nama AS nama_termohon', 'kc.timezone', 'sengketa.no_registrasi_online')
            ->join('pemohon AS p', 'sengketa.id_pemohon', '=', 'p.id')
            ->join('termohon AS t', 'sengketa.id_termohon', '=', 't.id')
            ->join('ki_config AS kc', 'sengketa.id_ki', '=', 'kc.id')
            ->withPerangkat()
            ->active()
            ->where('sengketa.id', $id)
            ->first();

        if (!$sengketa) {
            abort(Constant::HTTP_CODE_ERROR_NOT_FOUND);
        }

        $new_history = [];
        $idx = 0;
        foreach ($sengketa['history'] as $history) {
            Carbon::setLocale('id');
            $createdAt = Carbon::parse($history->created_at);
            $formattedCreatedDate = $createdAt->translatedFormat('l, j F Y \P\u\k\u\l H:i');

            switch ($history->status) {
                case Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI:
                    $new_history[$idx] = [
                        'waktu' => $formattedCreatedDate . ' ' . $sengketa->timezone,
                        'nama' => 'Pengajuan Sengketa',
                        'file' => $history->file1,
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_PENGAJUAN_ULANG:
                    $waktu_history = Carbon::parse($history->created_at);
                    $formattedWaktu = $waktu_history->translatedFormat('l, j F Y \P\u\k\u\l H:i');
                    $new_history[$idx] = [
                        'waktu' => $formattedWaktu . ' ' . $sengketa->timezone,
                        'nama' => 'Pengajuan Sengketa Ulang',
                        'file' => $history->file1,
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_TERVERIFIKASI:
                    $new_history[$idx] = [
                        'waktu' => $formattedCreatedDate . ' ' . $sengketa->timezone,
                        'nama' => 'Sengketa Diterima',
                        'file' => $history->file1,
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_DITOLAK:
                    $new_history[$idx] = [
                        'waktu' => $formattedCreatedDate . ' ' . $sengketa->timezone,
                        'nama' => 'Sengketa Ditolak',
                        'file' => $history->file1,
                        'is_selesai' => $history->is_selesai,
                        'keterangan' => 'Permohonan sengketa gagal karena telah melebihi batas waktu pengisian kelengkapan formulir',
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_DIBATALKAN:
                    $new_history[$idx] = [
                        'waktu' => $formattedCreatedDate . ' ' . $sengketa->timezone,
                        'nama' => 'Sengketa Dibatalkan',
                        'is_selesai' => $history->is_selesai,
                        'keterangan' => 'Selesai karena sengketea telah dibatalkan.',
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_DICABUT:
                    $new_history[$idx] = [
                        'waktu' => $formattedCreatedDate . ' ' . $sengketa->timezone,
                        'nama' => 'Sengketa Dicabut',
                        'is_selesai' => $history->is_selesai,
                        'keterangan' => 'Selesai karena sengketea telah dicabut.',
                    ];
                    $idx++;
                    break;

                case Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG:
                case Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN:
                    $sidangWaktu = Carbon::parse($history->sidang_waktu);
                    $formattedSidangWaktu = $sidangWaktu->translatedFormat('l, j F Y \P\u\k\u\l H:i');
                    $jenisSidangPutusanNama = JenisSidangPutusan::where('id', $history->id_jenis_sidang)->pluck('nama')->first();

                    $new_history[$idx] = [
                        'is_sidang' => true,
                        'is_selesai' => $history->is_selesai,
                        'sidang_waktu' => $formattedSidangWaktu . ' ' . $sengketa->timezone,
                        'sidang_nama' => $jenisSidangPutusanNama,
                        'sidang_agenda' => $history->sidang_agenda,
                    ];

                    if (getActiveRole(Roles::ROLE_PEMOHON)) {
                        $new_history[$idx]['file_reelas_pemohon'] = $history->file1;
                    } elseif (Auth::check()) {
                        $new_history[$idx]['file_reelas_pemohon'] = $history->file1;
                        $new_history[$idx]['file_reelas_termohon'] = $history->file2;
                    }

                    if ($history->status == Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN) {
                        $jenisSidangPutusanNama = JenisSidangPutusan::where('id', $history->id_jenis_putusan)->pluck('nama')->first();
                        $new_history[$idx]['putusan_nama'] = $jenisSidangPutusanNama;
                        $new_history[$idx]['putusan_link_jdih'] = $history->putusan_link_jdih;

                        if (Auth::check()) {
                            $new_history[$idx]['file_putusan'] = $history->file3;
                        }
                    }
                    $idx++;
                    break;
            }
        }

        $new_sengketa = [
            'id' => $sengketa->id,
            'no_registrasi' => $sengketa->no_registrasi,
            'no_sengketa' => $sengketa->no_sengketa,
            'no_registrasi_online' => $sengketa->no_registrasi_online,
            'tanggal_permohonan' => $sengketa->tanggal_permohonan,
            'nama_pemohon' => $sengketa->nama_pemohon,
            'nama_termohon' => $sengketa->nama_termohon,
            'nama_ketua' => $sengketa->nama_ketua,
            'nama_anggota1' => $sengketa->nama_anggota1,
            'nama_anggota2' => $sengketa->nama_anggota2,
            'nama_mediator' => $sengketa->nama_mediator,
            'nama_panitera_pengganti' => $sengketa->nama_panitera_pengganti,
            'nama_panitera_utama' => $sengketa->nama_panitera_utama,
            'history' => $new_history,
        ];

        return [
            'success' => true,
            'data' => $new_sengketa,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();

            /// ZKP VERIFICATION ///
            // Get pemohon data first
            $pemohon = null;
            if (getActiveRole(Roles::ROLE_PEMOHON)) {
                $pemohon = Auth::user()->pemohon;
            } else {
                $pemohon = Pemohon::findOrFail($request['id_pemohon']);
            }

            if (!$pemohon) {
                throw new \Exception('Data pemohon tidak ditemukan');
            }

            // Format the date from YYYY-MM-DD to YYYYMMDD
            $ttl = $pemohon->tanggal_lahir ? date('Ymd', strtotime($pemohon->tanggal_lahir)) : '20000101';

            Log::info('Parameter ZKP Hash:', [
                'userId' => $pemohon->nomor_identitas,
                'nik' => $pemohon->nomor_identitas,
                'nama' => $pemohon->nama,
                'ttl' => $ttl,
                'key' => $request['form_kata_kunci_identitas']
            ]);

            // Check if user has already approved their hash
            $isApproved = $this->zkpService->isApproved($pemohon->nomor_identitas);

            if ($isApproved) {
                // If already approved, verify the hash
                $verifyResult = $this->zkpService->verifyIdentityHash(
                    $pemohon->nomor_identitas,
                    $pemohon->nomor_identitas,
                    $pemohon->nama,
                    $ttl,
                    $request['form_kata_kunci_identitas']
                );
                
                if (!$verifyResult['success']) {
                    throw new \Exception('Identity verification failed: ' . ($verifyResult['message'] ?? 'Unknown error'));
                }
            } else {
                // If not approved, submit new hash
                $hashResult = $this->zkpService->submitHashToBlockchain(
                    $pemohon->nomor_identitas,
                    $pemohon->nomor_identitas,
                    $pemohon->nama,
                    $ttl,
                    $request['form_kata_kunci_identitas']
                );
                
                if (!$hashResult['success']) {
                    throw new \Exception('Hash submission failed: ' . ($hashResult['message'] ?? 'Unknown error'));
                }
            }
            /// END OF ZKP VERIFICATION ///

            $request = StorageHelper::upload($request);

            $data_sengketa = [
                'id_ki' => !isUserInternal() ? $request['id_ki'] : idKiAuth(),
                'no_registrasi_online' => generateNomor($request['id_ki'], Constant::TEMPLATE_KODE_REGISTRASI_ONLINE),
                'tanggal_permohonan' => $request['tanggal_permohonan'],
                'tanggal_keberatan' => $request['tanggal_keberatan'],
                'file_identitas' => $request['file_identitas'],
                'file_formulir_permohonan' => $request['file_formulir_permohonan'],
                'file_formulir_keberatan' => $request['file_formulir_keberatan'],
                'kuasa_pemohon_nama' => $request['kuasa_pemohon_nama'] ?? null,
                'kuasa_pemohon_jk' => $request['kuasa_pemohon_jk'] ?? null,
                'kuasa_pemohon_alamat' => $request['kuasa_pemohon_alamat'] ?? null,
                'tanggal_jawaban' => $request['tanggal_jawaban'] ?? null,
                'tanggal_tanggapan' => $request['tanggal_tanggapan'] ?? null,
                'file_surat_kuasa' => $request['file_surat_kuasa'] ?? null,
                'file_pemberitahuan_tertulis' => $request['file_pemberitahuan_tertulis'] ?? null,
                'file_jawaban_ppid' => $request['file_jawaban_ppid'] ?? null,
                'file_tanggapan_atasan_ppid' => $request['file_tanggapan_atasan_ppid'] ?? null,
                'file_pendukung1' => $request['file_pendukung_sengketa1'] ?? null,
                'file_pendukung2' => $request['file_pendukung_sengketa2'] ?? null,
                'alasan_permohonan' => $request['alasan_permohonan'] ?? null,
                'is_selesai' => false,
                'id_pemohon' => getActiveRole(Roles::ROLE_PEMOHON) ? Auth::user()->pemohon->id : $request['id_pemohon'],
                'status' => Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
            ];
            $data_sengketa['no_registrasi'] = $data_sengketa['no_registrasi_online'];

            //untuk mengambil id termohon
            $termohon = Termohon::create([
                'nama' => $request['termohon_nama'],
                'alamat' => $request['termohon_alamat'] ?? null,
                'no_telp' => $request['termohon_no_telp'] ?? null,
                'no_hp' => $request['termohon_no_hp'] ?? null,
                'email' => $request['termohon_email'] ?? null,
            ]);
            $data_sengketa['id_termohon'] = $termohon->id;

            $sengketa = Sengketa::create($data_sengketa);

            //generate doc
            $path_doc = $this->docGeneratorService->genDocFormModul($sengketa, $termohon);
            Log::info('path_doc', ['path_doc' => $path_doc]);
            SengketaHistory::create([
                'id_sengketa' => $sengketa->id,
                'status' => Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
                'file1' => $path_doc,
                'is_current' => true,
                'penomoran' => $data_sengketa['no_registrasi_online'],
            ]);

            DB::commit();

            $hash = $this->menerimaSengketaBlockchain($sengketa->id, $sengketa->id_pemohon, $sengketa->id_termohon);

            $response = [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
                'data' => $sengketa,
                'hash' => $hash,
            ];

            Log::info('Return response:', $response);

            return $response;

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollback();

            // Check if error on failed identity verification
            if (strpos($e->getMessage(), 'Failed to verify identity') === 0) {
                return [
                    'success' => false,
                    'message' => 'Identitas tidak dapat diverifikasi. Pastikan kata kunci identitas yang dimasukkan sudah benar.',
                    'http_code' => 406,
                ];
            }

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function menerimaSengketaBlockchain(string $id_sengketa, string $pemohon, string $termohon)
    {
        $url = Constant::$BLOCKCHAIN_URL . '/contracts/menerima-sengketa';

        Log::info('Request to Blockchain API:', [
            'url' => $url,
            'data' => [
                'idSengketa' => $id_sengketa,
                'pemohon' => $pemohon,
                'termohon' => $termohon
            ]
        ]);

        $response = Http::post($url, [
            'idSengketa' => $id_sengketa,
            'pemohon' => $pemohon,
            'termohon' => $termohon
        ]);

        if ($response->successful()) {
            $jsonArray = $response->json();
            Log::info('Response:', ['response' => $jsonArray]);

            return $jsonArray['data']['hash'] ?? '';
        } else {
            Log::error('Blockchain API Request Failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }

    public function terima($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);
        $user_internal = UserInternal::findOrFail($request['id_user_internal']);

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if (!in_array($sengketa->status, [
            Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
            Constant::STATUS_SENGKETA_PENGAJUAN_ULANG
        ])) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap menunggu verifikasi',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if (!$user_internal->user->hasRole(Roles::ROLE_PANITERA)) {
            return [
                'success' => false,
                'message' => 'User ini bukan ' . Roles::ROLE_PANITERA,
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if (isUserInternal()) {
            if ($user_internal->id_ki != idKiAuth()) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat memilih panitera dari KI lain',
                    'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
                ];
            }

            if ($sengketa->id_ki != idKiAuth()) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat menerima sengketa dari KI lain',
                    'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
                ];
            }
        }

        try {
            DB::beginTransaction();

            // === Approve user identity first (skip jika sudah approved) ===
            $alreadyApproved = $this->zkpService->isApproved($sengketa->pemohon->nomor_identitas);

            if ($alreadyApproved) {
                Log::info("Approval skipped for user: " . $sengketa->pemohon->nomor_identitas, [
                    'userId' => $sengketa->pemohon->nomor_identitas,
                    'status' => 'already_approved'
                ]);
            } else {
                try {
                    Log::info("Starting approval for user via ZKP backend: " . $sengketa->pemohon->nomor_identitas, [
                        'userId' => $sengketa->pemohon->nomor_identitas
                    ]);

                    $this->zkpService->approveUser($sengketa->pemohon->nomor_identitas);

                    Log::info("User approved successfully via ZKP backend: " . $sengketa->pemohon->nomor_identitas, [
                        'userId' => $sengketa->pemohon->id,
                        'status' => 'approved'
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to approve user: ' . $e->getMessage(), [
                        'userId' => $sengketa->pemohon->id
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Gagal melakukan verifikasi identitas',
                        'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                    ];
                }
            }
            // === End of Approve user identity ===

            // Generate nomor registrasi dan sengketa
            $no_registrasi = generateNomor($sengketa->id_ki, Constant::TEMPLATE_KODE_AKTA_REGISTRASI, $sengketa->no_registrasi_online);
            $no_sengketa = generateNomor($sengketa->id_ki, Constant::TEMPLATE_KODE_NOMOR_SENGKETA, $sengketa->no_registrasi_online);

            // Update sengketa
            $sengketa->update([
                'no_registrasi' => $no_registrasi,
                'no_sengketa' => $no_sengketa,
                'id_panitera_utama' => $request['id_user_internal'],
                'status' => Constant::STATUS_SENGKETA_TERVERIFIKASI,
            ]);

            // Generate doc
            $path_doc = $this->docGeneratorService->genDocAktaRegistrasi($sengketa);

            // Update history
            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_TERVERIFIKASI,
                    'file1' => $path_doc,
                    'is_current' => true,
                    'penomoran' => $no_sengketa,
                ]);
            } else {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            if ($sengketa->file_identitas) {
                Storage::delete($sengketa->file_identitas);

                $sengketa->update([
                    'file_identitas' => null
                ]);
            }

            DB::commit();

            // Hash ke blockchain
            $jumlah = $sengketa->history()->count();
            $skpds = $sengketa->history()->pluck('penomoran')->toArray();
            $hash = $this->validasiSengketaBlockchain($sengketa->id, $jumlah, $skpds);

            $response = [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
                'hash' => $hash,
            ];

            Log::info('Return response:', $response);
            return $response;

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function validasiSengketaBlockchain(string $id_sengketa, string $jumlah, array $skpd)
    {
        $url = Constant::$BLOCKCHAIN_URL . '/contracts/validasi-sengketa';

        Log::info('Request to Blockchain API:', [
            'url' => $url,
            'data' => [
                'idSengketa' => $id_sengketa,
                'jumlah' => $jumlah,
                'skpd' => $skpd
            ]
        ]);

        $response = Http::post($url, [
            'idSengketa' => $id_sengketa,
            'jumlah' => $jumlah,
            'skpd' => $skpd
        ]);

        if ($response->successful()) {
            $jsonArray = $response->json();
            Log::info('Response:', ['response' => $jsonArray]);

            return $jsonArray['data']['hash'] ?? '';
        } else {
            Log::error('Blockchain API Request Failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }

    public function tolak($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);
        $user_internal = UserInternal::findOrFail($request['id_user_internal']);

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->status != Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI && $sengketa->status != Constant::STATUS_SENGKETA_PENGAJUAN_ULANG) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap menunggu verifikasi',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if (!$user_internal->user->hasRole(Roles::ROLE_PANITERA)) {
            return [
                'success' => false,
                'message' => 'User ini bukan ' . Roles::ROLE_PANITERA,
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if (isUserInternal()) {
            if ($user_internal->id_ki != idKiAuth()) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat memilih panitera dari KI lain',
                    'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
                ];
            }

            if ($sengketa->id_ki != idKiAuth()) {
                return [
                    'success' => false,
                    'message' => 'Tidak dapat menerima sengketa dari KI lain',
                    'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
                ];
            }
        }

        try {
            DB::beginTransaction();

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_DITOLAK,
                'id_panitera_utama' => $request['id_user_internal'],
            ]);

            $no_spkd = generateNomor($sengketa->id_ki, Constant::TEMPLATE_KODE_SURAT_SPKD);

            //check if $request dont have penolakan_checklist
            if (!isset($request['penolakan_checklist'])) {
                $penolakan_checklist = [];
            } else {
                $penolakan_checklist = $request['penolakan_checklist'];
            }

            $pathDoc = $this->docGeneratorService->genDocSPKD($sengketa, $request['penolakan_info'], $penolakan_checklist, $no_spkd);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_DITOLAK,
                    'penolakan_info' => $request['penolakan_info'] ?? null,
                    'penolakan_checklist' => $penolakan_checklist ?? null,
                    'is_current' => true,
                    'file1' => $pathDoc,
                    'penomoran' => $no_spkd,
                ]);
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                    'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
                ];
            }

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function update($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);
        $termohon = Termohon::findOrFail($sengketa->id_termohon);

        if (getActiveRole(Roles::ROLE_PEMOHON) && $sengketa->id_pemohon != Auth::user()->pemohon->id) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        } elseif (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->status != Constant::STATUS_SENGKETA_DITOLAK) {
            return [
                'success' => false,
                'message' => 'Anda tidak dapat mengubah sengketa ini karena status sengketa bukan ditolak.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $request = StorageHelper::upload($request);

            $data_sengketa = [
                'kuasa_pemohon_nama' => $request['kuasa_pemohon_nama'] ?? $sengketa->kuasa_pemohon_nama,
                'kuasa_pemohon_jk' => $request['kuasa_pemohon_jk'] ?? $sengketa->kuasa_pemohon_jk,
                'kuasa_pemohon_alamat' => $request['kuasa_pemohon_alamat'] ?? $sengketa->kuasa_pemohon_alamat,
                'tanggal_permohonan' => $request['tanggal_permohonan'] ?? $sengketa->tanggal_permohonan,
                'tanggal_keberatan' => $request['tanggal_keberatan'] ?? $sengketa->tanggal_keberatan,
                'tanggal_jawaban' => $request['tanggal_jawaban'] ?? $sengketa->tanggal_jawaban,
                'tanggal_tanggapan' => $request['tanggal_tanggapan'] ?? $sengketa->tanggal_tanggapan,
                'file_identitas' => $request['file_identitas'] ?? $sengketa->file_identitas,
                'file_formulir_keberatan' => $request['file_formulir_keberatan'] ?? $sengketa->file_formulir_keberatan,
                'file_formulir_permohonan' => $request['file_formulir_permohonan'] ?? $sengketa->file_formulir_permohonan,
                'file_surat_kuasa' => $request['file_surat_kuasa'] ?? $sengketa->file_surat_kuasa,
                'file_pemberitahuan_tertulis' => $request['file_pemberitahuan_tertulis'] ?? $sengketa->file_pemberitahuan_tertulis,
                'file_jawaban_ppid' => $request['file_jawaban_ppid'] ?? $sengketa->file_jawaban_ppid,
                'file_tanggapan_atasan_ppid' => $request['file_tanggapan_atasan_ppid'] ?? $sengketa->file_tanggapan_atasan_ppid,
                'file_pendukung1' => $request['file_pendukung_sengketa1'] ?? $sengketa->file_pendukung1,
                'file_pendukung2' => $request['file_pendukung_sengketa2'] ?? $sengketa->file_pendukung2,
                'alasan_permohonan' => $request['alasan_permohonan'] ?? $sengketa->alasan_permohonan,
                'status' => Constant::STATUS_SENGKETA_PENGAJUAN_ULANG,
            ];

            //untuk mengambil id termohon
            $data_termohon = [
                'nama' => $request['termohon_nama'],
                'alamat' => $request['termohon_alamat'] ?? $termohon->alamat,
                'no_telp' => $request['termohon_no_telp'] ?? $termohon->no_telp,
                'no_hp' => $request['termohon_no_hp'] ?? $termohon->no_hp,
                'email' => $request['termohon_email'] ?? $termohon->email,
            ];
            $termohon->update($data_termohon);
            $data_sengketa['id_termohon'] = $termohon->id;

            $sengketa->update($data_sengketa);

            //generate doc
            $path_doc = $this->docGeneratorService->genDocFormModul($sengketa, $termohon);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_PENGAJUAN_ULANG,
                    'file1' => $path_doc,
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

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function batalPengajuan($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (getActiveRole(Roles::ROLE_PEMOHON) && $sengketa->id_pemohon != Auth::user()->pemohon->id) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        } elseif (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        $allowed = [
            Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
            Constant::STATUS_SENGKETA_PENGAJUAN_ULANG,
            Constant::STATUS_SENGKETA_TERVERIFIKASI,
            Constant::STATUS_SENGKETA_DITOLAK,
        ];

        if (!in_array($sengketa->status, $allowed)) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap yang diperbolehkan untuk membatalkan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN,
            ]);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN,
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

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function batalKonfirmasi($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (getActiveRole(Roles::ROLE_PEMOHON) && $sengketa->id_pemohon != Auth::user()->pemohon->id) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        } elseif (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->status != Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap menunggu konfirmasi pembatalan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $cid = $request['file_akta_pembatalan'];

            $request = StorageHelper::upload($request);

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_DIBATALKAN,
                'is_selesai' => true,
            ]);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_DIBATALKAN,
                    'is_selesai' => true,
                    'file1' => $request['file_akta_pembatalan'],
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

            DB::commit();

            $hash = $this->konfirmasiBatalSengketaBlockchain($sengketa->id, $cid);

            $response = [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
                'hash' => $hash,
            ];

            Log::info('Return response:', $response);

            return $response;
        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function konfirmasiBatalSengketaBlockchain(string $id_sengketa, UploadedFile $cid)
    {
        $url = Constant::$BLOCKCHAIN_URL . '/contracts/konfirmasi-batal-sengketa';

        Log::info('Request to Blockchain API:', [
            'url' => $url,
            'data' => [
                'idSengketa' => $id_sengketa,
                'cid' => $cid->getClientOriginalName(),
                'fileMimeType' => $cid->getMimeType(),
            ]
        ]);

        $response = Http::attach('cid', $cid, $cid->getClientOriginalName())->post($url, [
            'idSengketa' => $id_sengketa,
        ]);

        if ($response->successful()) {
            $jsonArray = $response->json();
            Log::info('Response:', ['response' => $jsonArray]);

            return $jsonArray['data']['hash'] ?? '';
        } else {
            Log::error('Blockchain API Request Failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }

    public function cabutPengajuan($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (getActiveRole(Roles::ROLE_PEMOHON) && $sengketa->id_pemohon != Auth::user()->pemohon->id) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        } elseif (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        $allowed = [
            Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
            Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN,
        ];

        if (!in_array($sengketa->status, $allowed)) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap yang diperbolehkan untuk dicabut',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN,
            ]);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN,
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

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function cabutKonfirmasi($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (getActiveRole(Roles::ROLE_PEMOHON) && $sengketa->id_pemohon != Auth::user()->pemohon->id) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        } elseif (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->status != Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap menunggu konfirmasi pencabutan',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        try {
            DB::beginTransaction();

            $cid = $request['file_akta_pencabutan'];

            $request = StorageHelper::upload($request);

            $sengketa->update([
                'status' => Constant::STATUS_SENGKETA_DICABUT,
                'is_selesai' => true,
            ]);

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_DICABUT,
                    'is_selesai' => true,
                    'file1' => $request['file_akta_pencabutan'],
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

            DB::commit();

            $hash = $this->konfirmasiCabutSengketaBlockchain($sengketa->id, $cid);

            $response = [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS,
                'hash' => $hash,
            ];

            Log::info('Return response:', $response);

            return $response;

        } catch (Exception $e) {
            Log::error('Exception caught in ' . __CLASS__ . '::' . __FUNCTION__ . ': ' . $e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $request,
            ]);
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function konfirmasiCabutSengketaBlockchain(string $id_sengketa, UploadedFile $cid)
    {
        $url = Constant::$BLOCKCHAIN_URL . '/contracts/konfirmasi-cabut-sengketa';

        Log::info('Request to Blockchain API:', [
            'url' => $url,
            'data' => [
                'idSengketa' => $id_sengketa,
                'cid' => $cid->getClientOriginalName(),
                'fileMimeType' => $cid->getMimeType(),
            ]
        ]);

        $response = Http::attach('cid', $cid, $cid->getClientOriginalName())->post($url, [
            'idSengketa' => $id_sengketa,
        ]);

        if ($response->successful()) {
            $jsonArray = $response->json();
            Log::info('Response:', ['response' => $jsonArray]);

            return $jsonArray['data']['hash'] ?? '';
        } else {
            Log::error('Blockchain API Request Failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }

    public function delete($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        try {
            DB::beginTransaction();

            if (updateHistoryIsCurrent($sengketa->id)) {
                SengketaHistory::create([
                    'id_sengketa' => $sengketa->id,
                    'status' => Constant::STATUS_SENGKETA_DIHAPUS,
                    'is_current' => true,
                    'alasan_dihapus' => $request['alasan_dihapus'],
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
                'status' => Constant::STATUS_SENGKETA_DIHAPUS,
            ]);
            $sengketa->delete();

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
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE . ' Gagal menghapus data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function listPemohon($request)
    {
        $nomor_identitas = $request['nomor_identitas'] ?? null;
        $pemohon = Pemohon::select([
            'id',
            'nama',
            'jenis_kelamin',
            'alamat',
            'no_telp',
            'no_hp',
            'email',
            'jenis_identitas',
            'nomor_identitas',
            'jenis_pemohon',
        ])
            ->where('nomor_identitas', 'ilike', trim($nomor_identitas) . '%')
            ->whereNull('deleted_at')
            ->get();

        return [
            'success' => true,
            'data' => $pemohon,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }

    public function listUserKi($request)
    {
        $role = $request['role'];
        $id_ki = getActiveRole(Roles::ROLE_SUPERADMIN) ? $request['id_ki'] : idKiAuth();

        $users = User::role($role)
            ->join('user_internal', 'users.id', '=', 'user_internal.id_user')
            ->where('user_internal.id_ki', $id_ki)
            ->select('user_internal.id', 'user_internal.nama', 'user_internal.nomor_identitas')
            ->get();

        return [
            'success' => true,
            'data' => $users,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }

    public function savePerangkat($request, $id)
    {
        $sengketa = Sengketa::findOrFail($id);

        if (isUserInternal() && $sengketa->id_ki != idKiAuth()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        if ($sengketa->is_selesai) {
            return [
                'success' => false,
                'message' => 'Sengketa yang anda pilih sudah selesai.',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        if ($sengketa->status != Constant::STATUS_SENGKETA_TERVERIFIKASI) {
            return [
                'success' => false,
                'message' => 'Sengketa tidak berada dalam tahap terverifikasi',
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ];
        }

        $sengketa->update([
            'id_ketua' => $request['id_ketua'],
            'id_anggota1' => $request['id_anggota1'],
            'id_anggota2' => $request['id_anggota2'],
            'id_mediator' => $request['id_mediator'],
            'id_panitera_pengganti' => $request['id_panitera_pengganti'],
            'is_lengkap_perangkat' => true,
        ]);

        return [
            'success' => true,
            'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];
    }
}