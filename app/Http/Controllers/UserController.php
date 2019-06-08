<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarios = User::all();

        return view('users.index', compact('usuarios'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'dni' => 'required|max:8',
            'email' => 'required',
            'password' => 'required|confirmed',
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'tipo' => 'required'
        ]);

        $user = User::create([
            'dni' => request('dni'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'apellido_p' => request('apellido_p'),
            'apellido_m' => request('apellido_m'),
            'nombres' => request('nombres'),
            'tipo' => request('tipo')
        ]);

        return redirect('/users');
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'email' => 'required',
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'tipo' => 'required'
        ]);

        $user->fill([
            'email' => request('email'),
            'apellido_p' => request('apellido_p'),
            'apellido_m' => request('apellido_m'),
            'nombres' => request('nombres'),
            'tipo' => request('tipo')
        ]);
        $user->save();

        return redirect('/users');
    }

    public function editar()
    {
        return view('users.ajustes');
    }

    public function deshabilitar(User $user)
    {
        $user->habilitado = false;
        $user->save();

        return redirect()->back();
    }

    public function habilitar(User $user)
    {
        $user->habilitado = true;
        $user->save();

        return redirect()->back();
    }

    public function guardarAjustes()
    {
        $user = auth()->user();

        $this->validate(request(), [
            'email' => 'required|email',
        ]);

        if (request('password') && request('password') == $user->password) {
            $user->password = bcrypt(request('new_password'));

        }
        $user->email = request('email');
        $user->save();

        return redirect('/');
    }
}
