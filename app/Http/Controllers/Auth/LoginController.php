<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('users.login');
    }

    public function store()
    {
        $this->validate(request(), [
            'dni' => 'required',
            'password' => 'required'
        ]);

        if (! auth()->attempt(request(['dni', 'password'])) ) {
            return back()->withErrors([
                'message' => 'DNI o contraseña incorrecta.'
            ]);
        }

        return redirect()->home();
    }

    public function logout()
    {
        auth()->logout();

        return redirect('login');
    }

}
