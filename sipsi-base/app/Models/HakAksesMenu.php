<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAksesMenu extends Model
{
    use HasFactory;

    protected $table = 'hak_akses_menu';

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
