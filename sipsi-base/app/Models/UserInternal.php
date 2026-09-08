<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInternal extends Model
{
    use Blameable, HasFactory, SoftDeletes;

    protected $table = 'user_internal';

    protected $fillable = [
        'id_user',
        'nama',
        'alamat',
        'no_telp',
        'no_hp',
        'email',
        'jenis_identitas',
        'nomor_identitas',
        'jenis_kelamin',
        'id_ki',
        'created_by',
        'updated_by',
        'tanggal_lahir',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ki()
    {
        return $this->belongsTo(KiConfig::class, 'id_ki');
    }
}
