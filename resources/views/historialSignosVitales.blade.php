@extends('layouts.appweb')

@section('content')
<div class="container">
    <p class="h2 mt-5">Historial de Signos Vitales</p>
    <form action="/historialSignosVitales" method="GET" class="d-flex align-items-end">
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
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Frecuencia Respiratorio</th>
                <th>Frecuencia Cardiaca</th>
                <th>Presion Arterial</th>
            </tr>
        </thead>
        <tbody>
            @foreach($signosVitales as $signoVital)
                <tr>
                    <td>{{ $signoVital->created_at }}</td>
                    <td>{{ $signoVital->frecuencia_respiratoria }}</td>
                    <td>{{ $signoVital->frecuencia_cardiaca }}</td>
                    <td>{{ $signoVital->frecuencia_arterial }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $signosVitales->links() }}
</div>
@endsection
