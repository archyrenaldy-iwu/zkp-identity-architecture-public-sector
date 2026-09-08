<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penomoran extends Model
{
    use HasFactory;

    protected $table = 'penomoran';

    protected $fillable = [
        'jenis',
        'id_ki',
        'tahun',
        'nomor',
        'hasil',
    ];
}
