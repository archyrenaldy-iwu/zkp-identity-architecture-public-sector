<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SengketaHistory extends Model
{
    use Blameable, HasFactory, SoftDeletes;

    protected $table = 'sengketa_history';

    protected $fillable = [
        'id_sengketa',
        'id_user_internal',
        'is_selesai',
        'status',
        'penolakan_info',
        'penolakan_checklist',
        'id_jenis_sidang',
        'sidang_agenda',
        'sidang_waktu',
        'id_ruangan',
        'sidang_alamat',
        'id_jenis_putusan',
        'putusan_link_jdih',
        'file1',
        'file2',
        'file3',
        'created_by',
        'updated_by',
        'is_current',
        'reelas_sudah_kirim',
        'reelas_waktu_kirim',
        'penomoran',
        'alasan_dihapus',
    ];

    protected $casts = [
        'penolakan_checklist' => 'array',
    ];

    public function sengketa()
    {
        return $this->belongsTo(Sengketa::class, 'id_sengketa');
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
