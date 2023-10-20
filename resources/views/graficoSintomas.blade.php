@extends('layouts.appasociados')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Gráficos de Síntomas</h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <!-- Botones para seleccionar el tipo de gráfico -->
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('dificultad_respirar')">Dificultad para Respirar</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('tos')">Tos</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('nivel_fatiga')">Nivel de Fatiga</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('actividad_inicio_sintomas')">Actividad Inicio Síntomas</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('medicina_rescate_usada')">Medicina de Rescate Usada</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('nivel_dolor_cabeza')">Nivel de Dolor de Cabeza</button>
            <button class="btn btn-primary" onclick="cargarGrafico('temperatura_mas_alta')">Temperatura Más Alta</button>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <p id="mensaje" class="text-danger"></p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <label>Desde:</label>
            <input type="date" id="fechaDesde" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Hasta:</label>
            <input type="date" id="fechaHasta" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-secondary" onclick="filtrarPorFecha()">Filtrar</button>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Canvas para el gráfico -->
            <canvas id="sintomasChart"></canvas>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <!-- Botones para exportar -->
            <button class="btn btn-success" id="exportPDF">Exportar como PDF</button>
            <button class="btn btn-success mr-2" id="exportImage">Exportar como Imagen</button>

        </div>
    </div>
</div>

<!-- Incluye Chart.js, Axios y jsPDF -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    const id_usuario = localStorage.getItem('patientId');

    const ctx = document.getElementById('sintomasChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function cargarGrafico(sintoma) {
        axios.get('/api/grafico/' + id_usuario + '/' + sintoma)
        .then(response => {
            if (response.data.error) {
                document.getElementById('mensaje').innerText = response.data.error;
                return;
            }
            myChart.data.labels = response.data.fechas;
            myChart.data.datasets[0].data = response.data.valores;
            myChart.data.datasets[0].label = formatLabel(sintoma);
            myChart.update();
        });
    }

    function formatLabel(label) {
        return label.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    }

    function filtrarPorFecha() {
        let fechaDesde = document.getElementById('fechaDesde').value;
        let fechaHasta = document.getElementById('fechaHasta').value;
        cargarGrafico(document.querySelector('input[name="sintoma"]:checked').value);
    }

    document.getElementById("exportImage").addEventListener("click", function() {
        let canvas = document.getElementById("sintomasChart");
        let img = canvas.toDataURL("image/png");
        let link = document.createElement('a');
        link.href = img;
        link.download = 'graficoSintomas.png';
        link.click();
    });

    document.getElementById("exportPDF").addEventListener("click", function() {
        let canvas = document.getElementById("sintomasChart");
        let imgData = canvas.toDataURL("image/png");
        
        let pdf = new window.jspdf.jsPDF();
        pdf.addImage(imgData, 'PNG', 10, 10);
        pdf.save("graficoSintomas.pdf");
    });
</script>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
