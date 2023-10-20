<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SintomasPaciente;

class GraficosSintomasController extends Controller
{
    public function mostrarGrafico($id_usuario, $sintoma)
    {
        $datos = SintomasPaciente::where('id_usuario', $id_usuario)
                                 ->orderBy('created_at');

        if ($datos->count() == 0) {
            return response()->json(['error' => 'No hay registros de síntomas para este paciente.']);
        }

        if ($sintoma == 'actividad_inicio_sintomas' || $sintoma == 'medicina_rescate_usada') {
            $opciones = $datos->select($sintoma, \DB::raw('count(*) as total'))
                              ->groupBy($sintoma)
                              ->get();

            $nombresOpciones = [];
            $conteos = [];

            foreach ($opciones as $opcion) {
                $nombresOpciones[] = $opcion->$sintoma;
                $conteos[] = $opcion->total;
            }

            return response()->json(['fechas' => $nombresOpciones, 'valores' => $conteos]);
        } else {
            $fechas = [];
            $valores = [];

            $resultados = $datos->get();

            foreach ($resultados as $dato) {
                $fechas[] = $dato->created_at->format('Y-m-d');
                $valores[] = $dato->$sintoma;
            }

            return response()->json(['fechas' => $fechas, 'valores' => $valores]);
        }
    }
}
