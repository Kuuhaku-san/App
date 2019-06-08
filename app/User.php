<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni', 'apellido_p', 'apellido_m', 'nombres', 'email', 'password', 'tipo', 'habilitado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    public function nombreCompleto()
    {
        return $this->apellido_p.' '.$this->apellido_m.' '.$this->nombres;
    }

    public function tipo()
    {
        if ($this->tipo == 'A') {
            return 'Administrador';
        }
        elseif ($this->tipo == 'T') {
            return 'Técnico';
        }
        else {
            return 'Secretaria';
        }
    }

    public function proformas()
    {
        return $this->hasMany(Proforma::class);
    }

    public function facturas()
    {
        return $this->hasMany(FacturaServicio::class, 'dni_u');
    }
}
