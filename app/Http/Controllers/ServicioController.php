<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proforma;
use App\Servicio;
use Carbon\Carbon;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $inicio = (request('inicio') ? request('inicio') : Carbon::now()->toDateString());
        $fin = (request('fin') ? request('fin') : Carbon::now()->toDateString());
        $id = request('id');
        $estado = request('estado') ? request('estado') : 'A';

        $servicios = Servicio::orderBy('fecha', 'desc')
                    ->activo()
                    ->filtrar(compact('id', 'inicio', 'fin', 'estado'))
                    ->get();

        return view('servicios.index', compact('servicios', 'inicio', 'fin', 'estado'));
    }

    public function show(Servicio $servicio)
    {
        return view('servicios.show', compact('servicio'));
    }

    public function create(Proforma $proforma)
    {
        return view('servicios.create', compact('proforma'));
    }

    public function store(Proforma $proforma)
    {
        $this->validate(request(), [
            'fecha' => 'required|date'
        ]);

        $proforma->servicio()->create([
            'estado' => request('estado'),
            'fecha' => request('fecha')
        ]);

        return redirect('/servicios');
    }

    public function update(Servicio $servicio)
    {
        $this->validate(request(), [
            'fecha' => 'required|date'
        ]);

        $servicio->fill([
            'estado' => request('estado'),
            'fecha' => request('fecha')
        ]);
        $servicio->save();

        return redirect('/servicios');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->eliminado = true;
        $servicio->save();

        return redirect()->back();
    }
}
