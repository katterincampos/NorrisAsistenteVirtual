<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PatientProfileController extends Controller
{
    public function show()
    {
        $patient = auth()->user();
        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $patientId = $request->input('id');
        $patient = User::find($patientId);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado.'
            ]);
        }

        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->fecha_nacimiento = $request->fecha_nacimiento;
        $patient->genero = $request->genero;
        $patient->telefono = $request->telefono;
        $patient->direccion = $request->direccion;
        $patient->ciudad = $request->ciudad;
        $patient->pais = $request->pais;

        // Manejo de la subida de la imagen
        if ($request->hasFile('imagen_perfil')) {
            $path = $request->file('imagen_perfil')->store('profile_images', 'public');
            $patient->imagen_perfil = Storage::url($path);
        }

        $patient->save();

        return redirect()->route('patient.profile')->with('profile_updated', true);    }
}
