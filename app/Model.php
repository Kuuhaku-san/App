<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $guarded = [];

    public function scopeActivo($query)
    {
        $query->where('eliminado', 0);
    }

    public function scopeHabilitado($query)
    {
        $query->where('habilitado', 1);
    }
}
