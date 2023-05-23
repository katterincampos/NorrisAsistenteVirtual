@extends('layouts.sitio')

@section('content')
<div>
    <section class="hero-section container"> <img src="{{ asset('img/OIP.jfif') }}" alt="Asistente virtual" class="img-mediano" />
        <div class="hero-text">
            <h1>Asistente virtual para personas con Enfermedad obstructiva crónica</h1>
            <p> Nuestro asistente virtual está diseñado para ayudar a las personas con Enfermedad obstructiva crónica a
                llevar una vida más cómoda y saludable. Nuestra plataforma fácil de usar proporciona información
                útil, consejos de cuidado y recordatorios personalizados para mantener a los usuarios informados y
                comprometidos con su bienestar. </p>
            <p> ¡Regístrate hoy y comienza a disfrutar de los beneficios de nuestro asistente virtual en tu vida diaria!
            </p>
        </div>
    </section>
</section>
<section class="feature-section">
<div class="container text-center">
    <div class="row justify-content-between">
        <div class="col-md-5 margen-section">
            <h3>Monitoreo de síntomas</h3>
            <p>Nuestro asistente virtual te ayuda a llevar un registro de tus síntomas y a detectar posibles
                complicaciones.</p>
        </div>
        <div class="col-md-5 margen-section">
            <h3>Recordatorios de medicación</h3>
            <p>Recibe recordatorios para tomar tus medicamentos a tiempo y asegurar un tratamiento efectivo.</p>
        </div>
    </div>
</div>
</section>
</div>
@endsection