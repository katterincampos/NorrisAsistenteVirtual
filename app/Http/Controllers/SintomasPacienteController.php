<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SintomasPaciente;
use App\Http\Requests\StoreSymptomRequest;
use Illuminate\Support\Facades\Http; // Para hacer solicitudes HTTP a la API de OpenAI

class SintomasPacienteController extends Controller
{
    public function store(Request $request)
    {
        $sintomasPaciente = new SintomasPaciente;
    
        $sintomasPaciente->id_usuario = $request->user()->id; // Asegúrate de que el ID del usuario se guarda en la sesión cuando el usuario inicia sesión
        $sintomasPaciente->dificultad_respirar = $request->input('dificultad_respirar');
        $sintomasPaciente->tos = $request->input('tos');
        $sintomasPaciente->nivel_fatiga = $request->input('nivel_fatiga');
        $sintomasPaciente->actividad_inicio_sintomas = $request->input('actividad_inicio_sintomas');
        $sintomasPaciente->medicina_rescate_usada = $request->input('medicina_rescate_usada');
        $sintomasPaciente->nivel_dolor_cabeza = $request->input('nivel_dolor_cabeza');
        $sintomasPaciente->temperatura_mas_alta = $request->input('temperatura_mas_alta');
        $sintomasPaciente->informacion_adicional = $request->input('informacion_adicional');
    
        $sintomasPaciente->save();
    
        return view('homeNorris');
    }

    public function showSintomasHistorial(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
    
        $query = SintomasPaciente::query();
    
        if ($from_date) {
            $query->where('created_at', '>=', $from_date);
        }
    
        if ($to_date) {
            $query->where('created_at', '<=', $to_date);
        }
    
        $sintomas = $query->where('id_usuario', auth()->user()->id)->paginate(10);
    
        return view('historialSintomas', ['sintomas' => $sintomas]);
    }
    
    public function getSymptomsHistory(Request $request)
    {
        $userId = $request->user()->id;
        $symptomsHistory = SintomasPaciente::where('id_usuario', $userId)->get();
        return response()->json($symptomsHistory);
    }
    
    public function analyzeAndInterpretSymptoms(Request $request)
    {
        $symptoms = $request->input('symptoms');
        $responseFromOpenAI = $this->integrateWithOpenAI($symptoms);
        return response()->json($responseFromOpenAI);
    }

        
    }
    
    
