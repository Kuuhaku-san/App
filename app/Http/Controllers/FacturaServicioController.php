<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaServicio;
use App\Servicio;
use Carbon\Carbon;

class FacturaServicioController extends Controller
{
    public function index()
    {
        $inicio = (request('inicio') ? request('inicio') : Carbon::now()->toDateString());
        $fin = (request('fin') ? request('fin') : Carbon::now()->toDateString());
        $id = request('id');
        $anulado = request('anulado');
        // dd($inicio);
        $facturas = FacturaServicio::orderBy('fecha', 'desc')
                                    ->filtrar(compact('inicio', 'fin', 'id', 'anulado'))
                                    ->get();

        return view('facturas.index', compact('facturas','inicio', 'fin', 'id', 'anulado'));
    }

    public function show(FacturaServicio $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    public function create(Servicio $servicio)
    {
        return view('facturas.create', compact('servicio'));
    }

    public function store(Servicio $servicio)
    {
        $this->validate(request(), [
            'fecha' => 'required'
        ]);

        $servicio->factura_servicio()->create([
            'fecha' => request('fecha'),
            'dni_u' => auth()->user()->dni
        ]);

        return redirect('/facturas');
    }

    public function update(FacturaServicio $factura)
    {
        $this->validate(request(), [
            'fecha' => 'required'
        ]);

        $factura->fill([
            'fecha' => request('fecha')
        ]);
        $factura->save();

        return redirect('/facturas');
    }

    public function anular(FacturaServicio $factura)
    {
        $factura->anular();
        $factura->save();

        return redirect()->back();
    }

    public function destroy(FacturaServicio $factura)
    {
        $factura->eliminado = true;
        $factura->save();

        return redirect()->back();
    }
}
