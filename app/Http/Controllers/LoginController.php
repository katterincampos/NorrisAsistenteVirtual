<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->getCredentials();
    
        // Si la autenticación tiene éxito, redirigir al usuario.
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
    
        // Si la autenticación falla, redirigir al usuario de vuelta al formulario de login.
        return redirect()->back()->withErrors('auth.failed');
    }

}
