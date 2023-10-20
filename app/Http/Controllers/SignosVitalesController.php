<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SignosVitales;

class SignosVitalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'frecuencia_respiratoria' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|numeric',
            'frecuencia_arterial' => 'required|numeric',
        ]);

        $signosVitales = new SignosVitales;
        $signosVitales->user_id = $request->user()->id;
        $signosVitales->frecuencia_respiratoria = $request->input('frecuencia_respiratoria');
        $signosVitales->frecuencia_cardiaca = $request->input('frecuencia_cardiaca');
        $signosVitales->frecuencia_arterial = $request->input('frecuencia_arterial');
        $signosVitales->save();

        return back()->with('success', 'Los signos vitales se han registrado correctamente.');
    }
    public function showSignosHistorial(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        if ($from_date && $to_date) {
            $signos = SignosVitales::where('id_usuario', auth()->user()->id)
                ->whereBetween('created_at', [$from_date, $to_date])
                ->paginate(10);
        } else {
            $signos = SignosVitales::where('id_usuario', auth()->user()->id)
                ->paginate(10);
        }

        return view('historialSignos', ['signos' => $signos]);
    }
}
