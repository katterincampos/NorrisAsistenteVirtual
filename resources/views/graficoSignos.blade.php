@extends('layouts.appasociados')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Gráficos de Signos Vitales</h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <!-- Botones para seleccionar el tipo de gráfico -->
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('frecuencia_respiratoria')">Frecuencia Respiratoria</button>
            <button class="btn btn-primary mr-2" onclick="cargarGrafico('frecuencia_cardiaca')">Frecuencia Cardíaca</button>
            <button class="btn btn-primary" onclick="cargarGrafico('frecuencia_arterial')">Frecuencia Arterial</button>
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
            <canvas id="signosVitalesChart"></canvas>
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

    const ctx = document.getElementById('signosVitalesChart').getContext('2d');
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

    function cargarGrafico(signo) {
        axios.get('/api/graficoSignos/' + id_usuario + '/' + signo)
        .then(response => {
            if (response.data.error) {
                document.getElementById('mensaje').innerText = response.data.error;
                return;
            }
            myChart.data.labels = response.data.fechas;
            myChart.data.datasets[0].data = response.data.valores;
            myChart.data.datasets[0].label = formatLabel(signo);
            myChart.update();
        });
    }

    function formatLabel(label) {
        return label.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    }

    function filtrarPorFecha() {
        let fechaDesde = document.getElementById('fechaDesde').value;
        let fechaHasta = document.getElementById('fechaHasta').value;
        cargarGrafico(document.querySelector('input[name="signo"]:checked').value);
    }

    document.getElementById("exportImage").addEventListener("click", function() {
        let canvas = document.getElementById("signosVitalesChart");
        let img = canvas.toDataURL("image/png");
        let link = document.createElement('a');
        link.href = img;
        link.download = 'graficoSignos.png';
        link.click();
    });

    document.getElementById("exportPDF").addEventListener("click", function() {
        let canvas = document.getElementById("signosVitalesChart");
        let imgData = canvas.toDataURL("image/png");
        
        let pdf = new window.jspdf.jsPDF();
        pdf.addImage(imgData, 'PNG', 10, 10);
        pdf.save("graficoSignos.pdf");
    });
</script>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
