<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSidangPutusan extends Model
{
    protected $table = 'jenis_sidang_putusan';

    protected $fillable = ['nama', 'jenis'];
}
