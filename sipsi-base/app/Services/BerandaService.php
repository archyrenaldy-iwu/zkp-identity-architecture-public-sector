<?php

namespace App\Services;

use App\Exports\ExportSengketa;
use App\Models\KiConfig;
use Carbon\Carbon;
use Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Roles;

class BerandaService
{
    public function summary($request)
    {
        $data = DB::table('sengketa')
            ->select(DB::raw("CASE 
                                WHEN is_selesai THEN 'selesai' 
                                ELSE status::text 
                            END AS status_akhir"),
                DB::raw('COUNT(*) AS total'))
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("CASE 
                                WHEN is_selesai THEN 'selesai' 
                                ELSE status::text 
                            END"));

        if (isset($request['status'])) {
            if ($request['status'] == Constant::STATUS_SENGKETA_SELESAI) {
                $data->where('sengketa.is_selesai', true);
            } else {
                $data->where('sengketa.status', $request['status']);
                $data->where('sengketa.is_selesai', false);
            }
        }

        // Perubahan di sini:
        // Hapus filter 30 hari default.
        // Sekarang, hanya akan ada filter tanggal jika 'tanggal1' dan 'tanggal2' disediakan.

        if (isset($request['tanggal1']) && isset($request['tanggal2']) && $request['tanggal1'] && $request['tanggal2']) {
            $data->whereBetween(DB::raw('DATE(sengketa.created_at)'), [$request['tanggal1'], $request['tanggal2']]);
        }
        //  else {
        //     $today = Carbon::today()->toDateString();
        //     $thirtyDaysAgo = Carbon::today()->subDays(30)->toDateString();
        //     $data->whereBetween(DB::raw('DATE(sengketa.created_at)'), [$thirtyDaysAgo, $today]);
        // }

        if (isset($request['id_ki']) && $request['id_ki'] && ! isUserInternal()) {
            $data->where('id_ki', $request['id_ki']);
        }

        if (isUserInternal()) {
            $data->where('id_ki', idKiAuth());
        }

        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            $data->where('sengketa.id_pemohon', Auth::user()->pemohon->id);
        }

        $data = $data->get();

        $result = [
            'baru' => 0,
            'ditolak' => 0,
            'diterima' => 0,
            'pengajuan_pencabutan' => 0,
            'pengajuan_pembatalan' => 0,
            'selesai' => 0,
            'sidang' => 0,
            'total' => 0,
        ];
        foreach ($data as $row) {
            if ($row->status_akhir == Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI || $row->status_akhir == Constant::STATUS_SENGKETA_PENGAJUAN_ULANG) {
                $result['baru'] += $row->total;
            } elseif ($row->status_akhir == Constant::STATUS_SENGKETA_DITOLAK) {
                $result['ditolak'] = $row->total;
            } elseif ($row->status_akhir == Constant::STATUS_SENGKETA_TERVERIFIKASI) {
                $result['diterima'] += $row->total;
            } elseif ($row->status_akhir == Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN) {
                $result['pengajuan_pencabutan'] = $row->total;
            } elseif ($row->status_akhir == Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN) {
                $result['pengajuan_pembatalan'] = $row->total;
            } elseif ($row->status_akhir == 'selesai') {
                $result['selesai'] = $row->total;
            } elseif ($row->status_akhir == Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG) {
                $result['sidang'] = $row->total;
                $result['diterima'] += $row->total;
            }

            $result['total'] += $row->total;
        }

        return [
            'success' => true,
            'data' => $result,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];

    }

    public function download($request)
    {
        Carbon::setLocale('id');
        $tanggal1 = null;
        $tanggal2 = null;
        if (isset($request['tanggal1']) && isset($request['tanggal2']) && $request['tanggal1'] && $request['tanggal2']) {
            $tanggal1 = $request['tanggal1'];
            $tanggal2 = $request['tanggal2'];
        } else {
            $today = Carbon::today()->toDateString();
            $thirtyDaysAgo = Carbon::today()->subDays(30)->toDateString();
            $tanggal1 = $thirtyDaysAgo;
            $tanggal2 = $today;
        }

        $id_ki = null;
        $nama_ki = 'Komisi Informasi';
        if (isset($request['id_ki']) && $request['id_ki'] && ! isUserInternal()) {
            $id_ki = $request['id_ki'];
            $nama_ki = KiConfig::where('id', $request['id_ki'])->pluck('nama')->first();
        }

        if (isUserInternal()) {
            $id_ki = idKiAuth();
            $nama_ki = KiConfig::where('id', idKiAuth())->pluck('nama')->first();
        }

        $data1 = DB::table('sengketa as s')
            ->join('pemohon as p', 's.id_pemohon', '=', 'p.id')
            ->join('termohon as t', 's.id_termohon', '=', 't.id')
            ->join('sengketa_history as sh', function ($join) {
                $join->on('s.id', '=', 'sh.id_sengketa')
                    ->whereNull('sh.deleted_at');
            })
            ->join('ki_config as kc', function ($join) {
                $join->on('s.id_ki', '=', 'kc.id')
                    ->whereNull('kc.deleted_at');
            })
            ->leftJoin('user_internal as ui1', 's.id_ketua', '=', 'ui1.id')
            ->leftJoin('user_internal as ui2', 's.id_anggota1', '=', 'ui2.id')
            ->leftJoin('user_internal as ui3', 's.id_anggota2', '=', 'ui3.id')
            ->leftJoin('user_internal as ui4', 's.id_mediator', '=', 'ui4.id')
            ->leftJoin('user_internal as ui5', 's.id_panitera_pengganti', '=', 'ui5.id')
            ->leftJoin('user_internal as ui6', 's.id_panitera_utama', '=', 'ui6.id')
            ->leftJoin('jenis_sidang_putusan as jsp', 's.id_sidang_putusan', '=', 'jsp.id')
            ->select(
                's.no_sengketa',
                'p.nama as pemohon_nama',
                'p.alamat as pemohon_alamat',
                'p.email as pemohon_email',
                'p.no_hp as pemohon_hp',
                't.nama as termohon_nama',
                't.alamat as termohon_alamat',
                't.email as termohon_email',
                't.no_hp as termohon_hp',
                's.tanggal_permohonan',
                's.tanggal_keberatan',
                's.tanggal_jawaban',
                's.tanggal_tanggapan',
                's.alasan_permohonan',
                'ui1.nama as nama_ketua',
                'ui2.nama as nama_anggota1',
                'ui3.nama as nama_anggota2',
                'ui4.nama as nama_mediator',
                'ui5.nama as nama_panitera_pengganti',
                'ui6.nama as nama_panitera_utama',
                'kc.nama',
                DB::raw('s.created_at::date as tanggal_pengajuan'),
                DB::raw('MIN(CASE WHEN sh.status = 2 THEN sh.created_at::date END) AS tanggal_ditolak'),
                DB::raw('MAX(CASE WHEN sh.status = 1 THEN sh.created_at::date END) AS tanggal_diterima'),
                DB::raw('MAX(CASE WHEN sh.is_selesai THEN sh.created_at::date END) AS tanggal_selesai'),
                DB::raw("CASE 
                            WHEN s.is_selesai OR s.status = 9 THEN 'Selesai'
                            WHEN s.status = 0 THEN 'Menunggu Verifikasi'
                            WHEN s.status = 10 THEN 'Pengajuan Ulang'
                            WHEN s.status = 1 THEN 'Diterima'
                            WHEN s.status = 2 THEN 'Ditolak'
                            WHEN s.status = 3 THEN 'Menunggu Konfirmasi Pembatalan'
                            WHEN s.status = 4 THEN 'Dibatalkan'
                            WHEN s.status = 5 THEN 'Menunggu Konfirmasi Pencabutan'
                            WHEN s.status = 6 THEN 'Dicabut'
                            WHEN s.status IN (7, 8) THEN jsp.nama
                        END AS status"),
                DB::raw('CASE WHEN s.is_selesai THEN s.updated_at::date ELSE NOW()::date END - MIN(CASE WHEN sidang_waktu IS NOT NULL THEN sidang_waktu::date END) AS durasi')
            )
            ->whereNull('s.deleted_at')
            ->whereBetween(DB::raw('DATE(s.created_at)'), [$tanggal1, $tanggal2])
            ->groupBy(
                's.id',
                's.no_sengketa',
                'p.nama',
                'p.alamat',
                'p.email',
                'p.no_hp',
                't.nama',
                't.alamat',
                't.email',
                't.no_hp',
                's.tanggal_permohonan',
                's.tanggal_keberatan',
                's.tanggal_jawaban',
                'ui1.nama',
                'ui2.nama',
                'ui3.nama',
                'ui4.nama',
                'ui5.nama',
                'ui6.nama',
                'kc.nama',
                'jsp.nama'
            );

        if (isset($request['status'])) {
            if ($request['status'] == Constant::STATUS_SENGKETA_SELESAI) {
                $data1->where('s.is_selesai', true);
            } else {
                $data1->where('s.status', $request['status']);
                $data1->where('s.is_selesai', false);
            }
        }

        if ($id_ki) {
            $data1->where('kc.id', $id_ki);
        }

        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            $data1->where('s.id_pemohon', Auth::user()->pemohon->id);
        }

        $data1 = $data1->get()->toArray();
        $data1 = array_map(function ($item, $index) {
            $item = (array) $item; // Convert stdClass to array
            array_unshift($item, $index + 1); // Add row number

            // Process alasan_permohonan
            $alasanPermohonan = json_decode($item['alasan_permohonan'], true);
            $alasanPermohonan = array_filter($alasanPermohonan); // Remove null values

            // Format as list with bullet points
            $item['alasan_permohonan'] = implode("\n- ", $alasanPermohonan);
            if (! empty($item['alasan_permohonan'])) {
                $item['alasan_permohonan'] = '- '.$item['alasan_permohonan']; // Add initial bullet point
            }

            $item['termohon_alamat'] = $item['termohon_alamat'] ?? '-';
            $item['termohon_email'] = $item['termohon_email'] ?? '-';
            $item['termohon_hp'] = $item['termohon_hp'] ? "'".$item['termohon_hp'] : '-';
            $item['tanggal_jawaban'] = $item['tanggal_jawaban'] ?? '-';
            $item['tanggal_tanggapan'] = $item['tanggal_tanggapan'] ?? '-';
            $item['durasi'] = $item['durasi'].' hari';
            $item['pemohon_hp'] = "'".$item['pemohon_hp'];

            return $item;
        }, $data1, array_keys($data1));

        $data2 = DB::table('sengketa_history as sh')
            ->join('sengketa as s', function ($join) {
                $join->on('sh.id_sengketa', '=', 's.id')
                    ->whereNull('s.deleted_at');
            })
            ->join('pemohon as p', 's.id_pemohon', '=', 'p.id')
            ->join('termohon as t', 's.id_termohon', '=', 't.id')
            ->leftJoin('user_internal as ui1', 's.id_ketua', '=', 'ui1.id')
            ->leftJoin('user_internal as ui2', 's.id_anggota1', '=', 'ui2.id')
            ->leftJoin('user_internal as ui3', 's.id_anggota2', '=', 'ui3.id')
            ->leftJoin('user_internal as ui4', 's.id_mediator', '=', 'ui4.id')
            ->leftJoin('user_internal as ui5', 's.id_panitera_pengganti', '=', 'ui5.id')
            ->leftJoin('user_internal as ui6', 's.id_panitera_utama', '=', 'ui6.id')
            ->join('ki_config as kc', 's.id_ki', '=', 'kc.id')
            ->join('jenis_sidang_putusan as jsp', 'sh.id_jenis_sidang', '=', 'jsp.id')
            ->whereNull('sh.deleted_at')
            ->whereBetween(DB::raw('DATE(sidang_waktu)'), [$tanggal1, $tanggal2])
            ->orderBy('sh.created_at')
            ->select(
                'sh.sidang_waktu',
                'sh.sidang_agenda',
                'sh.sidang_alamat',
                's.no_sengketa',
                'sh.penomoran',
                'p.nama as pemohon_nama',
                't.nama as termohon_nama',
                'ui1.nama as nama_ketua',
                'ui2.nama as nama_anggota1',
                'ui3.nama as nama_anggota2',
                'ui4.nama as nama_mediator',
                'ui5.nama as nama_panitera_pengganti',
                'ui6.nama as nama_panitera_utama',
                'kc.nama as ki_nama',
                'jsp.nama'
            );

        if (isset($request['status'])) {
            if ($request['status'] == Constant::STATUS_SENGKETA_SELESAI) {
                $data2->where('s.is_selesai', true);
            } else {
                $data2->where('s.status', $request['status']);
                $data2->where('s.is_selesai', false);
            }
        }

        if ($id_ki) {
            $data2->where('kc.id', $id_ki);
        }

        if (getActiveRole(Roles::ROLE_PEMOHON)) {
            $data2->where('s.id_pemohon', Auth::user()->pemohon->id);
        }

        $data2 = $data2->get()->toArray();
        $data2 = array_map(function ($item, $index) {
            $item = (array) $item; // Convert stdClass to array
            array_unshift($item, $index + 1); // Add row number

            $sidangWaktu = Carbon::parse($item['sidang_waktu']);
            $item['sidang_waktu'] = $sidangWaktu->translatedFormat('l, j F Y \P\u\k\u\l H:i');

            return $item;
        }, $data2, array_keys($data2));

        $tanggal_string = Carbon::parse($tanggal1)->translatedFormat('l, j F Y \P\u\k\u\l H:i').' - '.Carbon::parse($tanggal2)->translatedFormat('l, j F Y \P\u\k\u\l H:i');
        $fileName = 'EXPORT_'.Str::uuid().'_'.time().'.xlsx';

        return Excel::download(new ExportSengketa($data1, $data2, $nama_ki, $tanggal_string), $fileName);
    }
}
