<?php

namespace App;

class FacturaServicio extends Model
{
    public static function monto_total($año, $mes)
    {
        $monto = 0;

        $facturas = self::whereRaw("year(fecha)='$año' and month(fecha)='$mes' and not anulado")->get();

        foreach ($facturas as $factura) {
            $monto += $factura->total();
        }

        return $monto;
    }

    public function total()
    {
        return $this->servicio->monto();
    }

    public function scopeFiltrar($query, $filtros)
    {
        if ($id = $filtros['id']) {
            $query->whereRaw("id like '%$id%'");
        }
        else {
            $query->whereBetween('fecha', [$filtros['inicio'], $filtros['fin']]);
            if ($anulado = $filtros['anulado'] and $anulado != 2) {
                $query->where('anulado', $anulado);
            }
        }
    }

    public function cliente()
    {
        return $this->servicio->proforma->cliente();
    }

    public function anular()
    {
        $this->anulado = true;
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dni_u', 'dni');
    }
}
