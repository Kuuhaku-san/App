<?php

namespace App;


class FacturaCompra extends Model
{
    public static function monto_total($año, $mes)
    {
        $monto = 0;

        $compras = self::whereRaw("year(fecha)='$año' and month(fecha)='$mes' and not eliminado")->get();

        foreach ($compras as $compra) {
            $monto += $compra->total();
        }

        return $monto;
    }

    public function scopeFiltrar($query, $filtros)
    {
        if ($id = $filtros['id']) {
            $query->whereRaw("id like '%$id%'");
        }
        else {
            $query->whereBetween('fecha', [$filtros['inicio'], $filtros['fin']]);
        }
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ruc_p', 'ruc');
    }

    public function total()
    {
        return $this->servicio->proforma->monto_piezas();
    }
}
