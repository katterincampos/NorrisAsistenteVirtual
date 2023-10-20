<?php

namespace App\Http\Controllers;

use App\Models\UserAsociates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicoController extends Controller
{
    public function showProfile()
    {
        $doctor = UserAsociates::find(auth()->guard('web_asociates')->user()->id);
        return view('perfil', ['doctor' => $doctor]);
    }

    public function updateDoctor(Request $request)
    {
        $doctorId = $request->input('id');
        $doctor = UserAsociates::find($doctorId);

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor no encontrado.'
            ]);
        }

        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->username = $request->username;
        $doctor->address = $request->address;
        $doctor->city = $request->city;
        $doctor->zip_code = $request->zip_code;

        // Manejo de la subida de la imagen
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $doctor->profile_image_url = Storage::url($path);
        }

        $doctor->save();

        return redirect()->route('profile')->with('profile_updated', true);    
    }

    // ... (otros métodos del controlador) ...
}
