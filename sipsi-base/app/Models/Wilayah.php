<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $primaryKey = 'id_wilayah';

    public $timestamps = false;

    public function parentWilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_parent_wilayah', 'id_wilayah');
    }
}
