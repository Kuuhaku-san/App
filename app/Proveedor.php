<?php

namespace App;

class Proveedor extends Model
{
    protected $primaryKey = 'ruc';
    protected $keyType = 'string';
    protected $table = 'proveedores';

    public $incrementing = false;

}
