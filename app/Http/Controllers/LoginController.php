<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function show(){
        return view('auth.login');
    }
    public function username()
{
    return 'username';
}

    public function login(Request $request){
        $credentials = $request->only('username', 'password');
    
        if(Auth::attempt($credentials)){
            return redirect('home');
        }
        else {
            return back()->withErrors('auth.failed');
        }
    }
    

    
    
    
    

    
    

}
