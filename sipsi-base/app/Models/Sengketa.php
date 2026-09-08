<?php

namespace App\Models;

use App\Blameable;
use Constant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sengketa extends Model
{
    use Blameable, HasFactory, SoftDeletes;

    protected $table = 'sengketa';

    protected $fillable = [
        'id_ki',
        'id_pemohon',
        'id_termohon',
        'kuasa_pemohon_nama',
        'kuasa_pemohon_jk',
        'kuasa_pemohon_alamat',
        'tanggal_permohonan',
        'tanggal_keberatan',
        'tanggal_jawaban',
        'tanggal_tanggapan',
        'file_identitas',
        'file_formulir_keberatan',
        'file_formulir_permohonan',
        'file_surat_kuasa',
        'file_pemberitahuan_tertulis',
        'file_jawaban_ppid',
        'file_tanggapan_atasan_ppid',
        'file_pendukung1',
        'file_pendukung2',
        'is_selesai',
        'created_by',
        'updated_by',
        'no_registrasi',
        'no_sengketa',
        'status',
        'no_registrasi_online',
        'id_sidang_putusan',
        'alasan_permohonan',
        'alasan_dihapus',
        'is_lengkap_perangkat',
        'id_ketua',
        'id_anggota1',
        'id_anggota2',
        'id_mediator',
        'id_panitera_pengganti',
        'id_panitera_utama',
    ];

    protected $casts = [
        'alasan_permohonan' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function kiConfig()
    {
        return $this->belongsTo(KiConfig::class, 'id_ki');
    }

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon');
    }

    public function termohon()
    {
        return $this->belongsTo(Termohon::class, 'id_termohon');
    }

    public function history()
    {
        return $this->hasMany(SengketaHistory::class, 'id_sengketa');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('sengketa.deleted_at');
    }

    public function scopeWithCustomStatus($query)
    {
        $sqlCase = "CASE
                        WHEN sengketa.deleted_at IS NOT NULL THEN '".Constant::STATUS_SENGKETA_DIHAPUS_TEXT."'
                        WHEN sengketa.is_selesai THEN '".Constant::STATUS_SENGKETA_SELESAI_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI." THEN '".Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_PENGAJUAN_ULANG." THEN '".Constant::STATUS_SENGKETA_PENGAJUAN_ULANG_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_TERVERIFIKASI." THEN '".Constant::STATUS_SENGKETA_TERVERIFIKASI_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_DITOLAK." THEN '".Constant::STATUS_SENGKETA_DITOLAK_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN." THEN '".Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_DIBATALKAN." THEN '".Constant::STATUS_SENGKETA_DIBATALKAN_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN." THEN '".Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT."'
                        WHEN status = ".Constant::STATUS_SENGKETA_DICABUT." THEN '".Constant::STATUS_SENGKETA_DICABUT_TEXT."'
                        WHEN (status = ".Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG.' OR status = '.Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN.') THEN jenis_sidang_putusan.nama 
                    END AS status';

        return $query->addSelect(DB::raw($sqlCase))
            ->leftJoin('jenis_sidang_putusan', 'sengketa.id_sidang_putusan', '=', 'jenis_sidang_putusan.id');
    }

    public function scopeWithAction($query)
    {
        $status_enable_cabut = [
            Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG,
            Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN,
        ];
        $status_enable_cabut = implode(', ', $status_enable_cabut);

        $status_enable_batal = [
            Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
            Constant::STATUS_SENGKETA_PENGAJUAN_ULANG,
            Constant::STATUS_SENGKETA_TERVERIFIKASI,
            Constant::STATUS_SENGKETA_DITOLAK,
        ];
        $status_enable_batal = implode(', ', $status_enable_batal);

        $status_sengketa_baru = [
            Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI,
            Constant::STATUS_SENGKETA_PENGAJUAN_ULANG,
        ];
        $status_sengketa_baru = implode(', ', $status_sengketa_baru);

        $basic_condition = 'sengketa.deleted_at IS NULL AND sengketa.is_selesai <> true';

        $sqlAction =
            'CASE WHEN '.$basic_condition.' AND status IN ('.$status_sengketa_baru.') THEN TRUE ELSE FALSE END AS enable_lihat_pengajuan
            , CASE WHEN '.$basic_condition.' AND status IN ('.$status_sengketa_baru.') THEN TRUE ELSE FALSE END AS enable_verifikasi
            , CASE WHEN '.$basic_condition.' AND status IN ('.$status_sengketa_baru.') THEN TRUE ELSE FALSE END AS enable_tolak
            , CASE WHEN '.$basic_condition.' AND status = '.Constant::STATUS_SENGKETA_DITOLAK.' THEN TRUE ELSE FALSE END AS enable_lengkapi_data
            , CASE WHEN '.$basic_condition.' AND is_lengkap_perangkat IS NOT TRUE AND status = '.Constant::STATUS_SENGKETA_TERVERIFIKASI.' THEN TRUE ELSE FALSE END AS enable_lengkapi_perangkat
            , CASE WHEN '.$basic_condition.' AND status IN ( '.$status_enable_batal.') THEN TRUE ELSE FALSE END AS enable_pengajuan_batal
            , CASE WHEN '.$basic_condition.' AND status = '.Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN.' THEN TRUE ELSE FALSE END AS enable_konfirmasi_batal
            , CASE WHEN '.$basic_condition.' AND status IN ('.$status_enable_cabut.') THEN TRUE ELSE FALSE END AS enable_pengajuan_cabut
            , CASE WHEN '.$basic_condition.' AND status = '.Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN.' THEN TRUE ELSE FALSE END AS enable_konfirmasi_cabut
            , TRUE AS enable_lacak';

        return $query->addSelect(DB::raw($sqlAction));
    }

    public function scopeWithPerangkat($query)
    {
        return $query->leftJoin('user_internal as ui1', 'sengketa.id_ketua', 'ui1.id')
            ->leftJoin('user_internal as ui2', 'sengketa.id_anggota1', 'ui2.id')
            ->leftJoin('user_internal as ui3', 'sengketa.id_anggota2', 'ui3.id')
            ->leftJoin('user_internal as ui4', 'sengketa.id_mediator', 'ui4.id')
            ->leftJoin('user_internal as ui5', 'sengketa.id_panitera_pengganti', 'ui5.id')
            ->leftJoin('user_internal as ui6', 'sengketa.id_panitera_utama', 'ui6.id')
            ->addSelect([
                'ui1.nama as nama_ketua',
                'ui2.nama as nama_anggota1',
                'ui3.nama as nama_anggota2',
                'ui4.nama as nama_mediator',
                'ui5.nama as nama_panitera_pengganti',
                'ui6.nama as nama_panitera_utama',
            ]);
    }
}
