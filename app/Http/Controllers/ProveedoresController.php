<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\ConsultaRUC;

class ProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proveedores = Proveedor::all();

        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    public function consultar(Proveedor $proveedor)
    {
        $res = ConsultaRUC::consultar($proveedor->ruc);

        return view('proveedores.consultar', compact('res'));
    }

    public function store()
    {
        $this->validate(request(),[
            'ruc' => 'required',
            'razon_social' => 'required'
        ]);

        Proveedor::create(request([
            'ruc',
            'razon_social',
            'direccion',
            'telefono',
            'numero_cuenta',
            'rubro'
        ]));

        return redirect('/proveedores');
    }

    public function update(Proveedor $proveedor)
    {
        $this->validate(request(),[
            'razon_social' => 'required'
        ]);

        $proveedor->fill(request([
            'razon_social',
            'direccion',
            'telefono',
            'numero_cuenta',
            'rubro'
        ]));
        $proveedor->save();

        return redirect('/proveedores');
    }

    public function habilitar(Proveedor $proveedor)
    {
        $proveedor->habilitado = true;
        $proveedor->save();

        return redirect()->back();
    }

    public function deshabilitar(Proveedor $proveedor)
    {
        $proveedor->habilitado = false;
        $proveedor->save();

        return redirect()->back();
    }

    public function buscar(Proveedor $proveedor)
    {
        return view('proveedores.buscar', compact('proveedor'));
    }
}
