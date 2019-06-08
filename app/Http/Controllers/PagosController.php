<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaCompra;
use App\FacturaServicio;
use Carbon\Carbon;

class PagosController extends Controller
{
    public function index()
    {
        $años = FacturaServicio::selectRaw('year(fecha) a')
                                ->groupBy('a')
                                ->orderBy('a','desc')
                                ->get();

        $mes = request('mes') ? request('mes') : Carbon::now()->month;
        $año = request('año') ? request('año') : Carbon::now()->year;

        $monto_facturas = FacturaServicio::monto_total($año, $mes);
        $monto_compras = FacturaCompra::monto_total($año, $mes);

        $igv = 0.18 * ($monto_facturas - $monto_compras);
        $ir = 0.015 * $monto_facturas;

        return view('pagos.index', compact('igv', 'ir', 'mes', 'año', 'años'));
    }
}
