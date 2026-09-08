<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlameableObserver
{
    public function creating(Model $model)
    {
        $model->created_by = Auth::check() ? Auth::user()->id : 1;
        $model->updated_by = Auth::check() ? Auth::user()->id : 1;
    }

    public function updating(Model $model)
    {
        $model->updated_by = Auth::check() ? Auth::user()->id : 1;
    }
}
