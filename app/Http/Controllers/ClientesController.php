<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clientes = Cliente::orderBy('ruc')
                            ->get();

        return view('clientes.index', compact('clientes', 'filtro', 'habilitado'));
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'ruc' => 'required|max:11',
            'razon_social' => 'required',
        ]);

        Cliente::create(request(['ruc', 'razon_social', 'direccion']));

        return redirect('clientes');
    }

    public function update(Cliente $cliente)
    {
        $this->validate(request(), [
            'razon_social' => 'required',
        ]);

        $cliente->fill(request(['razon_social', 'direccion']));
        $cliente->save();

        return redirect('clientes');
    }

    public function deshabilitar(Cliente $cliente)
    {
        $cliente->habilitado = false;
        $cliente->save();

        return redirect()->back();
    }

    public function habilitar(Cliente $cliente)
    {
        $cliente->habilitado = true;
        $cliente->save();

        return redirect()->back();
    }

    public function buscar(Cliente $cliente)
    {
        return view('clientes.buscar', compact('cliente'));
    }
}
