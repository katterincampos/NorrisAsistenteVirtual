<!-- historialSintomas.blade.php -->

@extends('layouts.appweb')

@section('content')
<div class="container">
    <p class="h2 mt-5">Historial de Síntomas</p>
    <form action="/historialSintomas" method="GET" class="d-flex align-items-end">
        <div class="row">
            <div class="col">
                <label for="from_date" class="form-label">Desde:</label>
                <input type="date" id="from_date" name="from_date" class="form-control">
            </div>
            <div class="col">
                <label for="to_date" class="form-label">Hasta:</label>
                <input type="date" id="to_date" name="to_date" class="form-control">
            </div>
            <div class="col">
                <input type="submit" value="Filtrar" class="btn btn-primary">
            </div>
        </div>
    </form>
    <table class="table mb-5 mt-3">
        <thead>
            <tr>
            <th>Fecha</th>

                <th>Dificultad para respirar</th>
                <th>Tos</th>
                <th>Nivel de fatiga</th>
                <th>Actividad al inicio de los síntomas</th>
                <th>Medicina de rescate usada</th>
                <th>Nivel de dolor de cabeza</th>
                <th>Temperatura más alta</th>
                <th>Información adicional</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sintomas as $sintoma)
                <tr>
                <td>{{ $sintoma->created_at }}</td>

                    <td>{{ $sintoma->dificultad_respirar }}</td>
                    <td>{{ $sintoma->tos }}</td>
                    <td>{{ $sintoma->nivel_fatiga }}</td>
                    <td>{{ $sintoma->actividad_inicio_sintomas }}</td>
                    <td>{{ $sintoma->medicina_rescate_usada }}</td>
                    <td>{{ $sintoma->nivel_dolor_cabeza }}</td>
                    <td>{{ $sintoma->temperatura_mas_alta }}</td>
                    <td>{{ $sintoma->informacion_adicional }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sintomas->links() }}
</div>
@endsection
