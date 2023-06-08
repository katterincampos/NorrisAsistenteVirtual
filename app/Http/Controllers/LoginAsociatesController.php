<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginAsociatesRequest;
use Illuminate\Support\Facades\Auth;

class LoginAsociatesController extends Controller
{
    public function show(){
        // Aquí debes usar el nuevo guard que definimos en auth.php
        if(Auth::guard('web_asociates')->check()){
            return redirect('home');
        }
        return view('auth.loginAsociados');
    }

    public function login(LoginAsociatesRequest $request){
        $credentials = $request->getCredentials();
    
        // Si la autenticación tiene éxito, redirigir al usuario.
        // Aquí también debes usar el nuevo guard
        if (Auth::guard('web_asociates')->attempt($credentials)) {
            return redirect()->intended('users');
        }
    
        // Si la autenticación falla, redirigir al usuario de vuelta al formulario de login con el error real.
        return redirect()->back()->withInput($request->only('username'))->withErrors([
            'login_error' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }

}
