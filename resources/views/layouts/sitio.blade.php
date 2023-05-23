<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Norris</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://kit.fontawesome.com/b57616fca1.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <script src="https://alcdn.msauth.net/browser/2.30.0/js/msal-browser.js"></script>

<meta name="google-signin-client_id" content="918911739694-hruh3bkohbgntm7aguhesiipupf199aa.apps.googleusercontent.com">
<style>
    .img-mediano {
  width: 50%;
  max-width: 500px;
  height: auto;
  display: block;
  margin: 0 auto;
  body {
	font-family: 'Roboto', sans-serif;
	font-size: 16px;
	line-height: 1.4;
	background-color: #e5e7e9;
}
}
</style>
</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('Norris') }}">Norris</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="fuentes collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active"  href="{{ route('Norris') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Asociados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Quienes somos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Preguntas frecuentes</a>
                        </li>
                        
                        <li class="nav-item navbar-margin">
                        <a class="nav-link" href="{{ route('login') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 18 18">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                              </svg>     Iniciar Sesion</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('register') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 18 18">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                              </svg>     Registrate</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="fb-root"></div>
        @yield('content')
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2023 Norris. Todos los derechos reservados.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Inicio</a></li>
                <li class="list-inline-item"><a href="#">Asociados</a></li>
                <li class="list-inline-item"><a href="#">Quiénes somos</a></li>
                <li class="list-inline-item"><a href="#">Preguntas frecuentes</a></li>
            </ul>
        </div>
    </footer>
    @yield('scripts')
</body>

</html>

