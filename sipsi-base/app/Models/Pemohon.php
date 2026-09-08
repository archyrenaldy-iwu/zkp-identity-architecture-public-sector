<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemohon extends Model
{
    use Blameable, SoftDeletes;

    protected $table = 'pemohon';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_telp',
        'no_hp',
        'email',
        'jenis_identitas',
        'nomor_identitas',
        'jenis_pemohon',
        'agama',
        'pekerjaan',
        'kewarganegaraan',
        'tempat_lahir',
        'tanggal_lahir',
        'id_user',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
