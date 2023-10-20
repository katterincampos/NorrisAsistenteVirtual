<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SignosVitales;

class GraficosSignosVitalesController extends Controller
{
    public function mostrarGrafico($id_usuario, $signo)
    {
        $datos = SignosVitales::where('user_id', $id_usuario)
                                 ->orderBy('created_at');

        $fechas = [];
        $valores = [];

        $resultados = $datos->get();

        if ($resultados->isEmpty()) {
            return response()->json(['error' => 'El paciente aún no ha ingresado sus signos vitales.']);
        }

        foreach ($resultados as $dato) {
            $fechas[] = $dato->created_at->format('Y-m-d');
            $valores[] = $dato->$signo;
        }

        return response()->json(['fechas' => $fechas, 'valores' => $valores]);
    }
}
