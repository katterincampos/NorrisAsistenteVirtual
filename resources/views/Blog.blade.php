@extends('layouts.sitio')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      
        .avion{
            width: 26px ;

        }
        #scrollToTopButton {
        display: none; /* Hide the button by default */
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99;
    }

    #scrollToTopButton.active {
        display: block; 
    }
    .circle-button {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: white(12, 88, 210, 0.916);
;        font-size: 18px;
        border: none;
        cursor: pointer;
        animation: salto 1s infinite;
    }
   
    @keyframes salto {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-15px);
        }
    }
    .circle-button.active {
        display: block;
    }
        .down{
            color: white ;
            width: 100%;
            height: 66px;
            padding: 23px;
            position: static;
        }


        .container {
            justify-content: center;
            align-items: flex-start;
            margin: 1px;
            padding: 1px;
        }

        .content {
            flex: 1;
            background-color: rgba(12, 88, 210, 0.916);
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .header {
            font-size: 18px;
            display: flex;
            align-items: center;
            color: white;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .header img {
            width: 45px;
            height: 30px;
            margin-right: 4px;
        }

       /* .Imagen {
            margin: 12px;
        }

        .Imagen img {
            background-color: white;
            padding: 1px;
            height: 23px;
        } 
*/

        .line {
            width: 100%;
            height: 1px;
            background-color: #ccc;
            margin-bottom: 10px;
        }

        .buttons {
            padding: 12px;
            margin-left: 1%;
        }

        .button {
            background-color: #f0f0f0;
            border-radius: 24px;
            padding: 2px;
            margin: 1px;
            color: black;
            font-size: 14px;
            text-align: center;
        }
      .button.btn:hover {
    background-color:rgb(192, 186, 186); 
    color: white; 
}

.boton {
    color: white;
    margin-left: 37%;
}

        html {
            scroll-behavior: smooth;
        }

        .alert {
            color: rgb(255, 255, 255);
            background-color: rgba(2, 17, 62, 0.91);
        }

        .card {
            background-color: rgba(2, 17, 62, 0.91);
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;

            text-align: center;
            position: relative;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        .card h3 {
            background-color: white;
            color: black;
            border-radius: 12px;
            font-size: 22px;
            margin: 12px;
            width: 450px;
        }
        
        .card h2{
            background-color: white;
            color: black;
            border-radius: 12px;
            font-size: 22px;
            margin: 18px;
            width: 200px;
        }

        .card h4{
            background-color: white;
            color: black;
            border-radius: 12px;
            font-size: 22px;
            margin: 18px;
            width: 660px;
        }
        .card h5{
            background-color: white;
            color: black;
            border-radius: 12px;
            font-size: 22px;
            margin: 18px;
            width: 340px;
        }
        .left-content,
        .right-content {
            width: calc(30% - 10px);
            padding: 10px;
        }

      /*  .right-content img {
            width: 36%;
        } */
      
    </style>
</head>

<body>
   

            <div class="row card " style="background-color:  rgba(12, 88, 210, 0.916);">
                <div class="col col-md-7">
                    <img src="{{ asset('img/undraw_medicine_b-1-ol (2).svg') }}" alt="Asistente virtual" class="img-fluid" />
                </div>
                <div class="col col-md-5 d-flex  flex-column align-items-start"> 
                    <a href="#Panel1" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">Consejos rutinarios</a>
                    <a href="#Panel2" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">Causas y Sintomas</a>
                    <a href="#Panel3" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">Recomendaciones </a>
                    <a href="#Panel4" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">Ejercicio y manejo de la EPOC</a>
                    <a class=" btn btn-secondary mb-2 btn-lg p-2 m-3" href="#Panel5">Enlaces externos</a>
                </div>
            </div>

    <div>
        <button onclick="scrollToTop()" class="circle-button" id="scrollToTopButton"><img class="avion" src="{{ asset('img/chevron-up.svg') }}" alt=""></button>
    </div>
    
    <br>
    <br>
    <div id="Panel1" class="row card ">
        <div class="col col-md-6">
            <h3 class="card-title">Consejos rutinarios para mejora de la EPOC</h3>
            <br>
            <br>
            <p style="text-align: left;">1.Deja de fumar: Si eres fumador, este es el paso más importante que puedes tomar 
            para ralentizar la progresión de la EPOC. 
            Consulta a tu médico para obtener ayuda y apoyo para dejar de fumar.
                <br>
                <br>
                2.Medicamentos y terapia: Sigue las instrucciones de tu médico 
                en cuanto a tomar tus medicamentos y seguir cualquier terapia
                 recomendada. Los broncodilatadores y los corticosteroides 
                 inhalados son ejemplos.
                <br>
                <br>
                3. Evitar climas demasiado fríos o calurosos, esto es para evitar
                 respiraciones continuas que puedan ahogarte o asfixiarte.
                <br>
                <br>
                4. Reaprender a hacer las tareas cotidianas a un ritmo más calmado.            </p>
        </div>
        <div class="col col-md-6">
            <img src="{{ asset('img/undraw_doctor_kw-5-l.svg') }}" alt="Asistente virtual" class="img-fluid" />
        </div> 
    </div>
    <br>
    <br>
    <div id="Panel2" class="row card ">
        <div class="col col-md-6">
            <h2 class="card-title">Causas y Síntomas</h2>
            <br>
            <br>
            <p class="h3"> Causas</p>
            <p class="text-start">
            Las principales causas de la EPOC son:
            <ul class="text-start">
                    <li>Tabaquismo: La causa más común de la EPOC es el tabaquismo prolongado, tanto activo como pasivo. Cuanto más tiempo haya fumado una persona y más cantidad de tabaco haya consumido, mayor será el riesgo de desarrollar la enfermedad.</li>
                    <li> Exposición laboral a polvos y productos químicos: Trabajadores expuestos a ciertas sustancias químicas, polvos o fibras en sus lugares de trabajo pueden tener un riesgo elevado de EPOC, incluso si no fuman.</li>
                    <li>Factores genéticos: Hay una condición rara llamada deficiencia de alfa-1 antitripsina que aumenta el riesgo de EPOC y otros problemas pulmonares.</li>
                    <li> Exposición prolongada a la contaminación del aire: Vivir en áreas con alta contaminación del aire o estar expuesto regularmente a leña o carbón quemado para cocinar y calentar también puede contribuir al desarrollo de EPOC.</li>
                </ul>
            </p>
            <p class="h3"> Síntomas</p>
            <p class="text-start">
            Los síntomas de la EPOC pueden variar, pero generalmente incluyen:
                <ul class="text-start">
                    <li>Tos persistente con o sin moco.</li>
                    <li>Dificultad para respirar, especialmente durante la actividad física.</li>
                    <li>Silbidos al respirar.</li>
                    <li>Opresión en el pecho.</li>
                    <li>Frecuentes infecciones respiratorias.</li>
                    <li>Fatiga y falta de energía.</li>
                    <li>Pérdida de peso inexplicada (en etapas avanzadas).</li>
                </ul>
            </p>
        </div>
        <div class="col col-md-6">
            <img src="{{ asset('img/undraw_medical_care_movn.svg') }}" alt="Asistente virtual" class="img-fluid" />
        </div>
    </div>
    
    <br>
    <br>
    <div id="Panel3" class="row card ">
        <div class="col col-md-5">
            <h4 class="card-title">Recomendaciones sobre la alimentación y actividades cotidianas:</h4>
            <br>
            <br>
            <p style="text-align: left;">1.Realiza tres comidas completas al día en horarios regulares, cuidando el tamaño de las porciones. 
                <br>
                <br>
                2. Consume alimentos naturales y evita alimentos industrializados. Prefiere verduras y frutas frescas de temporada.
<br>
<br>
                3. Incorpora a diario alimentos de todos los grupos y realiza al menos 30 minutos de actividad física. No olvides tomar a diario 8 vasos de agua para mantenerte hidratado siempre. 
                 <br>
                 <br>
                 4.Consume a diario 5 porciones de frutas y verduras en variedad de tipos y colores. Reduce el uso de sal y el consumo de alimentos con alto contenido de sodio.
            </p>
        </div>
        <div class="col col-md-5">
            <img src="{{ asset('img/undraw_healthy_lifestyle_re_ifwg.svg') }}" alt="Asistente virtual" class="img-fluid" />
        </div>
    </div>

        <br>
        <br>
        <div id="Panel4" class="row card ">
            <div class="col col-md-5">
                <h5 class="card-title">Ejercicio y manejo de la EPOC</h5>
                <br>
                <br>
                <p style="text-align: left;">1.Habla con tu médico: Es
                 posible que te pida que hagas ejercicios específicos y
                  te ayudará a establecer no solo la frecuencia y la 
                  duración de tus ejercicios, sino también tus metas 
                  del programa de ejercicios a largo plazo.
                    <br>
                    <br>
                    2. Comienza lentamente y gradualmente: Para 
                    cada ejercicio, controla durante cuánto tiempo
                     puedes hacerlo o cuenta la cantidad de veces 
                     que puedes hacerlo antes de sentir una leve 
                     falta de aliento. Luego descansa y pasa al 
                     siguiente ejercicio. Cada semana, aumenta el 
                     tiempo que pasas haciendo cada ejercicio o la 
                     cantidad de veces que haces cada uno.
                     
                </p>
            </div>
            <div class="col col-md-6">
                <img src="{{ asset('img/undraw_working_out_re_nhkg.svg') }}" alt="Asistente virtual" class="img-fluid" />
            </div>
        </div>
        <br>
        <br>
        <div id="Panel5" class="row card ">
            <div class="col col-md-5">
                <h5 class="card-title">Información actualizada:</h5>
                <br>
                <br>
                <p style="text-align: left;">Te adjuntamos algunos enlaces de información adicionales por si deseas saber más sobre la EPOC.




<br>
                    <div class="col d-flex  flex-column align-items-start"> 
                        <a href="https://gruporespiratoriointegramedica.wordpress.com/2023/05/11/epoc-como-ha-cambiado-en-los-ultimos-10-anos/" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">EPOC: ¡Cómo ha cambiado en los últimos 10 años!
                        <a href="https://www.livemed.in/es/blog/nueva-definicion-de-la-enfermedad-pulmonar-obstructiva-cronica-y-otras-actualizaciones-de-la-iniciativa-global-gold-2022/" class=" btn btn-secondary mb-2 btn-lg p-2 m-4">Nueva definición de la enfermedad pulmonar obstructiva crónica </a>
                    </div>
                </p>
            </div>
            <div class="col col-md-6">
                <img src="{{ asset('img/undraw_doctors_p6aq.svg') }}" alt="Asistente virtual" class="img-fluid" />
            </div>
        </div>
        <br>
        <br>
</div>
    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    
        window.addEventListener('scroll', function () {
            var scrollToTopButton = document.getElementById('scrollToTopButton');
            if (window.scrollY > 50) {
                scrollToTopButton.classList.add('active');
            } else {
                scrollToTopButton.classList.remove('active');
            }
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

@endsection