<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pieza;

class PiezasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar($nombre)
    {
        $piezas = Pieza::whereRaw("nombre like '%$nombre%'")
                        ->orderBy('nombre')
                        ->get()->toArray();

        return view('piezas.buscar', compact('piezas'));
    }
}
