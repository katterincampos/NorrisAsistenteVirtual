<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginAsociatesRequest;
use Illuminate\Support\Facades\Auth;

class LoginAsociatesController extends Controller
{
    public function show(){
        if(Auth::check()){
            return redirect('home');
        }
        return view('auth.loginAsociados');
    }

    public function login(LoginAsociatesRequest $request){
        $credentials = $request->getCredentials();
    
        // Si la autenticación tiene éxito, redirigir al usuario.
        if (Auth::attempt($credentials)) {
            return redirect()->intended('users');
        }
    
        // Si la autenticación falla, redirigir al usuario de vuelta al formulario de login.
        return redirect()->back()->withErrors('auth.failed');
    }

}
