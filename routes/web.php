<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginAsociatesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SintomasPacienteController;
use App\Http\Controllers\SignosVitalesController;
use Illuminate\Http\Request;
use App\Http\Controllers\GraficosSintomasController;
use App\Http\Controllers\GraficosSignosVitalesController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PatientProfileController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\OpenAIController;

Route::get('/NorrisVA', [OpenAIController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Norris', function () {
    return view('welcome');
})->name('Norris');

Route::get('/register',[RegisterController::class ,'show'])->name('register');
Route::post('/register',[RegisterController::class ,'register']);

Route::get('/login',[LoginController::class ,'show'])->name('login');
Route::post('/login',[LoginController::class ,'login']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('homeNorris');
    })->name('home');
});

Route::get('/logout',[LogoutController::class ,'logout']);

Route::get('/logoutA',[LogoutController::class ,'logoutAsociados']);

Route::get('/app', function () {
    return view('layouts.appweb');
});

Route::get('/asociados', function () {
    return view('asociados');
})->name('asociados');

Route::get('/loginAsociados',[LoginAsociatesController::class ,'show'])->name('loginAsociados');
Route::post('/loginAsociados',[LoginAsociatesController::class ,'login']);

Route::get('/chat',function(){
    return view ('historialdechat');
});

Route::get('/chatD',function(){
    return view ('chat');
});

Route::get('/blog',function(){
    return view ('Blog');
})-> name('blog');

Route::get('/users', function () {
    return view('listadoPac');
});

Route::get('/pago', function () {
    return view('pago');
});

Route::prefix('paypal')->group(function () {
    Route::get('payment', [PaymentControsler::class, 'show'])->name('create.payment');
    Route::post('handle-payment', [PaymentController::class, 'handlePayment'])->name('make.payment');
    Route::get('cancel-payment', [PaymentController::class, 'paymentCancel'])->name('cancel.payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('success.payment');
});




Route::get('/chatp',function(){
    return view ('chatPacientes');
});

Route::get('/sintomas',function(){
    return view ('registroSintomas');
});

Route::post('/sintoma', [SintomasPacienteController::class,'store'])->name('sintPaciente');


Route::get(
    '/signos',function(){
        return view('registroSignos');
    }
);

Route::get(
    '/h',function(){
        return view('historialSintomas');
    }
);

Route::get(
    '/Gsintomas',function(){

    return view('graficoSintomas');
}
);

Route::get(
    '/Gsignos',function(){

    return view('graficoSignos');
}
);

Route::post('/signo', [SignosVitalesController::class,'store'])->name('singPaciente');

Route::get('/historialSintomas', [SintomasPacienteController::class, 'showSintomasHistorial'])->name('historialSintomas');

Route::get('/historialSignosVitales', [SignosVitalesController::class, 'showSignosVitalesHistorial']);


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Ruta para manejar la solicitud de restablecimiento de contraseña
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Ruta para manejar el restablecimiento de contraseña
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );
 
    return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.update');

// Ruta para mostrar el formulario de solicitud de restablecimiento de contraseña
Route::get('/forgot-password-asociates', function () {
    return view('auth.forgot-password-asociates');
})->middleware('guest')->name('password.request.asociates');

// Ruta para manejar la solicitud de restablecimiento de contraseña


// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('/reset-password-asociates/{token}', function ($token) {
    return view('auth.reset-password-asociates', ['token' => $token]);
})->middleware('guest')->name('password.reset.asociates');

// Ruta para manejar el restablecimiento de contraseña
Route::post('/reset-password-asociates', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::broker('asociates')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));
 
            $user->save();
        }
    );
 
    return $status == Password::PASSWORD_RESET
                ? redirect()->route('loginAsociados')->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.update.asociates');

Route::get('/doctorProfile', [MedicoController::class, 'showProfile'])->name('profile');
Route::post('/updateDoctor', [MedicoController::class, 'updateDoctor'])->name('profile.update');
Route::post('/uploadProfileImage', [MedicoController::class, 'uploadProfileImage']);

// Rutas para el perfil de pacientes
Route::get('/patient/profile', [PatientProfileController::class, 'show'])->name('patient.profile');
Route::post('/patient/profile/update', [PatientProfileController::class, 'updateProfile'])->name('patient.profile.update');
Route::post('/openai/chat', [OpenAIController::class, 'chat']);