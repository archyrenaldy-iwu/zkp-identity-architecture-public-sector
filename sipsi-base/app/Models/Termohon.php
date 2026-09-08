<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;

class Termohon extends Model
{
    use Blameable;

    protected $table = 'termohon';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'no_hp',
        'email',
        'created_by',
        'updated_by',
    ];
}
