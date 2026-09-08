<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KiConfig extends Model
{
    use Blameable, SoftDeletes;

    protected $table = 'ki_config';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'email',
        'template_kode_surat_akta_registrasi',
        'template_kode_nomor_sengketa',
        'template_kode_surat_spkd',
        'template_kode_surat_reelas',
        'link_instagram',
        'link_twitter',
        'no_telp',
        'fax',
        'link_website',
        'link_facebook',
        'link_youtube',
        'id_wilayah',
        'created_by',
        'updated_by',
        'timezone',
    ];
}
