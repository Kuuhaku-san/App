<?php

namespace App;


class Cliente extends Model
{
    protected $primaryKey = 'ruc';
    protected $keyType = 'string';
    public $incrementing = false;

    public function scopeFiltrar($query, $filtros)
    {
        if ($filtros['filtro']) {
            $filtro = $filtros['filtro'];
            $query->whereRaw("ruc like '%$filtro%' or razon_social like '%$filtro%'");
        }
        $habilitado = $filtros['habilitado'];
        if ($habilitado != 2) {
            $query->where('habilitado', $habilitado);
        }
    }

    public function proformas()
    {
        return $this->hasMany(Proforma::class);
    }
}
