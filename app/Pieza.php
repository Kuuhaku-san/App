<?php

namespace App;



class Pieza extends Model
{
    public function proformas()
    {
        return $this->belongsToMany(Proforma::class, 'detalle_proforma', 'id_p', 'codigo_p')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }
}
