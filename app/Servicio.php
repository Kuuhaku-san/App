<?php

namespace App;

class Servicio extends Model
{
    public function estado()
    {
        if ($this->estado == 'P') {
            return 'Pendiente';
        } elseif ($this->estado == 'O') {
            return 'Observado';
        } else {
            return 'Terminado';
        }
    }

    public function scopeFiltrar($query, $filtros)
    {
        if ($id = $filtros['id']) {
            $query->whereRaw("id like '%$id%'");
        }
        else {
            $query->whereBetween('fecha', [$filtros['inicio'], $filtros['fin']]);
            if ($estado = $filtros['estado'] and $estado !== 'A') {
                $query->where('estado', $estado);
            }
        }
    }

    public function cliente()
    {
        return $this->proforma->cliente();
    }

    public function terminado()
    {
        return $this->estado == 'T';
    }

    public function monto()
    {
        return $this->proforma->monto_total();
    }

    public function factura()
    {
        return $this->factura_servicio()
                    ->where('anulado', 0)
                    ->first();
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class, 'codigo_p', 'codigo');
    }

    public function factura_servicio()
    {
        return $this->hasMany(FacturaServicio::class);
    }

    public function factura_compra()
    {
        return $this->hasOne(FacturaCompra::class);
    }
}
