<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAksesFitur extends Model
{
    use HasFactory;

    protected $table = 'hak_akses_fitur';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'permission',
        'description',
        'super_admin',
        'pemohon',
        'admin_berkas',
        'sekertaris',
        'panitera',
        'majelis_komisioner',
    ];
}
